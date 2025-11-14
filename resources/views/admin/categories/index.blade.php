@extends('admin.layouts.app')
@section('header')
    Category
@endsection
@section('content')
    <div class="">
        <div class="flex items-center justify-between ">
            <!-- Filter Form -->
            <form method="GET" action="{{ route('category.index') }}" id="typeFilterForm"
                class="mb-4 flex items-center gap-3 rounded-xl border border-gray-200">

                <label for="type_filter" class="text-sm font-semibold text-gray-600">
                    Filter by Type:
                </label>

                <select name="type_id" id="type_filter"
                    class="border border-gray-300 rounded-lg px-3 py-1.5 text-sm focus:outline-none focus:ring focus:ring-blue-200 transition"
                    onchange="document.getElementById('typeFilterForm').submit()">

                    <option value="" {{ request('type_id') == null ? 'selected' : '' }}>
                        All
                    </option>

                    @foreach ($types as $type)
                        <option value="{{ $type->id }}" {{ request('type_id') == $type->id ? 'selected' : '' }}>
                            {{ $type->type }}
                        </option>
                    @endforeach
                </select>

                @if (request('type_id'))
                    <a href="{{ route('category.index') }}" class="text-sm text-red-500 hover:text-red-600 underline">
                        Clear
                    </a>
                @endif
            </form>


            <!-- Add New Button -->
            <button command="show-modal" commandfor="createCategory"
                class="bg-[#613bf1] text-[#fff] flex items-center gap-4 px-4 py-2 mb-4 rounded-[5px] text-[12px] sm:text-[14px]">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#fff">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <path d="M6 12H18M12 6V18" stroke="#fff" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round"></path>
                    </g>
                </svg>
                <span class="">Add new</span>
            </button>
        </div>

        @component('admin.components.alert')
        @endcomponent

        @include('admin.categories.create')

        <div class="overflow-x-auto max-h-[70vh] overflow-y-auto my-scroll">
            <table class="min-w-full border border-gray-200">
                <thead class="sticky top-0 z-10 bg-white text-black">
                    <tr>
                        <th class="text-left py-3 px-4 text-[12px] border-r border-[#fff] w-2/5">Name</th>
                        <th class="text-left py-3 px-4 text-[12px] border-r border-[#fff] w-2/5">Type</th>
                        <th class="text-left py-3 px-4 text-[12px] border-r border-[#fff] w-1/5">Action</th>
                    </tr>
                </thead>

                <tbody class="text-gray-700 max-h-[40vh] overflow-y-auto">
                    @foreach ($categories as $category)
                        <tr class="">
                            <td class="text-left py-3 px-4 text-[12px] md:text-[14px]">
                                {{ $category->name }}
                            </td>
                            <td class="text-left py-3 px-4 text-[12px] md:text-[14px]">
                                {{ $category->type_name }}
                            </td>

                            <td class="text-left py-3 px-4">
                                <div class="flex items-center gap-2">
                                    <button command="show-modal" commandfor="editCategory{{ $category->id }}"
                                        class="flex items-center gap-2 bg-[#613bf1] text-[#fff] px-3 py-1 text-[12px] rounded-md">
                                        <img src="{{ asset('assets/images/icons/edit.svg') }}" alt=""
                                            class="w-4 h-4">
                                        <p>Edit</p>
                                    </button>
                                    @include('admin.categories.edit')
                                    <a class="text-red-500" href="{{ route('category.delete', $category->id) }}"
                                        title="Delete"
                                        onclick="event.preventDefault(); deleteRecord('{{ route('category.delete', $category->id) }}')">
                                        <img src="{{ asset('assets/images/icons/trash.svg') }}" alt=""
                                            class="w-5 h-5">
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- <div class="pt-2 pb-4">
            {{ $categories->links('vendor.pagination.custom') }}
        </div> --}}
    </div>
@endsection
