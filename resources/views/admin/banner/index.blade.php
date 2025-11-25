@extends('admin.layouts.app')
@section('header')
    Banner
@endsection
@section('content')
    <div class="">

        <div class="flex items-end justify-end">
            <button command="show-modal" commandfor="createBanner"
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
        @include('admin.banner.create')


        <div class="overflow-x-auto max-h-[70vh] overflow-y-auto my-scroll">
            <table class="min-w-full border border-gray-200">
                <thead class="sticky top-0 z-10 bg-white text-black">
                    <tr>
                        <th class="text-left py-3 px-4 text-[12px] border-r border-[#fff] w-1/4">Image</th>
                        <th class="text-left py-3 px-4 text-[12px] border-r border-[#fff] w-1/4">Action</th>
                    </tr>
                </thead>

                <tbody class="text-gray-700 max-h-[40vh] overflow-y-auto">
                    @foreach ($banners as $index => $banner)
                        <tr class="">
                            <td class="text-left py-3 px-4 text-[12px] md:text-[14px]">
                                @if ($banner->file_type == 'image')
                                    <img src="{{ asset('assets/banner/' . $banner->file) }}" class="w-40 h-auto">
                                @else
                                    <video src="{{ asset('assets/banner/' . $banner->file) }}" class="w-40" controls></video>
                                @endif
                            </td>

                            <td class="text-left py-3 px-4">
                                <div class="flex items-center gap-2">
                                    <button command="show-modal" commandfor="editType{{ $banner->id }}"
                                        class="flex items-center gap-2 bg-[#613bf1] text-[#fff] px-3 py-1 text-[12px] rounded-md">
                                        <img src="{{ asset('assets/images/icons/edit.svg') }}" alt="" class="w-4 h-4">
                                        Edit
                                    </button>
                                    @include('admin.banner.edit')


                                    <a class="text-red-500" href="{{ route('banner.delete', $banner->id) }}" title="Delete"
                                        onclick="event.preventDefault(); deleteRecord('{{ route('banner.delete', $banner->id) }}')">
                                        <img src="{{ asset('assets/images/icons/trash.svg') }}" alt="" class="w-5 h-5">
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
@endsection