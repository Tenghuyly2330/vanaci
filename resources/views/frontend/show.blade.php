@extends('layouts.master')

@section('content')
    <section class="px-4 py-10" x-data="{
        colors: {{ json_encode(is_array($item->color) ? $item->color : json_decode($item->color ?? '[]', true)) }},
        selectedColorIndex: 0,
        selectedSize: null,
        slideIndex: 0,
        interval: null,
        startX: 0,
        endX: 0,

        get selectedColor() {
            return this.colors?.[this.selectedColorIndex] || null;
        },

        resetSlide() {
            this.slideIndex = 0;
        },

        nextSlide() {
            if (this.selectedColor?.images?.length > 1) {
                this.slideIndex = (this.slideIndex + 1) % this.selectedColor.images.length;
            }
        },

        prevSlide() {
            if (this.selectedColor?.images?.length > 1) {
                this.slideIndex = (this.slideIndex - 1 + this.selectedColor.images.length) % this.selectedColor.images.length;
            }
        },

        startAutoSlide() {
            if (this.interval) clearInterval(this.interval);
            if (this.selectedColor?.images?.length > 1) {
                this.interval = setInterval(() => this.nextSlide(), 4000);
            }
        },

        handleTouchStart(e) {
            this.startX = e.touches ? e.touches[0].clientX : e.clientX;
        },

        handleTouchMove(e) {
            this.endX = e.touches ? e.touches[0].clientX : e.clientX;
        },

        handleTouchEnd() {
            const diff = this.endX - this.startX;
            if (Math.abs(diff) > 50) {
                diff > 0 ? this.prevSlide() : this.nextSlide();
            }
        }
    }" x-init="startAutoSlide();
    $watch('selectedColorIndex', () => {
        resetSlide();
        startAutoSlide();
    })">
        <h1 class="text-[16px] mb-6 uppercase text-center">Item</h1>
        <div class="max-w-6xl mx-auto grid grid-cols-2 gap-4">
            <!-- IMAGE SLIDER -->
            <div class="relative flex flex-col items-center select-none">
                <div class="relative w-full overflow-hidden" @mouseenter="if (interval) clearInterval(interval)"
                    @mouseleave="startAutoSlide()" @mousedown="handleTouchStart($event)" @mousemove="handleTouchMove($event)"
                    @mouseup="handleTouchEnd()" @touchstart="handleTouchStart($event)" @touchmove="handleTouchMove($event)"
                    @touchend="handleTouchEnd">

                    <!-- Images -->
                    <template x-if="selectedColor && selectedColor.images && selectedColor.images.length > 0">
                        <div class="relative w-full h-[320px]">
                            <template x-for="(img, i) in selectedColor.images" :key="i">
                                <img :src="img.startsWith('http') ?
                                    img :
                                    '{{ asset('') }}' + (img.startsWith('/') ? img.substring(1) : img)"
                                    :alt="selectedColor.name"
                                    class="absolute inset-0 w-full h-full object-cover object-top transition-opacity duration-700"
                                    :class="i === slideIndex ? 'opacity-100' : 'opacity-0'">
                            </template>
                        </div>
                    </template>

                    <!-- Fallback -->
                    <template x-if="!selectedColor || !selectedColor.images || selectedColor.images.length === 0">
                        <img src="{{ asset('assets/images/default.jpg') }}" class="w-full h-[320px] object-cover rounded">
                    </template>
                </div>

                <!-- Pagination -->
                <template x-if="selectedColor && selectedColor.images && selectedColor.images.length > 1">
                    <div class="flex justify-center gap-2 mt-4">
                        <template x-for="(img, i) in selectedColor.images" :key="i">
                            <div @click="slideIndex = i"
                                class="h-[3px] rounded-full cursor-pointer transition-all duration-300"
                                :class="i === slideIndex ? 'bg-black w-10' : 'bg-gray-300 w-8 hover:bg-gray-400'"></div>
                        </template>
                    </div>
                </template>
            </div>

            <!-- ITEM DETAILS -->
            <div>
                @if ($item->status)
                    <p class="text-[18px] inline-block py-1 uppercase">New</p>
                @endif
                <h1 class="text-[18px] font-[600] uppercase mb-2">{{ $item->name }}</h1>

                {{-- Price --}}
                @if ($item->discount && $item->discount > 0)
                    @php
                        $discountedPrice = $item->price * (1 - $item->discount / 100);
                    @endphp
                    <div class="text-[16px] font-semibold text-green-600">
                        ${{ number_format($discountedPrice, 2) }}
                        <span class="text-gray-500 line-through text-[16px] ml-2">
                            ${{ number_format($item->price, 2) }}
                        </span>

                        <span class="bg-green-500 text-white text-[12px] px-2 py-1 rounded ml-4">
                            {{ number_format($item->discount, 0) }}% OFF
                        </span>
                    </div>
                @else
                    <p class="text-xl font-semibold">${{ number_format($item->price, 2) }}</p>
                @endif

                <!-- Color Options -->
                <div class="mt-6">
                    <p class="font-semibold mb-2">Available Colors:</p>
                    <div class="flex gap-3 flex-wrap">
                        <template x-for="(color, index) in colors" :key="index">
                            <button class="flex items-center gap-1 border text-sm uppercase transition-all"
                                :class="index === selectedColorIndex ? 'border-green-500 text-white' : 'hover:border-black'"
                                @click="selectedColorIndex = index; resetSlide();">
                                <span class="w-8 h-5" :style="'background-color:' + color.code"></span>
                                {{-- <span x-text="color.name"></span> --}}
                            </button>
                        </template>
                    </div>
                </div>

                <!-- Size Options -->
                @php
                    $sizes = is_array($item->size) ? $item->size : json_decode($item->size ?? '[]', true);
                @endphp
                @if (!empty($sizes))
                    <div class="mt-6">
                        <p class="font-semibold mb-2">Available Sizes:</p>
                        <div class="flex gap-2 flex-wrap">
                            @foreach ($sizes as $size)
                                <button
                                    @click="selectedSize === '{{ $size }}' ? selectedSize = null : selectedSize = '{{ $size }}'"
                                    :class="selectedSize === '{{ $size }}'
                                        ?
                                        'text-black border-green-500' :
                                        'bg-transparent border-gray-500 text-black transition'"
                                    class="border px-4 py-1 text-sm uppercase transition">
                                    {{ $size }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="pt-4">
                    <h1 class="font-semibold mb-2">Description</h1>
                    <div class="text-sm text-black mt-2 prone">{!! $item->description !!}</d>
                </div>
            </div>
            </div>
        </div>

        <!-- ACTION BUTTONS -->
        <div class="w-full mt-8 flex flex-col max-w-7xl mx-auto gap-4" x-data>
            @php $hasSizes = !empty($sizes); @endphp

            <!-- Buy Now -->
            <button
                @click="
                        if (!selectedColor) return $store.cart.toast('Please select a color!');
                        const hasSizes = {{ $hasSizes ? 'true' : 'false' }};
                        if (hasSizes && !selectedSize) return $store.cart.toast('Please select a size!');

                        const discounted = {{ $item->discount ?? 0 }} > 0
                            ? {{ $item->price }} * (1 - {{ $item->discount ?? 0 }} / 100)
                            : {{ $item->price }};

                        const message = encodeURIComponent(
                            `🛒 My Order:\n` +
                            `${'{{ $item->name }}'} - $${discounted.toFixed(2)} ` +
                            `(${hasSizes ? `Size: ${selectedSize}, ` : ''}Color: ${selectedColor.name})\n\n` +
                            `Total: $${discounted.toFixed(2)}`
                        );


                        const telegramLink = `https://t.me/Teng_huy?text=${message}`;
                        window.open(telegramLink, '_blank');
                    "
                class="bg-black uppercase text-white px-6 py-2 transition">
                Buy Now
            </button>

            <!-- Add to Cart -->
            <button
                @click="
                        if (!selectedColor) return $store.cart.toast('Please select a color!');
                        const hasSizes = {{ $hasSizes ? 'true' : 'false' }};
                        if (hasSizes && !selectedSize) return $store.cart.toast('Please select a size!');

                        $store.cart.add({
                            name: '{{ $item->name }}',
                            price: {{ $item->price }},
                            discount: {{ $item->discount ?? 0 }},
                            color: selectedColor.name,
                            colorCode: selectedColor.code,
                            size: selectedSize,
                            image: selectedColor?.images?.[0]
                                ? (
                                    selectedColor.images[0].startsWith('http')
                                        ? selectedColor.images[0]
                                        : '{{ asset('') }}' + (
                                            selectedColor.images[0].replace(/^item\//, '').startsWith('/')
                                                ? selectedColor.images[0].replace(/^item\//, '').substring(1)
                                                : selectedColor.images[0].replace(/^item\//, '')
                                        )
                                )
                                : '{{ asset('assets/images/no-image.png') }}',
                        });
                    "
                class="w-full bg-black text-white px-6 py-2 transition uppercase">
                Add to Cart
            </button>
        </div>
    </section>

    <!-- RELATED ITEMS -->
    <section class="px-4 py-12 border-t mb-16">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-2xl font-semibold mb-6">Related Items</h2>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
                @forelse ($relatedItems as $related)
                    @php
                        $sizes = is_array($related->size) ? $related->size : json_decode($related->size ?? '[]', true);
                        $colors = is_array($related->color)
                            ? $related->color
                            : json_decode($related->color ?? '[]', true);
                    @endphp


                    <div class="border rounded overflow-hidden relative">
                        <a href="{{ route('item.show', $related->slug) }}" class="relative block">
                            @php
                                $colors = $related->color ?? [];
                                $firstColor = $colors[0] ?? null;
                                $firstCode = $firstColor['code'] ?? null;
                                $firstName = $firstColor['name'] ?? null;
                                $firstImage = $firstColor['images'][0] ?? null;
                            @endphp

                            @if ($firstImage)
                                <div class="flex items-center gap-3">
                                    <img src="{{ asset($firstImage) }}" alt="{{ $firstColor['name'] ?? 'Color' }}"
                                        class="w-full h-[300px] object-cover hover:scale-105 transition">
                                </div>
                            @else
                                <img src="{{ asset('assets/images/default.jpg') }}" alt=""
                                    class="w-full h-[300px] object-cover hover:scale-105 transition">
                            @endif

                            @if ($related->discount && $related->discount > 0)
                                @php
                                    // Discount is a percentage
                                    $discountedPrice = $related->price * (1 - $related->discount / 100);
                                @endphp
                                <!-- Discount badge -->
                                <span class="absolute top-2 right-2 bg-green-500 text-white text-[10px] px-2 py-1 rounded">
                                    {{ number_format($related->discount, 0) }}%
                                </span>
                            @endif
                        </a>

                        <div class="flex items-start justify-between p-2 mt-auto">
                            <div>
                                <div class="h-[20px]">
                                    @if ($related->status)
                                        <p class="text-[10px] inline-block py-1 uppercase">New</p>
                                    @endif
                                </div>

                                <p class="text-[12px] uppercase py-1">{{ $related->name }}</p>

                                <p class="text-[12px] font-semibold">
                                    @if ($related->discount && $related->discount > 0)
                                        @php
                                            // Discount is a percentage
                                            $discountedPrice = $related->price * (1 - $related->discount / 100);
                                        @endphp
                                        {{-- Discounted price --}}
                                        <span class="text-[#000] font-semibold">
                                            ${{ number_format($discountedPrice, 2) }}
                                        </span>
                                        {{-- Original price with strikethrough --}}
                                        <span class="line-through text-gray-500 text-[10px] pl-2">
                                            ${{ number_format($related->price, 2) }}
                                        </span>
                                    @else
                                        ${{ number_format($related->price, 2) }}
                                    @endif
                                </p>
                            </div>

                            <div x-data="{ showSizes: false, selectedSize: null }" @click.outside="showSizes = false" class="relative">
                                <button @click="showSizes = !showSizes" class="rounded mt-2 w-full">
                                    <svg class="w-5 h-5" viewBox="0 0 6 7" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M1.17606 1.4942H0.779054C0.504719 1.4942 0.277003 1.70623 0.257429 1.97997L0.00132482 5.56605C-0.00898516 5.71083 0.0412178 5.85338 0.140134 5.95962C0.239199 6.06586 0.377713 6.12622 0.52295 6.12622H4.66248C4.80771 6.12622 4.94623 6.06586 5.04529 5.95962C5.14421 5.85338 5.19441 5.71083 5.1841 5.56605L4.928 1.97997C4.90842 1.70623 4.68071 1.4942 4.40637 1.4942H4.0122V1.41949C4.0122 0.635483 3.37672 0 2.59271 0C1.8374 0 1.13931 0.601565 1.17322 1.41949C1.17427 1.44429 1.17517 1.46925 1.17606 1.4942ZM4.0122 1.94246V3.06311C4.0122 3.18683 3.91179 3.28724 3.78807 3.28724C3.66435 3.28724 3.56394 3.18683 3.56394 3.06311V1.94246H1.62148V3.06311C1.62148 3.18683 1.52107 3.28724 1.39735 3.28724C1.27363 3.28724 1.17322 3.18683 1.17322 3.06311C1.17322 3.06311 1.19265 2.53939 1.18622 1.94246H0.779054C0.739906 1.94246 0.707334 1.97279 0.704645 2.01179L0.448386 5.59787C0.446891 5.61864 0.454067 5.63896 0.468262 5.6542C0.482457 5.66929 0.50218 5.67796 0.52295 5.67796H4.66248C4.68325 5.67796 4.70297 5.66929 4.71717 5.6542C4.73136 5.63896 4.73854 5.61864 4.73704 5.59787L4.48078 2.01179C4.47809 1.97279 4.44552 1.94246 4.40637 1.94246H4.0122ZM3.56394 1.4942V1.41949C3.56394 0.883072 3.12913 0.44826 2.59271 0.44826C2.0563 0.44826 1.62148 0.883072 1.62148 1.41949V1.4942H3.56394Z"
                                            fill="black" />
                                    </svg>
                                </button>

                                <div x-show="showSizes" x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 scale-95 w-0"
                                    x-transition:enter-end="opacity-100 scale-100 w-full"
                                    x-transition:leave="transition ease-in duration-150"
                                    x-transition:leave-start="opacity-100 scale-100 w-full"
                                    x-transition:leave-end="opacity-0 scale-95 w-0"
                                    class="absolute bottom-full mb-3 -left-6 bg-white border rounded z-50 overflow-hidden">
                                    <div class="flex flex-col gap-2 p-2">
                                        @foreach ($sizes as $size)
                                            <button
                                                @click="
                                                selectedSize = '{{ $size }}';
                                                $store.cart.add({
                                                    id: '{{ $related->id }}',
                                                    name: '{{ $related->name }}',
                                                    price: {{ $related->price }},
                                                    discount: {{ $related->discount ?? 0 }},
                                                    image: '{{ $firstImage ? asset($firstImage) : asset('assets/images/default.jpg') }}',
                                                    slug: '{{ $related->slug }}',
                                                    size: '{{ $size }}',
                                                    color: '{{ $firstName }}'
                                                });
                                                showSizes = false;
                                            "
                                                class="border px-2 py-1 rounded text-[12px] uppercase hover:bg-black hover:text-white transition">
                                                {{ $size }}
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="col-span-2 text-center text-gray-500 py-10">
                        No items available in this category.
                    </p>
                @endforelse
            </div>
        </div>
    </section>
@endsection
