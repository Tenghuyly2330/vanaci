@extends('layouts.master')

@section('content')
    <!-- Banner Section -->
    <section class="relative h-screen md:h-[140vh] flex items-center justify-center text-center overflow-x-hidden">
        <div class="w-full h-full absolute inset-0">
            <div class="swiper mySwiper h-full">
                <div class="swiper-wrapper h-full">
                    @foreach ($bannerSlide as $item)
                        <div class="swiper-slide h-full">
                            @if ($item->file_type == 'image')
                                <img src="{{ asset('assets/banner/' . $item->file) }}" class="w-full h-full object-cover">
                            @else
                                <video src="{{ asset('assets/banner/' . $item->file) }}" class="w-full h-full object-cover" autoplay
                                    muted loop></video>
                            @endif
                        </div>
                    @endforeach
                </div>

                <div class="swiper-pagination"></div>
            </div>
        </div>

        <div class="text-white z-30">
            <div class="text-[#fff] z-30">
                <div class="flex justify-center items-center gap-2 mb-2">
                    <img src="{{ asset('assets/images/logo-vanaci-w.png') }}" alt="" class="w-[20rem] md:w-[25rem]">
                </div>

                <p class="text-[14px] md:text-[20px] lg:text-[30px] tracking-[5px] md:tracking-[10px] font-[400]">DIGNIFIED
                    PROPRIETY</p>
            </div>
            <h1 class="text-[30px] md:text-[60px] font-[400] tracking-widest">
                Explore
            </h1>
        </div>
    </section>

    <!-- Items Section -->
    <section>
        @forelse ($orderedGroupedItems as $typeName => $items)
            <div class="px-4 py-8">
                <div class="mb-5">

                   {{-- Show type image only if type is not MEN --}}
                @if ($items->first()->type->type != 'Men')
                    <img src="{{ asset('assets/type/' . $items->first()->type->image) }}" 
                        alt="" 
                        class="w-full object-cover">
                @endif
                    

                </div>
                <h2 class="text-[20px] md:text-[24px] font-[400] text-center mb-6 tracking-wide">{{ $typeName }}</h2>
                {{-- Items --}}
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-4 px-4 max-w-7xl mx-auto pt-10">
                    @foreach ($items as $item)
                        @php
                            $sizes = is_array($item->size) ? $item->size : json_decode($item->size ?? '[]', true);
                            $colors = is_array($item->color) ? $item->color : json_decode($item->color ?? '[]', true);
                            $firstColor = $colors[0] ?? null;
                            // $firstCode = $firstColor['code'] ?? null;
                            $firstName = $firstColor['name'] ?? null;
                            $firstImage = $firstColor['images'][0] ?? null;
                        @endphp

                        <div class="rounded overflow-hidden relative bg-white">
                            <a href="{{ route('item.show', $item->slug) }}" class="relative block">
                                @if ($firstImage)
                                    <img src="{{ asset($firstImage) }}" alt="{{ $firstColor['name'] ?? 'Color' }}"
                                        class="w-full h-[300px] lg:h-[400px] sm:h-[400px] xl:h-[500px] object-cover">
                                @else
                                    <img src="{{ asset('assets/images/default.jpg') }}" alt=""
                                        class="w-full h-[300px] lg:h-[400px] md:h-[400px] xl:h-[500px] object-cover">
                                @endif

                                @if ($item->discount && $item->discount > 0)
                                    <span class="absolute top-2 right-2 bg-green-600 text-white text-[10px] px-2 py-1 rounded">
                                        -{{ number_format($item->discount, 0) }}%
                                    </span>
                                @endif
                            </a>

                            <div class="flex items-start justify-between p-2 mt-auto">
                                <div>
                                    <div class="h-[20px]">
                                        @if ($item->status)
                                            <p class="text-[14px] inline-block py-1 uppercase">New</p>
                                        @endif
                                    </div>

                                    <p class="text-[14px] uppercase py-1">{{ $item->name }}</p>

                                    <p class="text-[14px] font-semibold">
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
                                            <span class="line-through text-gray-500 text-[14px] pl-2">
                                                ${{ number_format($item->price, 2) }}
                                            </span>
                                        @else
                                            ${{ number_format($item->price, 2) }}
                                        @endif
                                    </p>
                                </div>

                                <div x-data="{ showSizes: false, selectedSize: null }" @click.outside="showSizes = false"
                                    class="relative">

                                    @if (!empty($sizes))
                                        <!-- 🟢 Has sizes -->
                                        <button @click="showSizes = !showSizes" class="rounded mt-2 w-full">
                                            <svg class="w-5 h-5" viewBox="0 0 6 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M1.17606 1.4942H0.779054C0.504719 1.4942 0.277003 1.70623 0.257429 1.97997L0.00132482 5.56605C-0.00898516 5.71083 0.0412178 5.85338 0.140134 5.95962C0.239199 6.06586 0.377713 6.12622 0.52295 6.12622H4.66248C4.80771 6.12622 4.94623 6.06586 5.04529 5.95962C5.14421 5.85338 5.19441 5.71083 5.1841 5.56605L4.928 1.97997C4.90842 1.70623 4.68071 1.4942 4.40637 1.4942H4.0122V1.41949C4.0122 0.635483 3.37672 0 2.59271 0C1.8374 0 1.13931 0.601565 1.17322 1.41949C1.17427 1.44429 1.17517 1.46925 1.17606 1.4942ZM4.0122 1.94246V3.06311C4.0122 3.18683 3.91179 3.28724 3.78807 3.28724C3.66435 3.28724 3.56394 3.18683 3.56394 3.06311V1.94246H1.62148V3.06311C1.62148 3.18683 1.52107 3.28724 1.39735 3.28724C1.27363 3.28724 1.17322 3.18683 1.17322 3.06311C1.17322 3.06311 1.19265 2.53939 1.18622 1.94246H0.779054C0.739906 1.94246 0.707334 1.97279 0.704645 2.01179L0.448386 5.59787C0.446891 5.61864 0.454067 5.63896 0.468262 5.6542C0.482457 5.66929 0.50218 5.67796 0.52295 5.67796H4.66248C4.68325 5.67796 4.70297 5.66929 4.71717 5.6542C4.73136 5.63896 4.73854 5.61864 4.73704 5.59787L4.48078 2.01179C4.47809 1.97279 4.44552 1.94246 4.40637 1.94246H4.0122ZM3.56394 1.4942V1.41949C3.56394 0.883072 3.12913 0.44826 2.59271 0.44826C2.0563 0.44826 1.62148 0.883072 1.62148 1.41949V1.4942H3.56394Z"
                                                    fill="black" />
                                            </svg>
                                        </button>

                                        <div x-show="showSizes" x-transition
                                            class="absolute bottom-full mb-4 -left-7 bg-white border rounded z-30 overflow-hidden">
                                            <div class="flex flex-col gap-2 p-2">
                                                @foreach ($sizes as $size)
                                                    <button
                                                        @click="
                                                            selectedSize = '{{ $size }}';
                                                            $store.cart.add({
                                                                id: '{{ $item->id }}',
                                                                name: '{{ $item->name }}',
                                                                price: {{ $item->price }},
                                                                discount: {{ $item->discount ?? 0 }},
                                                                image: '{{ $firstImage ? asset($firstImage) : asset('assets/images/default.jpg') }}',
                                                                slug: '{{ $item->slug }}',
                                                                size: '{{ $size }}',
                                                                color: '{{ $firstName }}'
                                                            });
                                                            showSizes = false;
                                                        "
                                                        class='border px-2 py-1 rounded text-[12px] uppercase hover:bg-black hover:text-white transition'>
                                                        {{ $size }}
                                                    </button>
                                                @endforeach
                                            </div>
                                        </div>
                                    @else
                                        <!-- 🔴 No sizes — Add directly to cart -->
                                        <button
                                            @click="
                                                $store.cart.add({
                                                    id: '{{ $item->id }}',
                                                    name: '{{ $item->name }}',
                                                    price: {{ $item->price }},
                                                    discount: {{ $item->discount ?? 0 }},
                                                    image: '{{ $firstImage ? asset($firstImage) : asset('assets/images/default.jpg') }}',
                                                    slug: '{{ $item->slug }}',
                                                    size: '',
                                                    color: '{{ $firstName }}'
                                                });
                                            "
                                            class="rounded mt-2 w-full">
                                            <svg class="w-5 h-5" viewBox="0 0 6 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M1.17606 1.4942H0.779054C0.504719 1.4942 0.277003 1.70623 0.257429 1.97997L0.00132482 5.56605C-0.00898516 5.71083 0.0412178 5.85338 0.140134 5.95962C0.239199 6.06586 0.377713 6.12622 0.52295 6.12622H4.66248C4.80771 6.12622 4.94623 6.06586 5.04529 5.95962C5.14421 5.85338 5.19441 5.71083 5.1841 5.56605L4.928 1.97997C4.90842 1.70623 4.68071 1.4942 4.40637 1.4942H4.0122V1.41949C4.0122 0.635483 3.37672 0 2.59271 0C1.8374 0 1.13931 0.601565 1.17322 1.41949C1.17427 1.44429 1.17517 1.46925 1.17606 1.4942ZM4.0122 1.94246V3.06311C4.0122 3.18683 3.91179 3.28724 3.78807 3.28724C3.66435 3.28724 3.56394 3.18683 3.56394 3.06311V1.94246H1.62148V3.06311C1.62148 3.18683 1.52107 3.28724 1.39735 3.28724C1.27363 3.28724 1.17322 3.18683 1.17322 3.06311C1.17322 3.06311 1.19265 2.53939 1.18622 1.94246H0.779054C0.739906 1.94246 0.707334 1.97279 0.704645 2.01179L0.448386 5.59787C0.446891 5.61864 0.454067 5.63896 0.468262 5.6542C0.482457 5.66929 0.50218 5.67796 0.52295 5.67796H4.66248C4.68325 5.67796 4.70297 5.66929 4.71717 5.6542C4.73136 5.63896 4.73854 5.61864 4.73704 5.59787L4.48078 2.01179C4.47809 1.97279 4.44552 1.94246 4.40637 1.94246H4.0122ZM3.56394 1.4942V1.41949C3.56394 0.883072 3.12913 0.44826 2.59271 0.44826C2.0563 0.44826 1.62148 0.883072 1.62148 1.41949V1.4942H3.56394Z"
                                                    fill="black" />
                                            </svg>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <p class="text-center text-gray-500 py-20">No items available.</p>
        @endforelse
        <div class="hidden md:flex justify-center items-center">
            <svg width="4" height="136" viewBox="0 0 4 136" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect width="4" height="136" fill="black" />
            </svg>
        </div>
    </section>
@endsection