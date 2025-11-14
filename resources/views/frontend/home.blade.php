@extends('layouts.master')
@section('content')
    <section class="relative h-screen flex items-center justify-center text-center">
        <div class="w-full h-full absolute inset-0">
            <img src="{{ asset('assets/images/banner-1.png') }}" alt="" class="w-full h-full object-cover">
        </div>

        <div class="text-[#fff] z-30">
            <h1 class="text-[50px] font-[600] uppercase tracking-widest">vanaci</h1>
            <p class="tracking-[5px] font-[200]">DIGNIFIED PROPRIETY</p>

            <div class="pt-8">
                <a href="{{ route('explore') }}" class="py-3 px-8 bg-white text-black">Explore</a>
            </div>
        </div>
    </section>
@endsection
