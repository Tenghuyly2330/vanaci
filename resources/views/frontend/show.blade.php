@extends('layouts.master')

@section('content')
    <style>
        /* Hide scrollbar for all browsers */
        .hide-scrollbar {
        -ms-overflow-style: none;  /* IE and Edge */
        scrollbar-width: none;     /* Firefox */
        }
        .hide-scrollbar::-webkit-scrollbar {
        display: none;             /* Chrome, Safari, Opera */
        }
    </style>
    <section class="px-4 py-10" x-data="{
        colors: {{ json_encode(is_array($item->color) ? $item->color : json_decode($item->color ?? '[]', true)) }},
        selectedColorIndex: 0,
        selectedSize: null,
        slideIndex: 0,
        interval: null,
        startX: 0,
        endX: 0,
        qty: 1,
        lightboxOpen: false,
        lightboxIndex: 0,
        showToast: false,
        toastMessage: '',

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
        },

        openLightbox(index) {
            this.lightboxIndex = index;
            this.lightboxOpen = true;
        },

        closeLightbox() {
            this.lightboxOpen = false;
        }
    }" x-init="startAutoSlide();
    $watch('selectedColorIndex', () => {
        resetSlide();
        startAutoSlide();
    })">
        <h1 class="text-[20px] md:text-[25px] font-[500] text-center mb-6 tracking-wider">Item</h1>
        <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- IMAGE SLIDER -->
            <div class="relative flex flex-col items-center select-none col-span-1">
                <div class="relative w-full overflow-hidden cursor-pointer"
                    @mouseenter="if (interval) clearInterval(interval)" @mouseleave="startAutoSlide()"
                    @mousedown="handleTouchStart($event)" @mousemove="handleTouchMove($event)" @mouseup="handleTouchEnd()"
                    @touchstart="handleTouchStart($event)" @touchmove="handleTouchMove($event)"
                    @touchend="handleTouchEnd()">

                    <!-- Images -->
                    <template x-if="selectedColor && selectedColor.images && selectedColor.images.length > 0">
                        <div class="relative w-full h-[500px]">
                            <template x-for="(img, i) in selectedColor.images" :key="i">
                                <img :src="img.startsWith('http') ? img : '{{ asset('') }}' + (img.startsWith('/') ? img
                                    .substring(1) : img)"
                                    :alt="selectedColor.name"
                                    class="absolute inset-0 w-full h-full object-cover object-top transition-opacity duration-700"
                                    :class="i === slideIndex ? 'opacity-100' : 'opacity-0'" @click="openLightbox(i)">
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
                                :class="i === slideIndex ? 'bg-black w-4' : 'bg-gray-300 w-2 hover:bg-gray-400'"></div>
                        </template>
                    </div>
                </template>
            </div>

            <!-- LIGHTBOX POPUP -->
            {{-- <div x-show="lightboxOpen" x-transition.opacity x-cloak
                class="fixed inset-0 z-50 bg-black/80 flex flex-col justify-center items-center"
                @click.self="closeLightbox()">

                <button @click="closeLightbox()" class="absolute top-4 z-20 right-4 lg:text-white text-black text-3xl">&times;</button>

                <div class="lg:max-w-3xl xl:max-w-4xl mx-auto relative w-full h-full">
                    <img :src="selectedColor.images[lightboxIndex]" class="w-full h-full object-cover lg:contain mb-4">

                    <!-- Thumbnails md down-->
                    <div class="absolute lg:hidden  max-h-[70vh] left-4 bottom-4 flex flex-col gap-2 justify-start overflow-y-auto hide-scrollbar">
                        <template x-for="(img, i) in selectedColor.images" :key="i">
                            <img :src="img" class="w-14 h-14 object-cover border-2 cursor-pointer"
                                :class="i === lightboxIndex ? 'border-white' : 'border-gray-400'"
                                @click="lightboxIndex = i">
                        </template>
                    </div>
                </div>
                <!-- Thumbnails lg up-->
                    <div class="hidden lg:flex max-h-[70vh] absolute left-4 flex flex-col gap-2 justify-start items-center overflow-y-auto hide-scrollbar">
                        <template x-for="(img, i) in selectedColor.images" :key="i">
                            <img :src="img" class="lg:w-24 lg:h-24 xl:w-40 xl:h-40 space-y-4 object-cover border-2 cursor-pointer"
                                :class="i === lightboxIndex ? 'border-white' : 'border-gray-400'"
                                @click="lightboxIndex = i">
                        </template>
                    </div>
            </div> --}}
            <div x-show="lightboxOpen" x-transition.opacity x-cloak
    class="fixed inset-0 z-50 bg-black/80 flex flex-col justify-center items-center"
    @click.self="closeLightbox()"
    x-data="{
        // Assuming your main Alpine data includes lightboxIndex, selectedColor, and closeLightbox()
        // ... plus existing properties ...
        updateIndexOnScroll(el) {
            // Calculate the height of the container/viewport
            const viewportHeight = el.clientHeight;
            // Get the current scroll position
            const scrollTop = el.scrollTop;
            // Calculate the index of the image currently in the center of the viewport
            // This assumes all images have the same height (viewportHeight) when visible.
            const newIndex = Math.round(scrollTop / viewportHeight);
            
            // Only update if the index has changed to prevent infinite loops/excessive updates
            if (newIndex !== this.lightboxIndex) {
                this.lightboxIndex = newIndex;
            }
        },
        // Function to scroll the main container when a thumbnail is clicked
        scrollToImage(index) {
            const container = this.$refs.imageContainer;
            // Calculate the target scroll position (index * height of one image/viewport)
            const scrollPosition = index * container.clientHeight;
            container.scrollTo({ top: scrollPosition, behavior: 'smooth' });

            // Also scroll the thumbnail list to keep the active thumbnail visible
            const thumbnail = this.$refs.lgThumbs.children[index];
            if (thumbnail) {
                thumbnail.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
    }">

    <button @click="closeLightbox()" class="absolute top-4 z-20 right-4 lg:text-white text-black text-3xl">&times;</button>

    <div x-ref="imageContainer"
         class="lg:max-w-3xl xl:max-w-4xl mx-auto relative w-full h-full overflow-y-auto overflow-x-hidden snap-y snap-mandatory"
         @scroll.debounce.100ms="updateIndexOnScroll($el)">
        
        <template x-for="(img, i) in selectedColor.images" :key="i">
            <img :src="img"
                 class="w-full flex-shrink-0 h-full object-cover lg:contain mb-4 snap-start"
                 style="width: 100%; height: 100%;">
        </template>
    </div>
    
    <div class="absolute lg:hidden max-h-[70vh] left-4 bottom-4 flex flex-col gap-2 justify-start overflow-y-auto hide-scrollbar">
        <template x-for="(img, i) in selectedColor.images" :key="i">
            <img :src="img" class="w-14 h-14 object-cover border-2 cursor-pointer"
                :class="i === lightboxIndex ? 'border-white' : 'border-gray-400'"
                @click="lightboxIndex = i; scrollToImage(i)">
        </template>
    </div>
    
    <div x-ref="lgThumbs" 
         class="hidden lg:flex max-h-[70vh] absolute left-4 flex flex-col gap-2 justify-start items-center overflow-y-auto hide-scrollbar">
        <template x-for="(img, i) in selectedColor.images" :key="i">
            <img :src="img" class="lg:w-24 lg:h-24 xl:w-40 xl:h-40 space-y-4 object-cover border-2 cursor-pointer"
                :class="i === lightboxIndex ? 'border-white' : 'border-gray-400'"
                @click="lightboxIndex = i; scrollToImage(i)">
        </template>
    </div>
</div>

            <!-- ITEM DETAILS -->
            <div class="col-span-1 md:col-span-2">
                @if ($item->status)
                    <p class="text-[16px] inline-block py-1 uppercase">New</p>
                @endif
                <h1 class="text-[16px] font-[500] uppercase">{{ $item->name }}</h1>

                {{-- Price --}}
                @if ($item->discount && $item->discount > 0)
                    @php
                        $discountedPrice = $item->price * (1 - $item->discount / 100);
                    @endphp

                    <div class="text-[16px] font-[500] text-[#000]">
                        ${{ number_format($discountedPrice, 2) }}
                        <span class="text-[#000] line-through text-[16px] ml-2 mt-2">
                            ${{ number_format($item->price, 2) }}
                        </span>
                    </div>
                    <span class="bg-green-500 text-white text-[10px] px-2 py-1 rounded">
                        {{ number_format($item->discount, 0) }}% OFF
                    </span>
                @else
                    <p class="text-[16px] font-[500]">${{ number_format($item->price, 2) }}</p>
                @endif

                <!-- Color Options -->
                <div class="mt-4">
                    <p class="text-[14px] font-[400] mb-2">Colors</p>
                    <div class="flex gap-3 flex-wrap">
                        <template x-for="(color, index) in colors" :key="index">
                            <button class="flex items-center gap-1 border text-sm transition-all"
                                :class="index === selectedColorIndex ? 'border-green-500 text-white' : 'hover:border-black'"
                                @click="selectedColorIndex = index; resetSlide();">
                                <span class="px-2 py-1 text-[#000]" x-text="color.name"></span>
                            </button>
                        </template>
                    </div>
                </div>

                {{-- <div class="mt-4">
                    <p class="text-[14px] font-[400] mb-2">Stock</p>
                    <div class="flex gap-3 flex-wrap">
                        <template x-for="(color, index) in colors" :key="index">
                            <span class="px-2 py-1 text-[#000]" x-text="color.stock"></span> /
                        </template>
                    </div>
                </div> --}}

                <div x-ref="qtyBox" class="mt-4">
                    <p class="text-[14px] font-[400] mb-2">Quantity</p>

                    <div class="flex items-center w-max">
                        <button class="w-12 h-5 mr-1 flex items-center justify-center bg-[#D9D9D9]"
                            @click="qty = Math.max(1, qty - 1)">
                            -
                        </button>

                        <span
                            class="w-12 h-5 flex items-center justify-center text-center text-[12px] font-[500] bg-[#D9D9D9]"
                            x-text="qty"></span>

                        <button
                            class="w-12 h-5 ml-1 flex items-center justify-center bg-[#D9D9D9]"
                            @click="
                                if (qty < selectedColor.stock) {
                                    qty++;
                                } else {
                                    toastMessage = 'Cannot add more than available stock!';
                                    showToast = true;
                                    setTimeout(() => showToast = false, 2000);
                                }
                            "
                        >
                            +
                        </button>
                    </div>
                </div>
                {{-- Alert message --}}
                <div
                    x-show="showToast"
                    x-transition
                    class="fixed bottom-5 right-5 px-4 py-2 bg-red-600 text-white rounded shadow-lg font-medium"
                    x-text="toastMessage">
                </div>
                <!-- Size Options -->
                @php
                    $sizes = is_array($item->size) ? $item->size : json_decode($item->size ?? '[]', true);
                @endphp
                @if (!empty($sizes))
                    <div class="mt-4">
                        <p class="text-[14px] font-[400] mb-2">Sizes</p>
                        <div class="flex gap-2 flex-wrap">
                            @foreach ($sizes as $size)
                                <button
                                    @click="selectedSize === '{{ $size }}' ? selectedSize = null : selectedSize = '{{ $size }}'"
                                    :class="selectedSize === '{{ $size }}'
                                        ?
                                        'text-black border-green-500 bg-[#D9D9D9]' :
                                        'bg-[#D9D9D9] text-black'"
                                    class="border px-4 py-1 text-[10px] uppercase transition">
                                    {{ $size }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endif



                @if (!empty($item->description))
                    <div class="pt-4">
                        <h1 class="text-[16px] font-[500] mb-2">Product Detail</h1>
                        <div class="text-sm text-black mt-2 prose">{!! $item->description !!}</div>
                    </div>
                @endif

            </div>
        </div>

        <!-- ACTION BUTTONS -->
        <div class="w-full mt-8 flex flex-col max-w-7xl mx-auto gap-4" x-data>
            @php $hasSizes = !empty($sizes); @endphp
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
                        stock: selectedColor.stock,
                        colorCode: selectedColor.code,
                        status: {{ $item->status ? 'true' : 'false' }},
                        size: selectedSize,
                        slug: '{{ $item->slug }}',
                        url: '{{ url("/item/".$item->slug) }}',
                        qty: qty,  // ← Now works perfectly
                        image: selectedColor?.images?.[0]
                            ? (
                                selectedColor.images[0].startsWith('http')
                                    ? selectedColor.images[0]
                                    : '{{ asset('') }}' + selectedColor.images[0]
                                        .replace(/^item\//, '')
                                        .replace(/^\//, '')
                            )
                            : '{{ asset('assets/images/no-image.png') }}',
                    });
                "
                class="w-full bg-black text-white px-6 py-2 transition uppercase">
                Add to Cart
            </button>

            <button
                @click="
                    $store.favorite.add({
                        name: '{{ $item->name }}',
                        price: {{ $item->price }},
                        discount: {{ $item->discount ?? 0 }},
                        color: selectedColor.name,
                        colorCode: selectedColor.code,
                        slug: '{{ $item->slug }}',
                        status: {{ $item->status ? 'true' : 'false' }},
                        image: selectedColor?.images?.[0]
                            ? (selectedColor.images[0].startsWith('http')
                                ? selectedColor.images[0]
                                : '{{ asset('') }}' + selectedColor.images[0])
                            : '{{ asset('assets/images/no-image.png') }}',
                    });
                "
                class="w-full bg-[#000] text-white px-6 py-2 transition uppercase tracking-widest">
                Favorite
            </button>
        </div>
    </section>

    <!-- RELATED ITEMS -->
    <section class="px-4 py-12 border-t">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-[20px] md:text-[25px] font-[500] text-center mb-6 tracking-wider">Similar Items</h2>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-4 max-w-7xl mx-auto px-4 py-10">
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
                                        class="w-full h-[300px] lg:h-[400px] sm:h-[400px] xl:h-[500px] object-cover">
                                </div>
                            @else
                                <img src="{{ asset('assets/images/default.jpg') }}" alt=""
                                    class="w-full h-[300px] lg:h-[400px] sm:h-[400px] xl:h-[500px] object-cover">
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

                            {{-- <div>
                                <button x-data="{ added: $store.cart.items.some(i => i.id == '{{ $item->id }}') }"
                                    @click="
                                    added = !added;

                                    if (added) {
                                        $store.cart.add({
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
                                    <svg x-show="!added" class="w-5 h-5 absolute inset-0 m-auto" viewBox="0 0 6 7"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M1.17606 1.4942H0.779054C0.504719 1.4942 0.277003 1.70623 0.257429 1.97997L0.00132482 5.56605C-0.00898516 5.71083 0.0412178 5.85338 0.140134 5.95962C0.239199 6.06586 0.377713 6.12622 0.52295 6.12622H4.66248C4.80771 6.12622 4.94623 6.06586 5.04529 5.95962C5.14421 5.85338 5.19441 5.71083 5.1841 5.56605L4.928 1.97997C4.90842 1.70623 4.68071 1.4942 4.40637 1.4942H4.0122V1.41949C4.0122 0.635483 3.37672 0 2.59271 0C1.8374 0 1.13931 0.601565 1.17322 1.41949C1.17427 1.44429 1.17517 1.46925 1.17606 1.4942ZM4.0122 1.94246V3.06311C4.0122 3.18683 3.91179 3.28724 3.78807 3.28724C3.66435 3.28724 3.56394 3.18683 3.56394 3.06311V1.94246H1.62148V3.06311C1.62148 3.18683 1.52107 3.28724 1.39735 3.28724C1.27363 3.28724 1.17322 3.18683 1.17322 3.06311C1.17322 3.06311 1.19265 2.53939 1.18622 1.94246H0.779054C0.739906 1.94246 0.707334 1.97279 0.704645 2.01179L0.448386 5.59787C0.446891 5.61864 0.454067 5.63896 0.468262 5.6542C0.482457 5.66929 0.50218 5.67796 0.52295 5.67796H4.66248C4.68325 5.67796 4.70297 5.66929 4.71717 5.6542C4.73136 5.63896 4.73854 5.61864 4.73704 5.59787L4.48078 2.01179C4.47809 1.97279 4.44552 1.94246 4.40637 1.94246H4.0122ZM3.56394 1.4942V1.41949C3.56394 0.883072 3.12913 0.44826 2.59271 0.44826C2.0563 0.44826 1.62148 0.883072 1.62148 1.41949V1.4942H3.56394Z"
                                            fill="black" />
                                    </svg>

                                    <!-- Added / Check Icon -->
                                    <svg x-show="added" class="w-5 h-5 absolute inset-0 m-auto" viewBox="0 0 6 7"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M1.18056 1.49991H0.782031C0.506648 1.49991 0.278062 1.71275 0.258413 1.98753L0.00132988 5.58732C-0.0090195 5.73266 0.0413753 5.87575 0.140669 5.9824C0.240113 6.08904 0.379157 6.14963 0.524948 6.14963H4.6803C4.82609 6.14963 4.96513 6.08904 5.06458 5.9824C5.16387 5.87575 5.21427 5.73266 5.20392 5.58732L4.94683 1.98753C4.92718 1.71275 4.6986 1.49991 4.42321 1.49991H4.02754V1.42492C4.02754 0.637912 3.38963 0 2.60262 0C1.84442 0 1.14366 0.603864 1.17771 1.42492C1.17876 1.44981 1.17966 1.47486 1.18056 1.49991ZM3.57756 1.49991V1.42492C3.57756 0.886447 3.14109 0.449973 2.60262 0.449973C2.06416 0.449973 1.62768 0.886447 1.62768 1.42492V1.49991H3.57756Z"
                                            fill="black" />
                                    </svg>
                                </button>

                            </div> --}}

                            <div x-data="{ showSizes: false, selectedSize: null }" @click.outside="showSizes = false" class="relative">

                                @if (!empty($sizes))
                                    <!-- 🟢 Has sizes -->
                                    <button @click="showSizes = !showSizes" class="rounded mt-2 w-full">
                                        <svg class="w-5 h-5" viewBox="0 0 6 7" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
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
                                            name: '{{ $related->name }}',
                                            price: {{ $related->price }},
                                            discount: {{ $related->discount ?? 0 }},
                                            image: '{{ $firstImage ? asset($firstImage) : asset('assets/images/default.jpg') }}',
                                            slug: '{{ $related->slug }}',
                                            size: '',
                                            color: '{{ $firstName }}'
                                        });
                                    "
                                        class="rounded mt-2 w-full">
                                        <svg class="w-5 h-5" viewBox="0 0 6 7" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M1.17606 1.4942H0.779054C0.504719 1.4942 0.277003 1.70623 0.257429 1.97997L0.00132482 5.56605C-0.00898516 5.71083 0.0412178 5.85338 0.140134 5.95962C0.239199 6.06586 0.377713 6.12622 0.52295 6.12622H4.66248C4.80771 6.12622 4.94623 6.06586 5.04529 5.95962C5.14421 5.85338 5.19441 5.71083 5.1841 5.56605L4.928 1.97997C4.90842 1.70623 4.68071 1.4942 4.40637 1.4942H4.0122V1.41949C4.0122 0.635483 3.37672 0 2.59271 0C1.8374 0 1.13931 0.601565 1.17322 1.41949C1.17427 1.44429 1.17517 1.46925 1.17606 1.4942ZM4.0122 1.94246V3.06311C4.0122 3.18683 3.91179 3.28724 3.78807 3.28724C3.66435 3.28724 3.56394 3.18683 3.56394 3.06311V1.94246H1.62148V3.06311C1.62148 3.18683 1.52107 3.28724 1.39735 3.28724C1.27363 3.28724 1.17322 3.18683 1.17322 3.06311C1.17322 3.06311 1.19265 2.53939 1.18622 1.94246H0.779054C0.739906 1.94246 0.707334 1.97279 0.704645 2.01179L0.448386 5.59787C0.446891 5.61864 0.454067 5.63896 0.468262 5.6542C0.482457 5.66929 0.50218 5.67796 0.52295 5.67796H4.66248C4.68325 5.67796 4.70297 5.66929 4.71717 5.6542C4.73136 5.63896 4.73854 5.61864 4.73704 5.59787L4.48078 2.01179C4.47809 1.97279 4.44552 1.94246 4.40637 1.94246H4.0122ZM3.56394 1.4942V1.41949C3.56394 0.883072 3.12913 0.44826 2.59271 0.44826C2.0563 0.44826 1.62148 0.883072 1.62148 1.41949V1.4942H3.56394Z"
                                                fill="black" />
                                        </svg>
                                    </button>
                                @endif
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
        <div class="hidden md:flex justify-center items-center">
            <svg width="4" height="136" viewBox="0 0 4 136" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect width="4" height="136" fill="black" />
            </svg>
        </div>
    </section>
@endsection
