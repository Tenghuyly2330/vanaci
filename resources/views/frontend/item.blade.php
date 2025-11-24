@extends('layouts.master')

@section('content')
    <section class="relative h-screen flex items-center justify-center text-center">

        {{-- <div class="w-full h-full absolute inset-0">
            <img src="{{ asset('assets/images/banner-2.png') }}" alt="" class="w-full h-full object-cover">
        </div> --}}
        @if ($typeName == 'Men')
            <div class="w-full h-full absolute inset-0">
                <img src="{{ asset('assets/images/banner-2.png') }}" alt="" class="w-full h-full object-cover">
            </div>
        @elseif ($typeName == 'Women')
            <div class="w-full h-full absolute inset-0">
                <img src="{{ asset('assets/images/banner-1.jpg') }}" alt="" class="w-full h-full object-cover">
            </div>
        @else
            <div class="w-full h-full absolute inset-0">
                <img src="{{ asset('assets/images/banner-2.png') }}" alt="" class="w-full h-full object-cover">
            </div>
        @endif

        <div class="text-white z-30">
            <h1 class="text-[40px] font-[200] tracking-widest">
                <h1 class="text-[40px] font-[200] tracking-[5px]">
                    @if ($categoryName)
                        {{ $categoryName }}
                    @else
                        {{ $typeName ?? 'New Arrivals' }}
                    @endif
                </h1>
            </h1>
        </div>
    </section>

    <section>
        @if ($subcategories->count())
            <div class="flex space-x-2 mt-10 px-4">
                @if ($type && $category)
                    <a href="{{ route('item', ['type' => $type->slug, 'category' => $category->slug]) }}"
                        class="px-3 py-1 text-[14px] md:text-[16px] {{ !$subcategory ? 'font-[700] border-[#000] border-b-2' : '' }}">
                        View All
                    </a>
                @endif

                @foreach ($subcategories as $sub)
                    <a href="{{ route('item', ['type' => $type->slug ?? null, 'category' => $category->slug ?? null, 'subcategory' => $sub->slug]) }}"
                        class="px-3 py-1 text-[14px] md:text-[16px] {{ isset($subcategory) && $subcategory->id == $sub->id ? 'font-[700] border-[#000] border-b-2' : '' }}">
                        {{ $sub->name }}
                    </a>
                @endforeach
            </div>
        @endif

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-4 px-4 max-w-7xl mx-auto py-10">
            @forelse ($items as $item)
                @php
                    $sizes = is_array($item->size) ? $item->size : json_decode($item->size ?? '[]', true);
                    $colors = is_array($item->color) ? $item->color : json_decode($item->color ?? '[]', true);
                @endphp

                <div class="overflow-hidden relative">
                    <a href="{{ route('item.show', $item->slug) }}" class="relative block border border-gray-300">
                        @php
                            $colors = $item->color ?? [];
                            $firstColor = $colors[0] ?? null;
                            $firstCode = $firstColor['code'] ?? null;
                            $firstName = $firstColor['name'] ?? null;
                            $firstImage = $firstColor['images'][0] ?? null;
                        @endphp

                        @if ($firstImage)
                            <div class="flex items-center gap-3">
                                <img src="{{ asset($firstImage) }}" alt="{{ $firstColor['name'] ?? 'Color' }}"
                                    class="w-full h-[300px] lg:h-[400px] sm:h-[400px] xl:h-[500px] object-cover">
                            </div>
                        @else
                            <img src="{{ asset('assets/images/default.jpg') }}" alt=""
                                class="w-full h-[300px] lg:h-[400px] md:h-[400px] xl:h-[500px] object-cover">
                        @endif

                        @if ($item->discount && $item->discount > 0)
                            @php
                                // Discount is a percentage
                                $discountedPrice = $item->price * (1 - $item->discount / 100);
                            @endphp
                            <!-- Discount badge -->
                            <span class="absolute top-2 right-2 bg-green-500 text-white text-[14px] px-2 py-1 rounded">
                                {{ number_format($item->discount, 0) }}%
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
                                    <span class="line-through text-gray-500 font-[400] text-[14px] pl-2">
                                        ${{ number_format($item->price, 2) }}
                                    </span>
                                @else
                                    ${{ number_format($item->price, 2) }}
                                @endif
                            </p>
                        </div>

                        <div>
                            <button x-data="{ added: $store.favorite.items.some(i => i.id == '{{ $item->id }}') }"
                                @click="
                                    added = !added;
                                    if (added) {
                                        $store.favorite.add({
                                            id: '{{ $item->id }}',
                                            name: '{{ $item->name }}',
                                            price: {{ $item->price }},
                                            image: '{{ $firstImage ? asset($firstImage) : asset('assets/images/default.jpg') }}',
                                            discount: {{ $item->discount ?? 0 }},
                                            status: {{ $item->status ? 'true' : 'false' }},
                                            slug: '{{ $item->slug }}'
                                        });
                                    } else {
                                        $store.cart.remove('{{ $item->id }}');
                                    }
                                "
                                class="w-[32px] h-[32px] flex items-center justify-center transition relative">
                                <!-- Default Cart Icon -->
                                <svg x-show="!added" x-cloak class="w-5 h-5 absolute inset-0 m-auto" viewBox="0 0 6 7"
                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M1.17606 1.4942H0.779054C0.504719 1.4942 0.277003 1.70623 0.257429 1.97997L0.00132482 5.56605C-0.00898516 5.71083 0.0412178 5.85338 0.140134 5.95962C0.239199 6.06586 0.377713 6.12622 0.52295 6.12622H4.66248C4.80771 6.12622 4.94623 6.06586 5.04529 5.95962C5.14421 5.85338 5.19441 5.71083 5.1841 5.56605L4.928 1.97997C4.90842 1.70623 4.68071 1.4942 4.40637 1.4942H4.0122V1.41949C4.0122 0.635483 3.37672 0 2.59271 0C1.8374 0 1.13931 0.601565 1.17322 1.41949C1.17427 1.44429 1.17517 1.46925 1.17606 1.4942ZM4.0122 1.94246V3.06311C4.0122 3.18683 3.91179 3.28724 3.78807 3.28724C3.66435 3.28724 3.56394 3.18683 3.56394 3.06311V1.94246H1.62148V3.06311C1.62148 3.18683 1.52107 3.28724 1.39735 3.28724C1.27363 3.28724 1.17322 3.18683 1.17322 3.06311C1.17322 3.06311 1.19265 2.53939 1.18622 1.94246H0.779054C0.739906 1.94246 0.707334 1.97279 0.704645 2.01179L0.448386 5.59787C0.446891 5.61864 0.454067 5.63896 0.468262 5.6542C0.482457 5.66929 0.50218 5.67796 0.52295 5.67796H4.66248C4.68325 5.67796 4.70297 5.66929 4.71717 5.6542C4.73136 5.63896 4.73854 5.61864 4.73704 5.59787L4.48078 2.01179C4.47809 1.97279 4.44552 1.94246 4.40637 1.94246H4.0122ZM3.56394 1.4942V1.41949C3.56394 0.883072 3.12913 0.44826 2.59271 0.44826C2.0563 0.44826 1.62148 0.883072 1.62148 1.41949V1.4942H3.56394Z"
                                        fill="black" />
                                </svg>

                                <!-- Added / Check Icon -->
                                <svg x-show="added" x-cloak class="w-5 h-5 absolute inset-0 m-auto" viewBox="0 0 6 7" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M1.18056 1.49991H0.782031C0.506648 1.49991 0.278062 1.71275 0.258413 1.98753L0.00132988 5.58732C-0.0090195 5.73266 0.0413753 5.87575 0.140669 5.9824C0.240113 6.08904 0.379157 6.14963 0.524948 6.14963H4.6803C4.82609 6.14963 4.96513 6.08904 5.06458 5.9824C5.16387 5.87575 5.21427 5.73266 5.20392 5.58732L4.94683 1.98753C4.92718 1.71275 4.6986 1.49991 4.42321 1.49991H4.02754V1.42492C4.02754 0.637912 3.38963 0 2.60262 0C1.84442 0 1.14366 0.603864 1.17771 1.42492C1.17876 1.44981 1.17966 1.47486 1.18056 1.49991ZM3.57756 1.49991V1.42492C3.57756 0.886447 3.14109 0.449973 2.60262 0.449973C2.06416 0.449973 1.62768 0.886447 1.62768 1.42492V1.49991H3.57756Z"
                                        fill="black" />
                                </svg>
                            </button>

                        </div>
                    </div>
                </div>
            @empty
                <p class="col-span-2 text-center text-gray-500 py-10">
                    No items available in this category.
                </p>
            @endforelse
        </div>
         <div class="hidden md:flex justify-center items-center">
            <svg width="4" height="136" viewBox="0 0 4 136" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect width="4" height="136" fill="black" />
            </svg>
        </div>
    </section>
@endsection
