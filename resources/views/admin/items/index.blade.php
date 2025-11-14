@extends('admin.layouts.app')
@section('header')
    Item
@endsection
@section('content')
    <style>
        .my-scroll::-webkit-scrollbar {
            width: 4px;
        }

        .my-scroll::-webkit-scrollbar-track {
            background: #fff;
        }

        .my-scroll::-webkit-scrollbar-thumb {
            background: #64748b;
            border-radius: 10px;
        }
    </style>
    <div class="">
        <div class="my-4 flex items-center gap-4 justify-end">
            <form method="GET" action="{{ route('item_backend.index') }}" id="filterForm"
                class="flex flex-col md:flex-row gap-4 items-end">

                <!-- Search -->
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by product name"
                    class="border border-gray-300 rounded-lg px-4 py-2 text-[12px] sm:text-[14px] focus:outline-none transition duration-300 w-full md:w-auto"
                    oninput="document.getElementById('filterForm').submit()">

                <!-- Type Filter -->
                <div x-data="{ open: false }" class="relative w-full md:w-auto">
                    <select name="type_id" x-on:focus="open = true" x-on:blur="open = false"
                        class="appearance-none border border-gray-300 rounded-lg px-4 py-2 pr-10 text-[12px] sm:text-[14px] focus:outline-none transition duration-300 bg-white cursor-pointer"
                        onchange="document.getElementById('filterForm').submit()">
                        <option value="">All Types</option>
                        @foreach ($types as $type)
                            <option value="{{ $type->id }}" @if (request('type_id') == $type->id) selected @endif>
                                {{ $type->type }}
                            </option>
                        @endforeach
                    </select>
                    <!-- Arrow -->
                    <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center">
                        <svg :class="open ? 'rotate-180 text-blue-500' : 'rotate-0 text-gray-500'"
                            class="w-5 h-5 transition-transform transition-colors duration-300" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>

                <!-- Category Filter -->
                <div x-data="{ open: false }" class="relative w-full md:w-auto">
                    <select name="category_id" x-on:focus="open = true" x-on:blur="open = false"
                        class="appearance-none border border-gray-300 rounded-lg px-4 py-2 pr-10 text-[12px] sm:text-[14px] focus:outline-none transition duration-300 bg-white cursor-pointer"
                        onchange="document.getElementById('filterForm').submit()">
                        <option value="">All Categories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @if (request('category_id') == $category->id) selected @endif>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    <!-- Arrow -->
                    <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center">
                        <svg :class="open ? 'rotate-180 text-blue-500' : 'rotate-0 text-gray-500'"
                            class="w-5 h-5 transition-transform transition-colors duration-300" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>
            </form>

            <a href="{{ route('item_backend.create') }}"
                class="bg-[#613bf1] text-[#fff] flex items-center gap-4 px-4 py-2 rounded-[5px] text-[12px] sm:text-[14px]">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#fff">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <path d="M6 12H18M12 6V18" stroke="#fff" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"></path>
                    </g>
                </svg>
                <span class="">Add new</span>
            </a>
        </div>

        @component('admin.components.alert')
        @endcomponent

        <div class="overflow-x-auto max-h-[70vh] overflow-y-auto my-scroll">
            <table class="min-w-full border border-gray-200">
                <thead class="text-white sticky top-0 z-10 bg-white">
                    <tr>
                        <th class="text-left py-3 px-4 text-[12px] text-gray-500 w-1/6">Product Name</th>
                        <th class="text-left py-3 px-4 text-[12px] text-gray-500 w-1/6">Price</th>
                        <th class="text-left py-3 px-4 text-[12px] text-gray-500 w-1/6">Size</th>
                        <th class="text-left py-3 px-4 text-[12px] text-gray-500 w-1/6">Color</th>
                        <th class="text-left py-3 px-4 text-[12px] text-gray-500 w-1/6">Status</th>
                        <th class="text-left py-3 px-4 text-[12px] text-gray-500 w-2/6">Action</th>
                    </tr>
                </thead>

                <tbody class="text-gray-700 max-h-[40vh] overflow-y-auto">
                    @forelse ($items as $index => $item)
                        @php
                            $sizes = is_array($item->size) ? $item->size : json_decode($item->size ?? '[]', true);
                            $colors = is_array($item->color) ? $item->color : json_decode($item->color ?? '[]', true);
                        @endphp


                        <tr class="">
                            <td class="text-left py-3 px-4 text-[12px] md:text-[14px] flex items-start gap-4">
                                <div>
                                    @if (!empty($colors))
                                        @php
                                            $firstColor = $colors[0];
                                            $firstImage = $firstColor['images'][0] ?? null;
                                        @endphp

                                        <div class="flex items-center gap-3">
                                            @if ($firstImage)
                                                <img src="{{ $firstImage }}" alt="{{ $firstColor['name'] ?? 'Color' }}"
                                                    class="w-12 h-14 object-cover rounded">
                                            @else
                                                <img src="{{ asset('assets/images/default.jpg') }}" alt=""
                                                    class="w-12 h-14 object-cover rounded">
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-gray-400 text-[12px]">—</span>
                                    @endif
                                </div>


                                <div class="flex flex-col justify-between h-12">
                                    <p class="p-0 uppercase">{{ $item->name }}</p>
                                    <p class="text-[12px]">{{ $item->type->type ?? '—' }} -
                                        {{ $item->category->name ?? '—' }}</p>
                                </div>

                            </td>
                            <td class="py-3 px-4 text-[12px] text-[#000]">
                                @if ($item->discount && $item->discount > 0)
                                    @php
                                        // Discount is a percentage
                                        $discountedPrice = $item->price * (1 - $item->discount / 100);
                                    @endphp
                                    {{-- Discounted price --}}
                                    <span class="text-[#000] font-semibold">
                                        ${{ number_format($discountedPrice, 2) }}
                                    </span>
                                    {{-- Original price with strikethrough --}}
                                    <span class="line-through text-red-500 pl-2">
                                        ${{ number_format($item->price, 2) }}
                                    </span>
                                    {{-- Discount percentage --}}
                                    <span class="text-green-600 font-semibold pl-2">
                                        ({{ number_format($item->discount, 0) }}% OFF)
                                    </span>
                                @else
                                    ${{ number_format($item->price, 2) }}
                                @endif
                            </td>


                            {{-- Sizes --}}
                            <td class="py-3 px-4">
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($sizes as $size)
                                        <span class="border border-gray-400 px-2 py-1 rounded text-[10px] uppercase">
                                            {{ $size }}
                                        </span>
                                    @endforeach
                                </div>
                            </td>

                            <td class="py-3 px-4">
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($colors as $color)
                                        <div class="flex items-center gap-2">
                                            {{-- Color box --}}
                                            <span class="inline-block w-4 h-4 rounded border border-gray-400"
                                                style="background-color: {{ $color['code'] ?? '#fff' }}"></span>
                                            {{-- Color name and code --}}
                                            {{-- <span class="text-[12px] uppercase">
                                                {{ $color['name'] ?? 'N/A' }} ({{ $color['code'] ?? '' }})
                                            </span> --}}
                                        </div>
                                    @endforeach
                                </div>
                            </td>

                            <td class="text-left py-3 px-4 text-[12px] md:text-[14px]">
                                @if ($item->status == 1)
                                    <span class="bg-green-500 text-white px-2 py-1 rounded text-[12px]">New</span>
                                @else
                                    <span class="bg-gray-300 text-gray-700 px-2 py-1 rounded text-[12px]">—</span>
                                @endif
                            </td>


                            <td class="text-left py-3 px-4">
                                <div class="flex items-center gap-2">

                                    <a class="flex items-center gap-2 bg-[#613bf1] text-[#fff] px-3 py-1 text-[12px] rounded-md"
                                        href="{{ route('item_backend.edit', array_merge(['item_backend' => $item->id], request()->only(['page']))) }}"
                                        title="Edit">
                                        <img src="{{ asset('assets/images/icons/edit.svg') }}" alt=""
                                            class="w-4 h-4">
                                        <p>Edit</p>
                                    </a>
                                    <a href="{{ route('item_backend.delete', $item->id) }}" title="Delete"
                                        onclick="event.preventDefault(); deleteRecord('{{ route('item_backend.delete', $item->id) }}?page={{ request()->page }}')">
                                        <img src="{{ asset('assets/images/icons/trash.svg') }}" alt=""
                                            class="w-5 h-5">
                                    </a>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-6 text-gray-500 text-[14px]">
                                No items available.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{-- <hr class="border-2 border-b-[#000] my-3"> --}}
        <div class="pt-2 pb-4">
            {{ $items->links('vendor.pagination.custom') }}
        </div>


    </div>
@endsection
