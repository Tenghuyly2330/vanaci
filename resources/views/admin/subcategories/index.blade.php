@extends('admin.layouts.app')
@section('header')
    Category
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

            <a href="{{ route('subcategory.create') }}"
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
                        <th class="text-left py-3 px-4 text-[12px] text-gray-500 w-2/7">Name</th>
                        <th class="text-left py-3 px-4 text-[12px] text-gray-500 w-2/7">Category</th>
                        <th class="text-left py-3 px-4 text-[12px] text-gray-500 w-2/7">Type</th>
                        <th class="text-left py-3 px-4 text-[12px] text-gray-500 w-1/7">Action</th>
                    </tr>
                </thead>

                <tbody class="text-gray-700 max-h-[40vh] overflow-y-auto">
                    @forelse ($subcategories as $index => $subcategory)
                        <tr class="">
                            <td class="text-left py-3 px-4 text-[12px] md:text-[14px]">
                                {{ $subcategory->name }}
                            </td>
                            <td class="text-left py-3 px-4 text-[12px] md:text-[14px]">
                                {{ $subcategory->category->name ?? '—' }}

                            </td>
                            <td class="text-left py-3 px-4 text-[12px] md:text-[14px]">
                                {{ $subcategory->type->type ?? '—' }}

                            </td>

                            <td class="text-left py-3 px-4">
                                <div class="flex items-center gap-2">

                                    <a class="flex items-center gap-2 bg-[#613bf1] text-[#fff] px-3 py-1 text-[12px] rounded-md"
                                        href="{{ route('subcategory.edit', array_merge(['subcategory' => $subcategory->id], request()->only(['page']))) }}"
                                        title="Edit">
                                        <img src="{{ asset('assets/images/icons/edit.svg') }}" alt=""
                                            class="w-4 h-4">
                                        <p>Edit</p>
                                    </a>
                                    <a href="{{ route('subcategory.delete', $subcategory->id) }}" title="Delete"
                                        onclick="event.preventDefault(); deleteRecord('{{ route('subcategory.delete', $subcategory->id) }}?page={{ request()->page }}')">
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
    </div>
@endsection
