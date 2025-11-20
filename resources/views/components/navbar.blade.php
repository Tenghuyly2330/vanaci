<style>
    [x-cloak] {
        display: none;
    }

    .animate-fadeIn {
        animation: fadeInOut 2s ease;
    }

    #search-section {
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    #search-section:not(.hidden) {
        opacity: 1;
    }


    @keyframes fadeInOut {
        0% {
            opacity: 0;
            transform: translateY(10px);
        }

        10%,
        90% {
            opacity: 1;
            transform: translateY(0);
        }

        100% {
            opacity: 0;
            transform: translateY(10px);
        }
    }
</style>

{{-- labtop navbar --}}
<div class="sticky top-0 left-0 w-full flex items-center justify-between h-16 lg:h-20 text-white px-4 z-40 bg-white">

    <div class="flex items-center gap-2" x-data="{ cartOpen: false, menuOpen: false }">
        <!-- Hamburger -->
        <div class="relative">
            <div @click="menuOpen = !menuOpen" class="cursor-pointer p-3 rounded-full transition-all duration-300">
                <svg class="w-6 h-6" viewBox="0 0 25 20" fill="none">
                    <rect width="24.1667" height="1.66667" fill="black" />
                    <rect y="9.16666" width="24.1667" height="1.66667" fill="black" />
                    <rect y="18.3333" width="24.1667" height="1.66667" fill="black" />
                </svg>
            </div>

            <span
                x-show="$store.cart.count > 0"
                x-text="$store.cart.count" x-cloak
                class="absolute top-2 -right-3 -translate-x-1/2 -translate-y-1/2 bg-red-500 text-white text-[10px] w-4 h-4 flex items-center justify-center rounded-full">
            </span>
        </div>

        <div x-show="menuOpen" x-cloak x-transition:enter="transition transform duration-300"
            x-transition:enter-start="-translate-x-full opacity-0" x-transition:enter-end="translate-x-0 opacity-100"
            x-transition:leave="transition transform duration-300" x-transition:leave-start="translate-x-0 opacity-100"
            x-transition:leave-end="-translate-x-full opacity-0"
            class="fixed top-0 left-0 h-screen overflow-y-auto w-full md:w-96 bg-[#fff] shadow z-40 pb-20">

            <!-- Drawer Header -->
            <div class="flex items-center justify-between pt-4 px-4">
                <button @click="menuOpen = false" class="flex items-center gap-2">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <rect x="0.949829" y="17.9549" width="24.1667" height="1.66667"
                            transform="rotate(-45 0.949829 17.9549)" fill="#000" />
                        <rect width="24.1667" height="1.66667"
                            transform="matrix(-0.707107 -0.707107 -0.707107 0.707107 19.2168 17.9549)" fill="#000" />
                    </svg>
                </button>

                <div class="relative">
                    {{-- <button @click="cartOpen = !cartOpen" class="relative flex items-center gap-2 text-black">
                        <span>Cart ( <span x-text="$store.cart.count > 0 ? $store.cart.count : 0"></span> )</span>
                    </button> --}}
                    <button @click="cartOpen = !cartOpen" class="relative flex items-center gap-2 text-black">
                        <div class="relative ">
                            <!-- Cart Icon -->
                            <div class="flex items-center gap-2">
                                <svg width="17" height="20" viewBox="0 0 17 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M3.81317 4.84467H2.52594C1.63646 4.84467 0.898131 5.53213 0.834666 6.41967L0.00429548 18.0469C-0.0291327 18.5163 0.133641 18.9785 0.454358 19.323C0.775559 19.6674 1.22467 19.8631 1.69557 19.8631H15.1172C15.5881 19.8631 16.0372 19.6674 16.3584 19.323C16.6791 18.9785 16.8419 18.5163 16.8085 18.0469L15.9781 6.41967C15.9147 5.53213 15.1763 4.84467 14.2868 4.84467H13.0088V4.60243C13.0088 2.06044 10.9484 0 8.40639 0C5.95741 0 3.69399 1.95046 3.80396 4.60243C3.80735 4.68285 3.81026 4.76376 3.81317 4.84467ZM13.0088 6.29807V9.93156C13.0088 10.3327 12.6833 10.6583 12.2821 10.6583C11.881 10.6583 11.5554 10.3327 11.5554 9.93156V6.29807H5.25736V9.93156C5.25736 10.3327 4.9318 10.6583 4.53066 10.6583C4.12952 10.6583 3.80396 10.3327 3.80396 9.93156C3.80396 9.93156 3.86694 8.23351 3.84611 6.29807H2.52594C2.39901 6.29807 2.2934 6.39641 2.28468 6.52285L1.45381 18.15C1.44896 18.2174 1.47223 18.2833 1.51825 18.3327C1.56428 18.3816 1.62823 18.4097 1.69557 18.4097H15.1172C15.1846 18.4097 15.2485 18.3816 15.2945 18.3327C15.3406 18.2833 15.3638 18.2174 15.359 18.15L14.5281 6.52285C14.5194 6.39641 14.4138 6.29807 14.2868 6.29807H13.0088ZM11.5554 4.84467V4.60243C11.5554 2.8632 10.1456 1.4534 8.40639 1.4534C6.66716 1.4534 5.25736 2.8632 5.25736 4.60243V4.84467H11.5554Z" fill="black"/>
                                </svg>

                                Cart
                            </div>

                            <span
                                x-show="$store.cart.count > 0"
                                x-text="$store.cart.count"
                                class="absolute top-0 -left-2 -translate-x-1/2 -translate-y-1/2 bg-red-500 text-white text-[10px] w-4 h-4 flex items-center justify-center rounded-full">
                            </span>
                        </div>

                    </button>
                </div>
            </div>

            <!-- Menu Items -->
            <ul class="p-4 space-y-4 text-[#000] mt-4">
                <li>
                    <a href="{{ route('item', ['filter' => 'new']) }}" class="block text-[20px] italic">New Arrivals</a>
                </li>

                @foreach ($types as $type)
                    <li x-data="{ open: false }" class="relative">
                        <button @click="open = !open"
                            class="w-full text-left text-[20px] italic flex justify-between items-center">
                            {{ $type->type }}
                            <svg :class="open ? 'rotate-180' : ''"
                                class="w-5 h-5 ml-2 transition-transform duration-300" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </button>

                        @php
                            $typeCategories = $categories->where('type_id', $type->id);
                        @endphp

                        @if ($typeCategories->isNotEmpty())
                            <ul x-show="open" x-transition class="mt-2 pl-4 space-y-1 italic">
                                <li>
                                    <a href="{{ route('item', ['type' => $type->slug]) }}" class="block">All</a>
                                </li>
                                @foreach ($typeCategories as $category)
                                    <li>
                                        <a href="{{ route('item', ['type' => $type->slug, 'category' => $category->slug]) }}"
                                            class="block">{{ $category->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>

        <div x-show="cartOpen" x-transition x-cloak
            class="fixed top-0 right-0 w-full h-full bg-white shadow-xl z-50 overflow-y-auto px-4 pt-2"
            @click.away="cartOpen = false">
            <h2 class="text-lg font-semibold mb-4">Your Cart</h2>

            <!-- Empty -->
            <template x-if="$store.cart.count === 0">
                <p class="text-gray-500 text-center mt-10">No items added yet</p>
            </template>

            <div class="grid grid-cols-2 gap-4 items-start">
                <template x-for="item in $store.cart.items" :key="item.id">
                    <div class="flex flex-col text-[#000]">
                        <!-- Item image -->
                        <a :href="`/item/${item.slug}`" class="relative block border border-gray-300 mb-2">
                            <img :src="item.image" alt="" class="w-full h-[300px] object-cover transition">

                            <!-- Discount badge -->
                            <template x-if="item.discount && item.discount > 0">
                                <span
                                    class="absolute top-2 right-2 bg-green-500 text-white text-[12px] px-2 py-1 rounded">
                                    <span x-text="item.discount"></span>%
                                </span>
                            </template>
                        </a>

                        <div class="flex items-start justify-between p-2 mt-auto">
                            <div>
                                <div class="h-[20px]">
                                    <template x-if="item.status">
                                        <p class="text-[14px] inline-block py-1 uppercase">
                                            New
                                        </p>
                                    </template>
                                </div>
                                <p class="text-[14px] uppercase py-1" x-text="item.name"></p>

                                <!-- Price -->
                                <p class="text-[14px] font-semibold">
                                    <template x-if="item.discount && item.discount > 0">
                                        <span x-text="`$${(item.price * (1 - item.discount / 100)).toFixed(2)}`"></span>
                                        <span class="line-through text-gray-500 font-[400] text-[12px] pl-2"
                                            x-text="`$${item.price.toFixed(2)}`"></span>
                                    </template>

                                    <template x-if="!item.discount || item.discount == 0">
                                        <span x-text="`$${item.price.toFixed(2)}`"></span>
                                    </template>
                                </p>
                            </div>

                            <div>
                                <button @click="$store.cart.remove(item.id)"
                                    class="w-[32px] h-[32px] flex items-center justify-center transition">
                                    <svg class="w-5 h-5" viewBox="0 0 6 7" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M1.18056 1.49991H0.782031C0.506648 1.49991 0.278062 1.71275 0.258413 1.98753L0.00132988 5.58732C-0.0090195 5.73266 0.0413753 5.87575 0.140669 5.9824C0.240113 6.08904 0.379157 6.14963 0.524948 6.14963H4.6803C4.82609 6.14963 4.96513 6.08904 5.06458 5.9824C5.16387 5.87575 5.21427 5.73266 5.20392 5.58732L4.94683 1.98753C4.92718 1.71275 4.6986 1.49991 4.42321 1.49991H4.02754V1.42492C4.02754 0.637912 3.38963 0 2.60262 0C1.84442 0 1.14366 0.603864 1.17771 1.42492C1.17876 1.44981 1.17966 1.47486 1.18056 1.49991ZM3.57756 1.49991V1.42492C3.57756 0.886447 3.14109 0.449973 2.60262 0.449973C2.06416 0.449973 1.62768 0.886447 1.62768 1.42492V1.49991H3.57756Z"
                                            fill="black" />
                                    </svg>

                                </button>
                            </div>
                        </div>
                    </div>
                </template>
            </div>


            <button @click="cartOpen = false" class="absolute top-3 right-4">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <rect x="0.949829" y="17.9549" width="24.1667" height="1.66667"
                        transform="rotate(-45 0.949829 17.9549)" fill="#000" />
                    <rect width="24.1667" height="1.66667"
                        transform="matrix(-0.707107 -0.707107 -0.707107 0.707107 19.2168 17.9549)" fill="#000" />
                </svg>
            </button>
        </div>





        <!-- Cart Button -->
        {{-- <div class="relative">
            <button @click="cartOpen = !cartOpen" class="relative flex items-center gap-2 text-black">
                <span>Cart ( <span x-text="$store.cart.count > 0 ? $store.cart.count : 0"></span> )</span>
            </button>
        </div> --}}

        <!-- Cart Drawer -->
        {{-- <div x-show="cartOpen" x-transition x-cloak
            class="fixed top-0 right-0 w-[30rem] h-full bg-white shadow-lg border-l z-50 flex flex-col">
            <div class="flex items-center justify-between p-4 border-b">
                <h2 class="text-lg font-semibold">Your Cart</h2>
                <button @click="cartOpen = false" class="text-gray-800 hover:text-black">✕</button>
            </div>

            <div class="flex-1 overflow-y-auto p-4 space-y-4">
                <template x-for="(item, index) in $store.cart.items" :key="index">
                    <div class="relative flex border border-gray-200 rounded-lg p-3 gap-3 bg-white shadow-sm">
                        <button @click="$store.cart.remove(index)" class="absolute bottom-4 right-2">
                            <img src="{{ asset('assets/images/icons/trash-red.svg') }}" alt="" class="w-6 h-6">
                        </button>
                        <img :src="item.image" alt=""
                            class="w-28 h-36 object-cover rounded-md flex-shrink-0">

                        <div class="flex-1 flex flex-col justify-between">
                            <div>
                                <div class="flex items-center gap-2 mt-1">
                                    <span x-show="item.size"
                                        class="border border-[#000] rounded-sm px-3 py-[2px] font-[600] text-[10px] text-[#000] uppercase"
                                        x-text="item.size">
                                    </span>

                                    <span
                                        class="border border-[#000] rounded-sm px-3 py-[2px] font-[600] text-[10px] text-[#000] capitalize"
                                        x-text="item.color"></span>
                                </div>
                                <p class="font-semibold text-gray-900 mt-2" x-text="item.name"></p>


                                <p class="text-[#000] mt-1">
                                    <template x-if="item.discount && item.discount > 0">
                                        <span class="flex items-center gap-2">
                                            <span class="font-semibold text-black">
                                                $<span
                                                    x-text="(item.price * (1 - item.discount / 100)).toFixed(2)"></span>
                                            </span>
                                            <span class="line-through text-[#000]">
                                                $<span x-text="item.price.toFixed(2)"></span>
                                            </span>
                                        </span>
                                    </template>
                                    <template x-if="!item.discount || item.discount <= 0">
                                        <span class="font-semibold text-black">$<span
                                                x-text="item.price.toFixed(2)"></span></span>
                                    </template>
                                </p>


                            </div>

                            <div class="flex items-center border border-gray-300 rounded overflow-hidden w-max mt-2">
                                <button @click="$store.cart.decrease(index)"
                                    class="px-3 py-[2px] text-gray-700 hover:bg-gray-100 border-r border-gray-300">
                                    <img src="{{ asset('assets/images/icons/minus.svg') }}" alt=""
                                        class="w-6 h-6">
                                </button>
                                <span x-text="item.qty"
                                    class="text-[14px] px-4 text-gray-900 font-medium bg-gray-50"></span>
                                <button @click="$store.cart.increase(index)"
                                    class="px-3 py-[2px] text-gray-700 hover:bg-gray-100 border-l border-gray-300">
                                    <img src="{{ asset('assets/images/icons/plus.svg') }}" alt=""
                                        class="w-6 h-6">
                                </button>
                            </div>

                        </div>
                    </div>
                </template>


                <p x-show="$store.cart.items.length === 0" class="text-center text-gray-500 mt-4">
                    Your cart is empty.
                </p>
            </div>

            <!-- Footer -->
            <div class="p-4 border-t">
                <div class="flex justify-between font-semibold mb-4">
                    <span>Total:</span>
                    <span>$<span x-text="$store.cart.total"></span></span>
                </div>
                <button @click="$store.cart.checkout()"
                    class="w-full bg-black text-white py-2 rounded hover:bg-gray-800">
                    Checkout
                </button>
            </div>
        </div> --}}
    </div>


    <a href="{{ route('home') }}">
        <svg class="w-12 h-12 md:w-20 md:h-20" viewBox="0 0 44 20" fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <path
                d="M44 8.71857C43.994 8.6865 43.9862 8.65479 43.9768 8.62355C43.7966 8.03042 43.4121 7.63602 42.8343 7.42856C41.9857 7.12365 41.1374 6.81818 40.2894 6.51215C37.2203 5.40515 34.1511 4.29786 31.082 3.1903L23.1357 0.320744C22.8394 0.213923 22.5425 0.108508 22.2393 0C22.2333 0.0258166 22.2292 0.0520258 22.227 0.0784292C22.227 0.814089 22.2122 1.55003 22.2328 2.28513C22.2566 3.13464 22.8559 3.85933 23.6745 4.07888C24.4329 4.28221 25.1908 4.48649 25.9484 4.69169L32.8381 6.55404C34.8157 7.08889 36.793 7.62487 38.7699 8.16197C38.9033 8.20018 39.0303 8.25856 39.1463 8.33514C39.2579 8.40794 39.2579 8.51027 39.1441 8.58392C39.0391 8.65217 38.925 8.70517 38.8053 8.74134C35.8039 9.64819 32.8015 10.5531 29.798 11.456C28.6683 11.7964 27.5458 12.1661 26.3711 12.3274C25.7375 12.4146 25.1033 12.4542 24.4714 12.3142C23.7244 12.1484 23.1642 11.7484 22.8765 11.011C22.6868 10.5241 22.6254 10.015 22.6254 9.49611C22.6254 8.00624 22.6232 6.51637 22.6279 5.02649C22.6279 4.78165 22.5478 4.58319 22.3598 4.43814C21.9692 4.13679 21.5387 4.01057 21.0532 4.17333C20.0398 4.51291 19.0266 4.85277 18.0136 5.19291C15.1018 6.16929 12.1902 7.14539 9.27856 8.12121C6.48955 9.05562 3.70017 9.98918 0.910418 10.9219C0.60741 11.0231 0.304961 11.126 0 11.2286C0.00213953 11.2554 0.00567873 11.282 0.0106026 11.3084C0.169361 11.9063 0.530961 12.3241 1.10712 12.5453C1.45896 12.6794 1.8147 12.8028 2.16737 12.9307C4.52335 13.7819 6.87924 14.6329 9.23504 15.4837C11.3594 16.2502 13.484 17.0163 15.6088 17.7821C17.6283 18.5109 19.6476 19.2402 21.6667 19.9699C21.6999 19.982 21.7351 19.9879 21.7839 20V19.8594C21.7839 19.1942 21.7839 18.5289 21.7839 17.8636C21.7839 16.9219 21.198 16.1601 20.292 15.9172C19.1615 15.6142 18.0314 15.3091 16.9017 15.0019L9.3684 12.9625C7.98283 12.5876 6.59706 12.2118 5.21112 11.8349C5.08638 11.7996 4.96787 11.7448 4.85984 11.6727C4.74824 11.5996 4.75103 11.4979 4.85984 11.4197C4.95136 11.3566 5.05182 11.3076 5.15783 11.2747C5.55207 11.149 5.94883 11.0318 6.34474 10.9126C8.88971 10.1473 11.4347 9.38217 13.9796 8.61737C15.1543 8.2657 16.3169 7.86681 17.5368 7.68971C18.1785 7.59667 18.8219 7.54719 19.4653 7.67538C20.3796 7.85753 20.9801 8.3863 21.2317 9.30102C21.3433 9.7016 21.3799 10.1103 21.3802 10.5238C21.3802 12.0137 21.3835 13.5036 21.3802 14.9935C21.3772 15.1037 21.3999 15.2131 21.4467 15.3128C21.4934 15.4125 21.5628 15.4998 21.6491 15.5675C21.862 15.7454 22.1109 15.8382 22.3815 15.8871C22.6974 15.9433 22.9761 15.8185 23.2613 15.7229C26.442 14.6568 29.6228 13.5899 32.8035 12.5222C36.1703 11.3937 39.537 10.2655 42.9038 9.1377C43.2687 9.01542 43.6328 8.89173 43.9944 8.76945C43.9978 8.7527 43.9997 8.73567 44 8.71857Z"
                fill="black" />
        </svg>
    </a>

    <div id="search-btn" class="p-3 rounded-full transition-colors duration-300">
        <svg id="search-icon" class="w-6 h-6 cursor-pointer text-black" viewBox="0 0 22 22" fill="currentColor"
            xmlns="http://www.w3.org/2000/svg">
            <path
                d="M9.60721 1.90735e-05C4.31279 1.90735e-05 0 4.3128 0 9.60725C0 14.9017 4.31279 19.2228 9.60721 19.2228C11.8686 19.2228 13.9484 18.4303 15.5922 17.1145L19.594 21.1142C19.7959 21.3078 20.0656 21.4146 20.3454 21.4117C20.6251 21.4089 20.8926 21.2966 21.0905 21.0989C21.2885 20.9013 21.4012 20.634 21.4044 20.3542C21.4077 20.0745 21.3012 19.8046 21.1079 19.6024L17.1061 15.6006C18.4231 13.9543 19.2165 11.8713 19.2165 9.60725C19.2165 4.3128 14.9016 1.90735e-05 9.60721 1.90735e-05ZM9.60721 2.13545C13.7476 2.13545 17.079 5.46689 17.079 9.60725C17.079 13.7476 13.7476 17.0874 9.60721 17.0874C5.46685 17.0874 2.1354 13.7476 2.1354 9.60725C2.1354 5.46689 5.46685 2.13545 9.60721 2.13545Z" />
        </svg>
    </div>

    {{-- <ul class="flex items-center gap-2">
        <li>
            <a href="https://www.facebook.com/share/1Ah3HpQrNq/?mibextid=wwXIfr">
                <svg width="21" height="21" viewBox="0 0 21 21" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M20.5897 10.2954C20.5897 15.434 16.8249 19.6931 11.9034 20.4652V13.2712H14.3022L14.7587 10.2954H11.9034V8.36427C11.9034 7.54993 12.3024 6.7565 13.5812 6.7565H14.8793V4.223C14.8793 4.223 13.701 4.02192 12.5746 4.02192C10.2233 4.02192 8.6863 5.44712 8.6863 8.02727V10.2954H6.07237V13.2712H8.6863V20.4652C3.76487 19.6931 0 15.434 0 10.2954C0 4.60986 4.60937 0.000488281 10.2949 0.000488281C15.9804 0.000488281 20.5897 4.60986 20.5897 10.2954Z"
                        fill="black" />
                    <path
                        d="M14.3022 13.2709L14.7586 10.295H11.9034V8.36391C11.9034 7.54977 12.3023 6.75618 13.5811 6.75618H14.8793V4.22268C14.8793 4.22268 13.7012 4.02161 12.5748 4.02161C10.2232 4.02161 8.68626 5.4468 8.68626 8.02696V10.295H6.07233V13.2709H8.68626V20.4648C9.21041 20.5471 9.7476 20.5899 10.2948 20.5899C10.8421 20.5899 11.3793 20.5471 11.9034 20.4648V13.2709H14.3022Z"
                        fill="white" />
                </svg>
            </a>
        </li>
        <li>
            <a href="https://www.tiktok.com/@vanaci_official?_t=ZS-8zH1Wdi6i4w&_r=1">
                <svg width="21" height="21" viewBox="0 0 21 21" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M10.6526 0C5.00202 0 0.419739 4.58228 0.419739 10.2329C0.419739 15.8834 5.00202 20.4657 10.6526 20.4657C16.3032 20.4657 20.8855 15.8834 20.8855 10.2329C20.8855 4.58228 16.3032 0 10.6526 0ZM15.7862 7.82946V9.21501C15.1329 9.21525 14.4981 9.08722 13.8994 8.83463C13.5144 8.67211 13.1557 8.46269 12.8277 8.20963L12.8375 12.4744C12.8334 13.4347 12.4535 14.337 11.7658 15.0166C11.2062 15.5699 10.4971 15.9216 9.72852 16.0355C9.54793 16.0623 9.36414 16.076 9.17827 16.076C8.35552 16.076 7.57443 15.8094 6.93547 15.3177C6.81524 15.2251 6.70024 15.1248 6.59075 15.0166C5.84551 14.2801 5.46122 13.2818 5.52594 12.2316C5.5753 11.4322 5.89536 10.6698 6.42891 10.0723C7.13481 9.28156 8.12236 8.84267 9.17827 8.84267C9.36414 8.84267 9.54793 8.85662 9.72852 8.88336V9.39564V10.8207C9.55728 10.7642 9.37441 10.7332 9.18398 10.7332C8.2193 10.7332 7.43884 11.5202 7.45327 12.4856C7.46242 13.1033 7.79983 13.6433 8.29748 13.9409C8.53136 14.0808 8.80041 14.1675 9.08753 14.1832C9.31249 14.1956 9.5285 14.1642 9.72852 14.0982C10.4178 13.8705 10.915 13.2231 10.915 12.4596L10.9173 9.6037V4.38974H12.8254C12.8272 4.5788 12.8464 4.76328 12.882 4.94203C13.0261 5.66557 13.4339 6.29329 14.0015 6.72123C14.4964 7.09453 15.1127 7.31581 15.7807 7.31581C15.7811 7.31581 15.7867 7.31581 15.7862 7.31537V7.82946H15.7862Z"
                        fill="black" />
                </svg>
            </a>
        </li>
        <li>
            <a href="https://www.instagram.com/vanaci_official?igsh=ZXR6dGU3NXlvMzhn">
                <svg width="21" height="21" viewBox="0 0 21 21" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M10.8928 12.4068C12.0588 12.4068 13.0041 11.4616 13.0041 10.2956C13.0041 9.12957 12.0588 8.18433 10.8928 8.18433C9.7268 8.18433 8.78156 9.12957 8.78156 10.2956C8.78156 11.4616 9.7268 12.4068 10.8928 12.4068Z"
                        fill="black" />
                    <path
                        d="M10.8929 0.241943C5.34045 0.241943 0.839294 4.7431 0.839294 10.2955C0.839294 15.848 5.34045 20.3491 10.8929 20.3491C16.4453 20.3491 20.9465 15.848 20.9465 10.2955C20.9465 4.7431 16.4453 0.241943 10.8929 0.241943ZM17.1043 12.8508C17.0561 13.8066 16.7875 14.7491 16.0909 15.4383C15.3876 16.134 14.4406 16.3932 13.4756 16.441H8.31024C7.34509 16.3932 6.3982 16.1341 5.6949 15.4383C4.9983 14.7491 4.72975 13.8066 4.68149 12.8508V7.74031C4.72975 6.7845 4.99834 5.84195 5.6949 5.15276C6.3982 4.45705 7.34521 4.19783 8.31024 4.15009H13.4755C14.4407 4.19783 15.3876 4.45693 16.0909 5.15276C16.7875 5.84195 17.056 6.7845 17.1043 7.74031L17.1043 12.8508Z"
                        fill="black" />
                    <path
                        d="M13.4103 5.31372C12.1521 5.27922 9.63389 5.27922 8.37574 5.31372C7.72101 5.3317 6.97878 5.49468 6.51229 5.99294C6.02755 6.51086 5.84437 7.1366 5.82579 7.83661C5.79314 9.06524 5.82579 12.7529 5.82579 12.7529C5.84707 13.4528 6.02755 14.0786 6.51229 14.5966C6.97878 15.095 7.72101 15.2578 8.37574 15.2758C9.63389 15.3103 12.1521 15.3103 13.4103 15.2758C14.065 15.2578 14.8072 15.0948 15.2737 14.5966C15.7585 14.0786 15.9416 13.4529 15.9602 12.7529V7.83661C15.9416 7.1366 15.7585 6.51086 15.2737 5.99294C14.8071 5.49452 14.0648 5.3317 13.4103 5.31372ZM10.8928 13.5672C10.2456 13.5672 9.61292 13.3753 9.07477 13.0157C8.53662 12.6561 8.11718 12.145 7.8695 11.5471C7.62181 10.9491 7.55701 10.2911 7.68328 9.65633C7.80955 9.02154 8.12121 8.43844 8.57887 7.98078C9.03653 7.52312 9.61963 7.21145 10.2544 7.08519C10.8892 6.95892 11.5472 7.02372 12.1452 7.27141C12.7431 7.51909 13.2542 7.93853 13.6138 8.47668C13.9734 9.01483 14.1653 9.64752 14.1653 10.2947C14.1653 11.1627 13.8205 11.995 13.2068 12.6087C12.5931 13.2224 11.7607 13.5672 10.8928 13.5672ZM14.1792 7.69779C14.0498 7.69776 13.9232 7.65934 13.8156 7.58741C13.708 7.51547 13.6242 7.41324 13.5746 7.29365C13.5251 7.17405 13.5122 7.04246 13.5375 6.91552C13.5627 6.78857 13.6251 6.67196 13.7166 6.58045C13.8082 6.48893 13.9248 6.42661 14.0517 6.40137C14.1787 6.37613 14.3103 6.3891 14.4299 6.43865C14.5494 6.48819 14.6516 6.57207 14.7236 6.6797C14.7955 6.78733 14.8338 6.91386 14.8338 7.0433C14.8338 7.12926 14.8169 7.21438 14.784 7.2938C14.7511 7.37321 14.7029 7.44537 14.6421 7.50615C14.5813 7.56693 14.5091 7.61513 14.4297 7.64801C14.3503 7.6809 14.2652 7.69781 14.1792 7.69779Z"
                        fill="black" />
                </svg>
            </a>
        </li>

        <li>
            <a href="https://t.me/+855967777516">
                <svg width="21" height="21" viewBox="0 0 21 21" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M10.7052 20.5901C16.3922 20.5901 21 15.9823 21 10.2952C21 4.60818 16.3922 0.000366211 10.7052 0.000366211C5.01809 0.000366211 0.410278 4.60818 0.410278 10.2952C0.410278 15.9823 5.01809 20.5901 10.7052 20.5901ZM5.12104 10.0722L15.047 6.24507C15.5077 6.07863 15.9101 6.35745 15.7608 7.05407L15.7617 7.05321L14.0716 15.0154C13.9463 15.5799 13.6109 15.7172 13.1416 15.4513L10.5679 13.5544L9.3265 14.7503C9.18923 14.8876 9.07341 15.0034 8.80746 15.0034L8.9902 12.3842L13.7602 8.07498C13.9678 7.89224 13.7138 7.7893 13.4402 7.97117L7.54548 11.6825L5.00437 10.8898C4.45273 10.7148 4.44072 10.3381 5.12104 10.0722Z"
                        fill="black" />
                </svg>
            </a>
        </li>
    </ul> --}}
</div>

{{-- mobile navbar --}}
{{-- <nav class="fixed bottom-2 left-0 w-full flex items-center justify-center z-50" x-data="{ open: false }">
    <div
        class="w-full flex md:hidden items-center justify-between px-6 py-3 rounded-full bg-white mx-2 drop-shadow-2xl">
        <div id="hamburger" class="cursor-pointer p-3 transition-all rounded-full duration-300">
            <!-- Hamburger Icon -->
            <svg id="hamburgerIcon" class="w-6 h-6" viewBox="0 0 25 20" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <rect width="24.1667" height="1.66667" fill="black" />
                <rect y="9.16666" width="24.1667" height="1.66667" fill="black" />
                <rect y="18.3333" width="24.1667" height="1.66667" fill="black" />
            </svg>

            <!-- X Icon -->
            <svg id="closeIcon" class="w-6 h-6 hidden" viewBox="0 0 20 20" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <rect x="0.949829" y="17.9549" width="24.1667" height="1.66667"
                    transform="rotate(-45 0.949829 17.9549)" fill="white" />
                <rect width="24.1667" height="1.66667"
                    transform="matrix(-0.707107 -0.707107 -0.707107 0.707107 19.2168 17.9549)" fill="white" />
            </svg>
        </div>

        <a href="{{ route('home') }}"
            class="p-3 rounded-full transition-all duration-300
            {{ request()->routeIs('home') ? 'bg-black' : 'bg-transparent' }}">
            <svg width="22" height="23" viewBox="0 0 22 23" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M21.6773 9.26655L11.6667 0.25701C11.4828 0.0915526 11.2443 0 10.997 0C10.7496 0 10.5111 0.0915526 10.3273 0.25701L0.31666 9.26655C0.125402 9.44572 0.0120351 9.69275 0.000904205 9.95459C-0.0102267 10.2164 0.0817666 10.4722 0.257128 10.6669C0.43249 10.8617 0.677234 10.9799 0.9388 10.9962C1.20037 11.0125 1.45789 10.9256 1.65608 10.7541L10.997 2.34722L20.3379 10.7561C20.536 10.9276 20.7936 11.0145 21.0551 10.9982C21.3167 10.9819 21.5614 10.8637 21.7368 10.6689C21.9122 10.4742 22.0042 10.2184 21.993 9.95659C21.9819 9.69475 21.8685 9.44772 21.6773 9.26855V9.26655Z"
                    fill="{{ request()->routeIs('home') ? 'white' : 'black' }}" />
                <path
                    d="M19.0054 12.0125C18.7399 12.0125 18.4853 12.118 18.2976 12.3057C18.1098 12.4935 18.0044 12.7481 18.0044 13.0136V18.7937C18.0041 19.1191 17.8747 19.4311 17.6446 19.6612C17.4145 19.8913 17.1025 20.0207 16.7771 20.021H5.21684C4.89143 20.0207 4.57941 19.8913 4.34931 19.6612C4.1192 19.4311 3.98981 19.1191 3.98955 18.7937V13.0136C3.98955 12.7481 3.88408 12.4935 3.69634 12.3057C3.50861 12.118 3.25398 12.0125 2.98849 12.0125C2.72299 12.0125 2.46837 12.118 2.28063 12.3057C2.0929 12.4935 1.98743 12.7481 1.98743 13.0136V18.7937C1.98822 19.6499 2.32872 20.4709 2.93418 21.0764C3.53964 21.6818 4.36059 22.0223 5.21684 22.0231H16.7771C17.6333 22.0223 18.4543 21.6818 19.0597 21.0764C19.6652 20.4709 20.0057 19.6499 20.0065 18.7937V13.0136C20.0065 12.7481 19.901 12.4935 19.7133 12.3057C19.5256 12.118 19.2709 12.0125 19.0054 12.0125Z"
                    fill="{{ request()->routeIs('home') ? 'white' : 'black' }}" />
            </svg>
        </a>


        <div id="search-btn" class="p-3 rounded-full transition-colors duration-300">
            <svg id="search-icon" class="w-6 h-6 cursor-pointer text-black" viewBox="0 0 22 22" fill="currentColor"
                xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M9.60721 1.90735e-05C4.31279 1.90735e-05 0 4.3128 0 9.60725C0 14.9017 4.31279 19.2228 9.60721 19.2228C11.8686 19.2228 13.9484 18.4303 15.5922 17.1145L19.594 21.1142C19.7959 21.3078 20.0656 21.4146 20.3454 21.4117C20.6251 21.4089 20.8926 21.2966 21.0905 21.0989C21.2885 20.9013 21.4012 20.634 21.4044 20.3542C21.4077 20.0745 21.3012 19.8046 21.1079 19.6024L17.1061 15.6006C18.4231 13.9543 19.2165 11.8713 19.2165 9.60725C19.2165 4.3128 14.9016 1.90735e-05 9.60721 1.90735e-05ZM9.60721 2.13545C13.7476 2.13545 17.079 5.46689 17.079 9.60725C17.079 13.7476 13.7476 17.0874 9.60721 17.0874C5.46685 17.0874 2.1354 13.7476 2.1354 9.60725C2.1354 5.46689 5.46685 2.13545 9.60721 2.13545Z" />
            </svg>
        </div>


        <div class="relative">
            <!-- Cart Button -->
            <button @click="open = !open" class="relative flex items-center gap-2">
                <svg class="w-6 h-6" viewBox="0 0 17 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M3.81317 4.84467H2.52594C1.63646 4.84467 0.898131 5.53213 0.834666 6.41967L0.00429548 18.0469C-0.0291327 18.5163 0.133641 18.9785 0.454358 19.323C0.775559 19.6674 1.22467 19.8631 1.69557 19.8631H15.1172C15.5881 19.8631 16.0372 19.6674 16.3584 19.323C16.6791 18.9785 16.8419 18.5163 16.8085 18.0469L15.9781 6.41967C15.9147 5.53213 15.1763 4.84467 14.2868 4.84467H13.0088V4.60243C13.0088 2.06044 10.9484 0 8.40639 0C5.95741 0 3.69399 1.95046 3.80396 4.60243C3.80735 4.68285 3.81026 4.76376 3.81317 4.84467ZM13.0088 6.29807V9.93156C13.0088 10.3327 12.6833 10.6583 12.2821 10.6583C11.881 10.6583 11.5554 10.3327 11.5554 9.93156V6.29807H5.25736V9.93156C5.25736 10.3327 4.9318 10.6583 4.53066 10.6583C4.12952 10.6583 3.80396 10.3327 3.80396 9.93156C3.80396 9.93156 3.86694 8.23351 3.84611 6.29807H2.52594C2.39901 6.29807 2.2934 6.39641 2.28468 6.52285L1.45381 18.15C1.44896 18.2174 1.47223 18.2833 1.51825 18.3327C1.56428 18.3816 1.62823 18.4097 1.69557 18.4097H15.1172C15.1846 18.4097 15.2485 18.3816 15.2945 18.3327C15.3406 18.2833 15.3638 18.2174 15.359 18.15L14.5281 6.52285C14.5194 6.39641 14.4138 6.29807 14.2868 6.29807H13.0088ZM11.5554 4.84467V4.60243C11.5554 2.8632 10.1456 1.4534 8.40639 1.4534C6.66716 1.4534 5.25736 2.8632 5.25736 4.60243V4.84467H11.5554Z"
                        fill="black" />
                </svg>

                <!-- Cart Count -->
                <span x-show="$store.cart.count > 0" x-cloak
                    class="absolute -top-2 -left-3 bg-red-600 text-white text-[10px] w-4 h-4 flex items-center justify-center rounded-full"
                    x-text="$store.cart.count"></span>
            </button>
        </div>
    </div>

    <div x-show="open" x-transition x-cloak
        class="fixed top-0 right-0 w-full h-full bg-white shadow-lg border-l z-50 flex flex-col">

        <div class="flex items-center justify-between p-4 border-b">
            <h2 class="text-lg font-semibold">Your Cart</h2>
            <button @click="open = false" class="text-gray-500 hover:text-black">✕</button>
        </div>

        <div class="flex-1 overflow-y-auto p-4 space-y-4">
            <template x-for="(item, index) in $store.cart.items" :key="index">
                <div class="relative flex border border-gray-200 rounded-lg p-3 gap-3 bg-white shadow-sm">
                    <button @click="$store.cart.remove(index)" class="absolute bottom-4 right-2">
                        <img src="{{ asset('assets/images/icons/trash-red.svg') }}" alt="" class="w-6 h-6">
                    </button>

                    <img :src="item.image" alt=""
                        class="w-28 h-36 object-cover rounded-md flex-shrink-0">

                    <div class="flex-1 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center gap-2 mt-1">
                                <span x-show="item.size"
                                    class="border border-[#000] rounded-sm px-3 py-[2px] font-[600] text-[10px] text-[#000] uppercase"
                                    x-text="item.size">
                                </span>

                                <span
                                    class="border border-[#000] rounded-sm px-3 py-[2px] font-[600] text-[10px] text-[#000] capitalize"
                                    x-text="item.color"></span>
                            </div>
                            <p class="font-semibold text-gray-900 mt-2" x-text="item.name"></p>

                            <!-- Price -->
                            <p class="text-[#000] mt-1">
                                <template x-if="item.discount && item.discount > 0">
                                    <span class="flex items-center gap-2">
                                        <span class="font-semibold text-black">
                                            $<span x-text="(item.price * (1 - item.discount / 100)).toFixed(2)"></span>
                                        </span>
                                        <span class="line-through text-[#000]">
                                            $<span x-text="item.price.toFixed(2)"></span>
                                        </span>
                                    </span>
                                </template>
                                <template x-if="!item.discount || item.discount <= 0">
                                    <span class="font-semibold text-black">$<span
                                            x-text="item.price.toFixed(2)"></span></span>
                                </template>
                            </p>


                        </div>

                        <div class="flex items-center border border-gray-300 rounded overflow-hidden w-max mt-2">
                            <button @click="$store.cart.decrease(index)"
                                class="px-3 py-[2px] text-gray-700 hover:bg-gray-100 border-r border-gray-300">
                                <img src="{{ asset('assets/images/icons/minus.svg') }}" alt=""
                                    class="w-6 h-6">
                            </button>
                            <span x-text="item.qty"
                                class="text-[14px] px-4 text-gray-900 font-medium bg-gray-50"></span>
                            <button @click="$store.cart.increase(index)"
                                class="px-3 py-[2px] text-gray-700 hover:bg-gray-100 border-l border-gray-300">
                                <img src="{{ asset('assets/images/icons/plus.svg') }}" alt=""
                                    class="w-6 h-6">
                            </button>
                        </div>

                    </div>
                </div>
            </template>


            <p x-show="$store.cart.items.length === 0" class="text-center text-gray-500 mt-4">
                Your cart is empty.
            </p>
        </div>

        <!-- Footer -->
        <div class="p-4 border-t">
            <div class="flex justify-between font-semibold mb-4">
                <span>Total:</span>
                <span>$<span x-text="$store.cart.total"></span></span>
            </div>
            <button @click="$store.cart.checkout()" class="w-full bg-black text-white py-2 rounded hover:bg-gray-800">
                Checkout
            </button>
        </div>
    </div>
</nav> --}}

<div id="search-section" x-data="searchComponent(
    @js($items ?? []),
    @js($types ?? []),
    @js(request('type') ?? 'men'),
    @js(request('filter') ?? '')
)" data-items='@json($items ?? [])'
    class="hidden fixed top-0 left-0 w-full h-full bg-white flex flex-col items-center overflow-y-auto z-40">
    <div class="w-full flex items-center justify-between py-5 text-white px-4">
        <a href="{{ route('home') }}">
            <svg width="44" height="20" viewBox="0 0 44 20" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M44 8.71857C43.994 8.6865 43.9862 8.65479 43.9768 8.62355C43.7966 8.03042 43.4121 7.63602 42.8343 7.42856C41.9857 7.12365 41.1374 6.81818 40.2894 6.51215C37.2203 5.40515 34.1511 4.29786 31.082 3.1903L23.1357 0.320744C22.8394 0.213923 22.5425 0.108508 22.2393 0C22.2333 0.0258166 22.2292 0.0520258 22.227 0.0784292C22.227 0.814089 22.2122 1.55003 22.2328 2.28513C22.2566 3.13464 22.8559 3.85933 23.6745 4.07888C24.4329 4.28221 25.1908 4.48649 25.9484 4.69169L32.8381 6.55404C34.8157 7.08889 36.793 7.62487 38.7699 8.16197C38.9033 8.20018 39.0303 8.25856 39.1463 8.33514C39.2579 8.40794 39.2579 8.51027 39.1441 8.58392C39.0391 8.65217 38.925 8.70517 38.8053 8.74134C35.8039 9.64819 32.8015 10.5531 29.798 11.456C28.6683 11.7964 27.5458 12.1661 26.3711 12.3274C25.7375 12.4146 25.1033 12.4542 24.4714 12.3142C23.7244 12.1484 23.1642 11.7484 22.8765 11.011C22.6868 10.5241 22.6254 10.015 22.6254 9.49611C22.6254 8.00624 22.6232 6.51637 22.6279 5.02649C22.6279 4.78165 22.5478 4.58319 22.3598 4.43814C21.9692 4.13679 21.5387 4.01057 21.0532 4.17333C20.0398 4.51291 19.0266 4.85277 18.0136 5.19291C15.1018 6.16929 12.1902 7.14539 9.27856 8.12121C6.48955 9.05562 3.70017 9.98918 0.910418 10.9219C0.60741 11.0231 0.304961 11.126 0 11.2286C0.00213953 11.2554 0.00567873 11.282 0.0106026 11.3084C0.169361 11.9063 0.530961 12.3241 1.10712 12.5453C1.45896 12.6794 1.8147 12.8028 2.16737 12.9307C4.52335 13.7819 6.87924 14.6329 9.23504 15.4837C11.3594 16.2502 13.484 17.0163 15.6088 17.7821C17.6283 18.5109 19.6476 19.2402 21.6667 19.9699C21.6999 19.982 21.7351 19.9879 21.7839 20V19.8594C21.7839 19.1942 21.7839 18.5289 21.7839 17.8636C21.7839 16.9219 21.198 16.1601 20.292 15.9172C19.1615 15.6142 18.0314 15.3091 16.9017 15.0019L9.3684 12.9625C7.98283 12.5876 6.59706 12.2118 5.21112 11.8349C5.08638 11.7996 4.96787 11.7448 4.85984 11.6727C4.74824 11.5996 4.75103 11.4979 4.85984 11.4197C4.95136 11.3566 5.05182 11.3076 5.15783 11.2747C5.55207 11.149 5.94883 11.0318 6.34474 10.9126C8.88971 10.1473 11.4347 9.38217 13.9796 8.61737C15.1543 8.2657 16.3169 7.86681 17.5368 7.68971C18.1785 7.59667 18.8219 7.54719 19.4653 7.67538C20.3796 7.85753 20.9801 8.3863 21.2317 9.30102C21.3433 9.7016 21.3799 10.1103 21.3802 10.5238C21.3802 12.0137 21.3835 13.5036 21.3802 14.9935C21.3772 15.1037 21.3999 15.2131 21.4467 15.3128C21.4934 15.4125 21.5628 15.4998 21.6491 15.5675C21.862 15.7454 22.1109 15.8382 22.3815 15.8871C22.6974 15.9433 22.9761 15.8185 23.2613 15.7229C26.442 14.6568 29.6228 13.5899 32.8035 12.5222C36.1703 11.3937 39.537 10.2655 42.9038 9.1377C43.2687 9.01542 43.6328 8.89173 43.9944 8.76945C43.9978 8.7527 43.9997 8.73567 44 8.71857Z"
                    fill="black" />
            </svg>
        </a>
        <ul class="flex items-center gap-2">
            <li>
                <a href="https://www.facebook.com/share/1Ah3HpQrNq/?mibextid=wwXIfr">
                    <svg width="21" height="21" viewBox="0 0 21 21" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M20.5897 10.2954C20.5897 15.434 16.8249 19.6931 11.9034 20.4652V13.2712H14.3022L14.7587 10.2954H11.9034V8.36427C11.9034 7.54993 12.3024 6.7565 13.5812 6.7565H14.8793V4.223C14.8793 4.223 13.701 4.02192 12.5746 4.02192C10.2233 4.02192 8.6863 5.44712 8.6863 8.02727V10.2954H6.07237V13.2712H8.6863V20.4652C3.76487 19.6931 0 15.434 0 10.2954C0 4.60986 4.60937 0.000488281 10.2949 0.000488281C15.9804 0.000488281 20.5897 4.60986 20.5897 10.2954Z"
                            fill="black" />
                        <path
                            d="M14.3022 13.2709L14.7586 10.295H11.9034V8.36391C11.9034 7.54977 12.3023 6.75618 13.5811 6.75618H14.8793V4.22268C14.8793 4.22268 13.7012 4.02161 12.5748 4.02161C10.2232 4.02161 8.68626 5.4468 8.68626 8.02696V10.295H6.07233V13.2709H8.68626V20.4648C9.21041 20.5471 9.7476 20.5899 10.2948 20.5899C10.8421 20.5899 11.3793 20.5471 11.9034 20.4648V13.2709H14.3022Z"
                            fill="white" />
                    </svg>
                </a>
            </li>
            <li>
                <a href="https://www.tiktok.com/@vanaci_official?_t=ZS-8zH1Wdi6i4w&_r=1">
                    <svg width="21" height="21" viewBox="0 0 21 21" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M10.6526 0C5.00202 0 0.419739 4.58228 0.419739 10.2329C0.419739 15.8834 5.00202 20.4657 10.6526 20.4657C16.3032 20.4657 20.8855 15.8834 20.8855 10.2329C20.8855 4.58228 16.3032 0 10.6526 0ZM15.7862 7.82946V9.21501C15.1329 9.21525 14.4981 9.08722 13.8994 8.83463C13.5144 8.67211 13.1557 8.46269 12.8277 8.20963L12.8375 12.4744C12.8334 13.4347 12.4535 14.337 11.7658 15.0166C11.2062 15.5699 10.4971 15.9216 9.72852 16.0355C9.54793 16.0623 9.36414 16.076 9.17827 16.076C8.35552 16.076 7.57443 15.8094 6.93547 15.3177C6.81524 15.2251 6.70024 15.1248 6.59075 15.0166C5.84551 14.2801 5.46122 13.2818 5.52594 12.2316C5.5753 11.4322 5.89536 10.6698 6.42891 10.0723C7.13481 9.28156 8.12236 8.84267 9.17827 8.84267C9.36414 8.84267 9.54793 8.85662 9.72852 8.88336V9.39564V10.8207C9.55728 10.7642 9.37441 10.7332 9.18398 10.7332C8.2193 10.7332 7.43884 11.5202 7.45327 12.4856C7.46242 13.1033 7.79983 13.6433 8.29748 13.9409C8.53136 14.0808 8.80041 14.1675 9.08753 14.1832C9.31249 14.1956 9.5285 14.1642 9.72852 14.0982C10.4178 13.8705 10.915 13.2231 10.915 12.4596L10.9173 9.6037V4.38974H12.8254C12.8272 4.5788 12.8464 4.76328 12.882 4.94203C13.0261 5.66557 13.4339 6.29329 14.0015 6.72123C14.4964 7.09453 15.1127 7.31581 15.7807 7.31581C15.7811 7.31581 15.7867 7.31581 15.7862 7.31537V7.82946H15.7862Z"
                            fill="black" />
                    </svg>
                </a>
            </li>
            <li>
                <a href="https://www.instagram.com/vanaci_official?igsh=ZXR6dGU3NXlvMzhn">
                    <svg width="21" height="21" viewBox="0 0 21 21" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M10.8928 12.4068C12.0588 12.4068 13.0041 11.4616 13.0041 10.2956C13.0041 9.12957 12.0588 8.18433 10.8928 8.18433C9.7268 8.18433 8.78156 9.12957 8.78156 10.2956C8.78156 11.4616 9.7268 12.4068 10.8928 12.4068Z"
                            fill="black" />
                        <path
                            d="M10.8929 0.241943C5.34045 0.241943 0.839294 4.7431 0.839294 10.2955C0.839294 15.848 5.34045 20.3491 10.8929 20.3491C16.4453 20.3491 20.9465 15.848 20.9465 10.2955C20.9465 4.7431 16.4453 0.241943 10.8929 0.241943ZM17.1043 12.8508C17.0561 13.8066 16.7875 14.7491 16.0909 15.4383C15.3876 16.134 14.4406 16.3932 13.4756 16.441H8.31024C7.34509 16.3932 6.3982 16.1341 5.6949 15.4383C4.9983 14.7491 4.72975 13.8066 4.68149 12.8508V7.74031C4.72975 6.7845 4.99834 5.84195 5.6949 5.15276C6.3982 4.45705 7.34521 4.19783 8.31024 4.15009H13.4755C14.4407 4.19783 15.3876 4.45693 16.0909 5.15276C16.7875 5.84195 17.056 6.7845 17.1043 7.74031L17.1043 12.8508Z"
                            fill="black" />
                        <path
                            d="M13.4103 5.31372C12.1521 5.27922 9.63389 5.27922 8.37574 5.31372C7.72101 5.3317 6.97878 5.49468 6.51229 5.99294C6.02755 6.51086 5.84437 7.1366 5.82579 7.83661C5.79314 9.06524 5.82579 12.7529 5.82579 12.7529C5.84707 13.4528 6.02755 14.0786 6.51229 14.5966C6.97878 15.095 7.72101 15.2578 8.37574 15.2758C9.63389 15.3103 12.1521 15.3103 13.4103 15.2758C14.065 15.2578 14.8072 15.0948 15.2737 14.5966C15.7585 14.0786 15.9416 13.4529 15.9602 12.7529V7.83661C15.9416 7.1366 15.7585 6.51086 15.2737 5.99294C14.8071 5.49452 14.0648 5.3317 13.4103 5.31372ZM10.8928 13.5672C10.2456 13.5672 9.61292 13.3753 9.07477 13.0157C8.53662 12.6561 8.11718 12.145 7.8695 11.5471C7.62181 10.9491 7.55701 10.2911 7.68328 9.65633C7.80955 9.02154 8.12121 8.43844 8.57887 7.98078C9.03653 7.52312 9.61963 7.21145 10.2544 7.08519C10.8892 6.95892 11.5472 7.02372 12.1452 7.27141C12.7431 7.51909 13.2542 7.93853 13.6138 8.47668C13.9734 9.01483 14.1653 9.64752 14.1653 10.2947C14.1653 11.1627 13.8205 11.995 13.2068 12.6087C12.5931 13.2224 11.7607 13.5672 10.8928 13.5672ZM14.1792 7.69779C14.0498 7.69776 13.9232 7.65934 13.8156 7.58741C13.708 7.51547 13.6242 7.41324 13.5746 7.29365C13.5251 7.17405 13.5122 7.04246 13.5375 6.91552C13.5627 6.78857 13.6251 6.67196 13.7166 6.58045C13.8082 6.48893 13.9248 6.42661 14.0517 6.40137C14.1787 6.37613 14.3103 6.3891 14.4299 6.43865C14.5494 6.48819 14.6516 6.57207 14.7236 6.6797C14.7955 6.78733 14.8338 6.91386 14.8338 7.0433C14.8338 7.12926 14.8169 7.21438 14.784 7.2938C14.7511 7.37321 14.7029 7.44537 14.6421 7.50615C14.5813 7.56693 14.5091 7.61513 14.4297 7.64801C14.3503 7.6809 14.2652 7.69781 14.1792 7.69779Z"
                            fill="black" />
                    </svg>
                </a>
            </li>

            <li>
                <a href="https://t.me/vann_clobber">
                    <svg width="21" height="21" viewBox="0 0 21 21" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M10.7052 20.5901C16.3922 20.5901 21 15.9823 21 10.2952C21 4.60818 16.3922 0.000366211 10.7052 0.000366211C5.01809 0.000366211 0.410278 4.60818 0.410278 10.2952C0.410278 15.9823 5.01809 20.5901 10.7052 20.5901ZM5.12104 10.0722L15.047 6.24507C15.5077 6.07863 15.9101 6.35745 15.7608 7.05407L15.7617 7.05321L14.0716 15.0154C13.9463 15.5799 13.6109 15.7172 13.1416 15.4513L10.5679 13.5544L9.3265 14.7503C9.18923 14.8876 9.07341 15.0034 8.80746 15.0034L8.9902 12.3842L13.7602 8.07498C13.9678 7.89224 13.7138 7.7893 13.4402 7.97117L7.54548 11.6825L5.00437 10.8898C4.45273 10.7148 4.44072 10.3381 5.12104 10.0722Z"
                            fill="black" />
                    </svg>
                </a>
            </li>
        </ul>
    </div>
    <!-- 🔍 Search Input -->
    <div class="w-full max-w-3xl text-center border-b border-gray-300 pb-2 px-2 my-6">
        <input type="text" placeholder="WHAT ARE YOU LOOKING FOR?" x-model="query"
            class="w-full text-center text-[13px] uppercase tracking-[2px] border-0 border-b border-gray-400 focus:ring-0 focus:border-black focus:outline-none" />
    </div>

    <!-- 🏷️ Type Filter -->
    <div class="flex flex-wrap justify-center gap-6 mb-10 text-[#000]">
        <template x-for="type in types" :key="type.id">
            <button @click="selectType(type.slug)"
                :class="selectedType === type.slug ?
                    'font-[700] border-b-2 border-black pb-1' :
                    'font-[400] text-gray-700'"
                class="uppercase text-[11px] tracking-[2px] hover:font-[700] transition">
                <span x-text="type.type"></span>
            </button>
        </template>
    </div>

    <!-- 🛍️ Product Grid -->
    <div class="w-full max-w-6xl px-6 mb-20">
        <p class="text-[11px] uppercase tracking-[2px] text-gray-600 mb-6">
            YOU MAY BE INTERESTED IN
        </p>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-x-6 gap-y-12">
            <!-- 🧩 Product Card -->
            <template x-for="item in filteredItems" :key="item.id">
                <div class="border rounded overflow-hidden relative">
                    <a :href="`/item/${item.slug}`" class="relative block">
                        <img :src="item.image" :alt="item.name"
                            class="w-full h-[300px] object-cover transition" />
                        <template x-if="item.discount > 0">
                            <span class="absolute top-2 right-2 bg-green-500 text-white text-[10px] px-2 py-1 rounded"
                                x-text="item.discount + '%'"></span>
                        </template>
                    </a>

                    <div class="flex items-start justify-between p-2 mt-auto">
                        <div>
                            <div class="h-[20px]">
                                <template x-if="item.status">
                                    <p class="text-[14px] inline-block py-1 uppercase text-[#000]">New</p>
                                </template>
                            </div>

                            <p class="text-[14px] uppercase py-1" x-text="item.name"></p>

                            <p class="text-[14px] font-semibold">
                                <template x-if="item.discount > 0">
                                    <span>
                                        <span class="text-[#000] font-semibold"
                                            x-text="formatCurrency(item.price * (1 - item.discount / 100))"></span>
                                        <span class="line-through text-gray-500 text-[10px] pl-2"
                                            x-text="formatCurrency(item.price)"></span>
                                    </span>
                                </template>
                                <template x-if="item.discount <= 0">
                                    <span x-text="formatCurrency(item.price)"></span>
                                </template>
                            </p>
                        </div>

                        <div>
                            <button x-data="{ added: $store.cart.items.some(i => i.id == item.id) }"
                                @click="
                                    added = !added;
                                    if (added) {
                                        $store.cart.add({
                                            id: item.id,
                                            name: item.name,
                                            price: item.price,
                                            image: item.image || '/assets/images/default.jpg',
                                            discount: item.discount || 0,
                                            status: item.status ? true : false,
                                            slug: item.slug
                                        });
                                    } else {
                                        $store.cart.remove(item.id);
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
                        </div>

                        <!-- 🧩 Size Dropdown -->
                        {{-- <div x-data="{ showSizes: false, selectedSize: null }" @click.outside="showSizes = false" class="relative">

                            <button
                                @click="
                                    if (item.sizes.length === 0) {
                                        // ✅ No size — add directly to cart
                                        $store.cart.add({
                                            id: item.id,
                                            name: item.name,
                                            price: item.price,
                                            discount: item.discount,
                                            image: item.image,
                                            slug: item.slug,
                                            size: '',
                                            color: item.color || ''
                                        });
                                    } else {
                                        // 🧩 Has sizes — open dropdown
                                        showSizes = !showSizes;
                                    }
                                "
                                class="rounded mt-2 w-full">
                                <svg class="w-5 h-5" viewBox="0 0 6 7" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M1.17606 1.4942H0.779054C0.504719 1.4942 0.277003 1.70623 0.257429 1.97997L0.00132482 5.56605C-0.00898516 5.71083 0.0412178 5.85338 0.140134 5.95962C0.239199 6.06586 0.377713 6.12622 0.52295 6.12622H4.66248C4.80771 6.12622 4.94623 6.06586 5.04529 5.95962C5.14421 5.85338 5.19441 5.71083 5.1841 5.56605L4.928 1.97997C4.90842 1.70623 4.68071 1.4942 4.40637 1.4942H4.0122V1.41949C4.0122 0.635483 3.37672 0 2.59271 0C1.8374 0 1.13931 0.601565 1.17322 1.41949C1.17427 1.44429 1.17517 1.46925 1.17606 1.4942ZM4.0122 1.94246V3.06311C4.0122 3.18683 3.91179 3.28724 3.78807 3.28724C3.66435 3.28724 3.56394 3.18683 3.56394 3.06311V1.94246H1.62148V3.06311C1.62148 3.18683 1.52107 3.28724 1.39735 3.28724C1.27363 3.28724 1.17322 3.18683 1.17322 3.06311C1.17322 3.06311 1.19265 2.53939 1.18622 1.94246H0.779054C0.739906 1.94246 0.707334 1.97279 0.704645 2.01179L0.448386 5.59787C0.446891 5.61864 0.454067 5.63896 0.468262 5.6542C0.482457 5.66929 0.50218 5.67796 0.52295 5.67796H4.66248C4.68325 5.67796 4.70297 5.66929 4.71717 5.6542C4.73136 5.63896 4.73854 5.61864 4.73704 5.59787L4.48078 2.01179C4.47809 1.97279 4.44552 1.94246 4.40637 1.94246H4.0122ZM3.56394 1.4942V1.41949C3.56394 0.883072 3.12913 0.44826 2.59271 0.44826C2.0563 0.44826 1.62148 0.883072 1.62148 1.41949V1.4942H3.56394Z"
                                        fill="black" />
                                </svg>
                            </button>

                            <template x-if="item.sizes.length > 0">
                                <div x-show="showSizes" x-transition
                                    class="absolute bottom-full mb-3 -left-6 bg-white border rounded z-50 overflow-hidden">
                                    <div class="flex flex-col gap-2 p-2">
                                        <template x-for="size in item.sizes" :key="size">
                                            <button
                                                @click="
                                                    selectedSize = size;
                                                    $store.cart.add({
                                                        id: item.id,
                                                        name: item.name,
                                                        price: item.price,
                                                        discount: item.discount,
                                                        image: item.image,
                                                        slug: item.slug,
                                                        size: size,
                                                        color: item.color || ''
                                                    });
                                                    showSizes = false;
                                                "
                                                class="border px-2 py-1 rounded text-[12px] uppercase hover:bg-black hover:text-white transition"
                                                x-text="size"></button>
                                        </template>
                                    </div>
                                </div>
                            </template>
                        </div> --}}

                    </div>
                </div>
            </template>

            <!-- 🔄 Loading -->
            <template x-if="loading">
                <p class="col-span-full text-center text-gray-400 text-sm py-10 animate-pulse">
                    Loading...
                </p>
            </template>

            <!-- ❌ No Results -->
            <template x-if="!loading && !filteredItems.length">
                <p class="col-span-full text-center text-gray-500 text-sm py-10">
                    No matching items found.
                </p>
            </template>

        </div>
    </div>
</div>


<div id="drawer"
    class="fixed top-0 left-0 h-screen overflow-y-auto w-full md:w-96 bg-[#FFF] shadow transform -translate-x-full transition-transform duration-300 z-40 pb-20">
    <!-- Drawer Header with Close Button -->
    <div class="hidden md:block" x-data="{ open: false }">
        <!-- Drawer Header -->
        <div class="flex items-center justify-between pt-8 pl-4">
            <button id="closeDrawer" @click="closeDrawer" class="flex items-center gap-2">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <rect x="0.949829" y="17.9549" width="24.1667" height="1.66667"
                        transform="rotate(-45 0.949829 17.9549)" fill="white" />
                    <rect width="24.1667" height="1.66667"
                        transform="matrix(-0.707107 -0.707107 -0.707107 0.707107 19.2168 17.9549)" fill="white" />
                </svg>
            </button>
        </div>
    </div>
    <div class="w-full flex md:hidden items-center justify-between h-16 text-white px-4">
        <a href="{{ route('home') }}">
            <svg width="44" height="20" viewBox="0 0 44 20" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M44 8.71857C43.994 8.6865 43.9862 8.65479 43.9768 8.62355C43.7966 8.03042 43.4121 7.63602 42.8343 7.42856C41.9857 7.12365 41.1374 6.81818 40.2894 6.51215C37.2203 5.40515 34.1511 4.29786 31.082 3.1903L23.1357 0.320744C22.8394 0.213923 22.5425 0.108508 22.2393 0C22.2333 0.0258166 22.2292 0.0520258 22.227 0.0784292C22.227 0.814089 22.2122 1.55003 22.2328 2.28513C22.2566 3.13464 22.8559 3.85933 23.6745 4.07888C24.4329 4.28221 25.1908 4.48649 25.9484 4.69169L32.8381 6.55404C34.8157 7.08889 36.793 7.62487 38.7699 8.16197C38.9033 8.20018 39.0303 8.25856 39.1463 8.33514C39.2579 8.40794 39.2579 8.51027 39.1441 8.58392C39.0391 8.65217 38.925 8.70517 38.8053 8.74134C35.8039 9.64819 32.8015 10.5531 29.798 11.456C28.6683 11.7964 27.5458 12.1661 26.3711 12.3274C25.7375 12.4146 25.1033 12.4542 24.4714 12.3142C23.7244 12.1484 23.1642 11.7484 22.8765 11.011C22.6868 10.5241 22.6254 10.015 22.6254 9.49611C22.6254 8.00624 22.6232 6.51637 22.6279 5.02649C22.6279 4.78165 22.5478 4.58319 22.3598 4.43814C21.9692 4.13679 21.5387 4.01057 21.0532 4.17333C20.0398 4.51291 19.0266 4.85277 18.0136 5.19291C15.1018 6.16929 12.1902 7.14539 9.27856 8.12121C6.48955 9.05562 3.70017 9.98918 0.910418 10.9219C0.60741 11.0231 0.304961 11.126 0 11.2286C0.00213953 11.2554 0.00567873 11.282 0.0106026 11.3084C0.169361 11.9063 0.530961 12.3241 1.10712 12.5453C1.45896 12.6794 1.8147 12.8028 2.16737 12.9307C4.52335 13.7819 6.87924 14.6329 9.23504 15.4837C11.3594 16.2502 13.484 17.0163 15.6088 17.7821C17.6283 18.5109 19.6476 19.2402 21.6667 19.9699C21.6999 19.982 21.7351 19.9879 21.7839 20V19.8594C21.7839 19.1942 21.7839 18.5289 21.7839 17.8636C21.7839 16.9219 21.198 16.1601 20.292 15.9172C19.1615 15.6142 18.0314 15.3091 16.9017 15.0019L9.3684 12.9625C7.98283 12.5876 6.59706 12.2118 5.21112 11.8349C5.08638 11.7996 4.96787 11.7448 4.85984 11.6727C4.74824 11.5996 4.75103 11.4979 4.85984 11.4197C4.95136 11.3566 5.05182 11.3076 5.15783 11.2747C5.55207 11.149 5.94883 11.0318 6.34474 10.9126C8.88971 10.1473 11.4347 9.38217 13.9796 8.61737C15.1543 8.2657 16.3169 7.86681 17.5368 7.68971C18.1785 7.59667 18.8219 7.54719 19.4653 7.67538C20.3796 7.85753 20.9801 8.3863 21.2317 9.30102C21.3433 9.7016 21.3799 10.1103 21.3802 10.5238C21.3802 12.0137 21.3835 13.5036 21.3802 14.9935C21.3772 15.1037 21.3999 15.2131 21.4467 15.3128C21.4934 15.4125 21.5628 15.4998 21.6491 15.5675C21.862 15.7454 22.1109 15.8382 22.3815 15.8871C22.6974 15.9433 22.9761 15.8185 23.2613 15.7229C26.442 14.6568 29.6228 13.5899 32.8035 12.5222C36.1703 11.3937 39.537 10.2655 42.9038 9.1377C43.2687 9.01542 43.6328 8.89173 43.9944 8.76945C43.9978 8.7527 43.9997 8.73567 44 8.71857Z"
                    fill="white" />
            </svg>
        </a>
        <ul class="flex items-center gap-2">
            <li>
                <a href="https://www.facebook.com/share/1Ah3HpQrNq/?mibextid=wwXIfr">
                    <svg width="21" height="21" viewBox="0 0 21 21" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M20.5897 10.2954C20.5897 15.434 16.8249 19.6931 11.9034 20.4652V13.2712H14.3022L14.7587 10.2954H11.9034V8.36427C11.9034 7.54993 12.3024 6.7565 13.5812 6.7565H14.8793V4.223C14.8793 4.223 13.701 4.02192 12.5746 4.02192C10.2233 4.02192 8.6863 5.44712 8.6863 8.02727V10.2954H6.07237V13.2712H8.6863V20.4652C3.76487 19.6931 0 15.434 0 10.2954C0 4.60986 4.60937 0.000488281 10.2949 0.000488281C15.9804 0.000488281 20.5897 4.60986 20.5897 10.2954Z"
                            fill="white" />
                        <path
                            d="M14.3022 13.2709L14.7586 10.295H11.9034V8.36391C11.9034 7.54977 12.3023 6.75618 13.5811 6.75618H14.8793V4.22268C14.8793 4.22268 13.7012 4.02161 12.5748 4.02161C10.2232 4.02161 8.68626 5.4468 8.68626 8.02696V10.295H6.07233V13.2709H8.68626V20.4648C9.21041 20.5471 9.7476 20.5899 10.2948 20.5899C10.8421 20.5899 11.3793 20.5471 11.9034 20.4648V13.2709H14.3022Z"
                            fill="black" />
                    </svg>
                </a>
            </li>
            <li>
                <a href="https://www.tiktok.com/@vanaci_official?_t=ZS-8zH1Wdi6i4w&_r=1">
                    <svg width="21" height="21" viewBox="0 0 21 21" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M10.6526 0C5.00202 0 0.419739 4.58228 0.419739 10.2329C0.419739 15.8834 5.00202 20.4657 10.6526 20.4657C16.3032 20.4657 20.8855 15.8834 20.8855 10.2329C20.8855 4.58228 16.3032 0 10.6526 0ZM15.7862 7.82946V9.21501C15.1329 9.21525 14.4981 9.08722 13.8994 8.83463C13.5144 8.67211 13.1557 8.46269 12.8277 8.20963L12.8375 12.4744C12.8334 13.4347 12.4535 14.337 11.7658 15.0166C11.2062 15.5699 10.4971 15.9216 9.72852 16.0355C9.54793 16.0623 9.36414 16.076 9.17827 16.076C8.35552 16.076 7.57443 15.8094 6.93547 15.3177C6.81524 15.2251 6.70024 15.1248 6.59075 15.0166C5.84551 14.2801 5.46122 13.2818 5.52594 12.2316C5.5753 11.4322 5.89536 10.6698 6.42891 10.0723C7.13481 9.28156 8.12236 8.84267 9.17827 8.84267C9.36414 8.84267 9.54793 8.85662 9.72852 8.88336V9.39564V10.8207C9.55728 10.7642 9.37441 10.7332 9.18398 10.7332C8.2193 10.7332 7.43884 11.5202 7.45327 12.4856C7.46242 13.1033 7.79983 13.6433 8.29748 13.9409C8.53136 14.0808 8.80041 14.1675 9.08753 14.1832C9.31249 14.1956 9.5285 14.1642 9.72852 14.0982C10.4178 13.8705 10.915 13.2231 10.915 12.4596L10.9173 9.6037V4.38974H12.8254C12.8272 4.5788 12.8464 4.76328 12.882 4.94203C13.0261 5.66557 13.4339 6.29329 14.0015 6.72123C14.4964 7.09453 15.1127 7.31581 15.7807 7.31581C15.7811 7.31581 15.7867 7.31581 15.7862 7.31537V7.82946H15.7862Z"
                            fill="white" />
                    </svg>
                </a>
            </li>
            <li>
                <a href="https://www.instagram.com/vanaci_official?igsh=ZXR6dGU3NXlvMzhn">
                    <svg width="21" height="21" viewBox="0 0 21 21" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M10.8928 12.4068C12.0588 12.4068 13.0041 11.4616 13.0041 10.2956C13.0041 9.12957 12.0588 8.18433 10.8928 8.18433C9.7268 8.18433 8.78156 9.12957 8.78156 10.2956C8.78156 11.4616 9.7268 12.4068 10.8928 12.4068Z"
                            fill="white" />
                        <path
                            d="M10.8929 0.241943C5.34045 0.241943 0.839294 4.7431 0.839294 10.2955C0.839294 15.848 5.34045 20.3491 10.8929 20.3491C16.4453 20.3491 20.9465 15.848 20.9465 10.2955C20.9465 4.7431 16.4453 0.241943 10.8929 0.241943ZM17.1043 12.8508C17.0561 13.8066 16.7875 14.7491 16.0909 15.4383C15.3876 16.134 14.4406 16.3932 13.4756 16.441H8.31024C7.34509 16.3932 6.3982 16.1341 5.6949 15.4383C4.9983 14.7491 4.72975 13.8066 4.68149 12.8508V7.74031C4.72975 6.7845 4.99834 5.84195 5.6949 5.15276C6.3982 4.45705 7.34521 4.19783 8.31024 4.15009H13.4755C14.4407 4.19783 15.3876 4.45693 16.0909 5.15276C16.7875 5.84195 17.056 6.7845 17.1043 7.74031L17.1043 12.8508Z"
                            fill="white" />
                        <path
                            d="M13.4103 5.31372C12.1521 5.27922 9.63389 5.27922 8.37574 5.31372C7.72101 5.3317 6.97878 5.49468 6.51229 5.99294C6.02755 6.51086 5.84437 7.1366 5.82579 7.83661C5.79314 9.06524 5.82579 12.7529 5.82579 12.7529C5.84707 13.4528 6.02755 14.0786 6.51229 14.5966C6.97878 15.095 7.72101 15.2578 8.37574 15.2758C9.63389 15.3103 12.1521 15.3103 13.4103 15.2758C14.065 15.2578 14.8072 15.0948 15.2737 14.5966C15.7585 14.0786 15.9416 13.4529 15.9602 12.7529V7.83661C15.9416 7.1366 15.7585 6.51086 15.2737 5.99294C14.8071 5.49452 14.0648 5.3317 13.4103 5.31372ZM10.8928 13.5672C10.2456 13.5672 9.61292 13.3753 9.07477 13.0157C8.53662 12.6561 8.11718 12.145 7.8695 11.5471C7.62181 10.9491 7.55701 10.2911 7.68328 9.65633C7.80955 9.02154 8.12121 8.43844 8.57887 7.98078C9.03653 7.52312 9.61963 7.21145 10.2544 7.08519C10.8892 6.95892 11.5472 7.02372 12.1452 7.27141C12.7431 7.51909 13.2542 7.93853 13.6138 8.47668C13.9734 9.01483 14.1653 9.64752 14.1653 10.2947C14.1653 11.1627 13.8205 11.995 13.2068 12.6087C12.5931 13.2224 11.7607 13.5672 10.8928 13.5672ZM14.1792 7.69779C14.0498 7.69776 13.9232 7.65934 13.8156 7.58741C13.708 7.51547 13.6242 7.41324 13.5746 7.29365C13.5251 7.17405 13.5122 7.04246 13.5375 6.91552C13.5627 6.78857 13.6251 6.67196 13.7166 6.58045C13.8082 6.48893 13.9248 6.42661 14.0517 6.40137C14.1787 6.37613 14.3103 6.3891 14.4299 6.43865C14.5494 6.48819 14.6516 6.57207 14.7236 6.6797C14.7955 6.78733 14.8338 6.91386 14.8338 7.0433C14.8338 7.12926 14.8169 7.21438 14.784 7.2938C14.7511 7.37321 14.7029 7.44537 14.6421 7.50615C14.5813 7.56693 14.5091 7.61513 14.4297 7.64801C14.3503 7.6809 14.2652 7.69781 14.1792 7.69779Z"
                            fill="white" />
                    </svg>
                </a>
            </li>

            <li>
                <a href="https://t.me/+855967777516">
                    <svg width="21" height="21" viewBox="0 0 21 21" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M10.7052 20.5901C16.3922 20.5901 21 15.9823 21 10.2952C21 4.60818 16.3922 0.000366211 10.7052 0.000366211C5.01809 0.000366211 0.410278 4.60818 0.410278 10.2952C0.410278 15.9823 5.01809 20.5901 10.7052 20.5901ZM5.12104 10.0722L15.047 6.24507C15.5077 6.07863 15.9101 6.35745 15.7608 7.05407L15.7617 7.05321L14.0716 15.0154C13.9463 15.5799 13.6109 15.7172 13.1416 15.4513L10.5679 13.5544L9.3265 14.7503C9.18923 14.8876 9.07341 15.0034 8.80746 15.0034L8.9902 12.3842L13.7602 8.07498C13.9678 7.89224 13.7138 7.7893 13.4402 7.97117L7.54548 11.6825L5.00437 10.8898C4.45273 10.7148 4.44072 10.3381 5.12104 10.0722Z"
                            fill="white" />
                    </svg>
                </a>

            </li>
        </ul>
    </div>
    <ul class="p-4 space-y-4 text-[#000] mt-4">
        <li>
            <a href="{{ route('item', ['filter' => 'new']) }}" class="block text-[20px] italic">New Arrivals</a>
        </li>

        @foreach ($types as $type)
            <li x-data="{ open: false }" class="relative">
                <button @click="open = !open"
                    class="w-full text-left text-[20px] italic flex justify-between items-center">
                    {{ $type->type }}
                    <svg :class="open ? 'rotate-180' : ''" class="w-5 h-5 ml-2 transition-transform duration-300"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                        </path>
                    </svg>
                </button>

                @php
                    $typeCategories = $categories->where('type_id', $type->id);
                @endphp

                @if ($typeCategories->isNotEmpty())
                    <ul x-show="open" x-transition class="mt-2 pl-4 space-y-1 italic">
                        <!-- "All" link -->
                        <li>
                            <a href="{{ route('item', ['type' => $type->slug]) }}" class="block">All</a>
                        </li>

                        <!-- Categories under this type -->
                        @foreach ($typeCategories as $category)
                            <li>
                                <a href="{{ route('item', ['type' => $type->slug, 'category' => $category->slug]) }}"
                                    class="block">{{ $category->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </li>
        @endforeach
    </ul>

    <div class="absolute bottom-4 left-1/2 -translate-x-1/2">
        <ul class="flex items-center gap-2">
            <li>
                <a href="https://www.facebook.com/share/1Ah3HpQrNq/?mibextid=wwXIfr">
                    <svg width="25" height="25" viewBox="0 0 34 34" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M33.3157 16.6582C33.3157 24.9728 27.2239 31.8644 19.2606 33.1137V21.4734H23.1421L23.8806 16.6582H19.2606V13.5336C19.2606 12.2159 19.9061 10.9321 21.9754 10.9321H24.0758V6.83269C24.0758 6.83269 22.1693 6.50734 20.3467 6.50734C16.542 6.50734 14.0551 8.81341 14.0551 12.9883V16.6582H9.82553V21.4734H14.0551V33.1137C6.09183 31.8644 0 24.9728 0 16.6582C0 7.45866 7.45829 0.000366211 16.6579 0.000366211C25.8574 0.000366211 33.3157 7.45866 33.3157 16.6582Z"
                            fill="white" />
                        <path
                            d="M23.142 21.4731L23.8805 16.658H19.2606V13.5332C19.2606 12.2159 19.9059 10.9318 21.9752 10.9318H24.0757V6.83243C24.0757 6.83243 22.1694 6.50708 20.3469 6.50708C16.5419 6.50708 14.055 8.81315 14.055 12.988V16.658H9.82544V21.4731H14.055V33.1134C14.9031 33.2464 15.7723 33.3158 16.6578 33.3158C17.5432 33.3158 18.4124 33.2464 19.2606 33.1134V21.4731H23.142Z"
                            fill="#0C0C0B" />
                    </svg>

                </a>
            </li>
            <li>
                <a href="https://www.tiktok.com/@vanaci_official?_t=ZS-8zH1Wdi6i4w&_r=1">
                    <svg width="25" height="25" viewBox="0 0 34 34" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M16.5575 0C7.41446 0 0 7.41446 0 16.5575C0 25.7005 7.41446 33.115 16.5575 33.115C25.7005 33.115 33.115 25.7005 33.115 16.5575C33.115 7.41446 25.7005 0 16.5575 0ZM24.8641 12.6686V14.9106C23.8069 14.9109 22.7798 14.7038 21.811 14.2951C21.1881 14.0321 20.6078 13.6933 20.0769 13.2838L20.0929 20.1844C20.0862 21.7383 19.4714 23.1983 18.3588 24.298C17.4533 25.1931 16.3059 25.7624 15.0623 25.9466C14.7701 25.9899 14.4727 26.0121 14.1719 26.0121C12.8407 26.0121 11.5768 25.5808 10.5429 24.7852C10.3484 24.6354 10.1623 24.473 9.98515 24.298C8.77929 23.1062 8.15748 21.4909 8.26219 19.7917C8.34207 18.4982 8.85995 17.2646 9.72327 16.2977C10.8655 15.0182 12.4634 14.3081 14.1719 14.3081C14.4727 14.3081 14.7701 14.3306 15.0623 14.3739V15.2028V17.5087C14.7852 17.4173 14.4893 17.3671 14.1812 17.3671C12.6202 17.3671 11.3574 18.6406 11.3808 20.2027C11.3956 21.2021 11.9415 22.0758 12.7468 22.5574C13.1252 22.7838 13.5605 22.924 14.0251 22.9495C14.3891 22.9695 14.7386 22.9188 15.0623 22.8119C16.1775 22.4435 16.982 21.396 16.982 20.1605L16.9857 15.5395V7.10291H20.0732C20.0762 7.40884 20.1072 7.70732 20.1649 7.99656C20.3979 9.1673 21.0578 10.183 21.9763 10.8754C22.7771 11.4795 23.7743 11.8375 24.8551 11.8375C24.8559 11.8375 24.8648 11.8375 24.864 11.8368V12.6686H24.8641Z"
                            fill="white" />
                    </svg>

                </a>
            </li>
            <li>
                <a href="https://www.instagram.com/vanaci_official?igsh=ZXR6dGU3NXlvMzhn">
                    <svg width="25" height="25" viewBox="0 0 33 33" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M16.2672 19.6841C18.1539 19.6841 19.6834 18.1547 19.6834 16.268C19.6834 14.3813 18.1539 12.8518 16.2672 12.8518C14.3805 12.8518 12.8511 14.3813 12.8511 16.268C12.8511 18.1547 14.3805 19.6841 16.2672 19.6841Z"
                            fill="white" />
                        <path
                            d="M16.2674 0.000732422C7.28319 0.000732422 0 7.28392 0 16.2682C0 25.2524 7.28319 32.5356 16.2674 32.5356C25.2517 32.5356 32.5349 25.2524 32.5349 16.2682C32.5349 7.28392 25.2517 0.000732422 16.2674 0.000732422ZM26.318 20.4027C26.2399 21.9493 25.8053 23.4744 24.6782 24.5895C23.5402 25.7152 22.0079 26.1346 20.4464 26.2119H12.0885C10.5269 26.1346 8.99472 25.7154 7.85671 24.5895C6.72958 23.4744 6.29504 21.9493 6.21696 20.4027V12.1336C6.29504 10.5871 6.72964 9.06195 7.85671 7.94679C8.99472 6.82108 10.527 6.40164 12.0885 6.3244H20.4463C22.008 6.40164 23.5401 6.82089 24.6781 7.94679C25.8053 9.06195 26.2398 10.5871 26.3179 12.1336L26.318 20.4027Z"
                            fill="white" />
                        <path
                            d="M20.3406 8.20703C18.3048 8.1512 14.2302 8.1512 12.1944 8.20703C11.135 8.23612 9.93402 8.49985 9.17921 9.30606C8.39486 10.1441 8.09847 11.1566 8.0684 12.2892C8.01557 14.2773 8.0684 20.2442 8.0684 20.2442C8.10283 21.3767 8.39486 22.3893 9.17921 23.2273C9.93402 24.0338 11.135 24.2973 12.1944 24.3264C14.2302 24.3822 18.3048 24.3822 20.3406 24.3264C21.4 24.2973 22.601 24.0336 23.3558 23.2273C24.1402 22.3893 24.4366 21.3768 24.4666 20.2442V12.2892C24.4366 11.1566 24.1402 10.1441 23.3558 9.30606C22.6008 8.49959 21.3998 8.23612 20.3406 8.20703ZM16.2673 21.5618C15.22 21.5618 14.1962 21.2512 13.3255 20.6694C12.4547 20.0875 11.776 19.2606 11.3753 18.293C10.9745 17.3255 10.8696 16.2608 11.0739 15.2337C11.2783 14.2065 11.7826 13.2631 12.5231 12.5225C13.2636 11.782 14.2071 11.2777 15.2342 11.0734C16.2614 10.8691 17.326 10.9739 18.2936 11.3747C19.2611 11.7755 20.0881 12.4542 20.6699 13.3249C21.2518 14.1957 21.5623 15.2194 21.5623 16.2667C21.5623 17.671 21.0044 19.0179 20.0114 20.0109C19.0184 21.0039 17.6716 21.5618 16.2673 21.5618ZM21.5848 12.0646C21.3754 12.0646 21.1707 12.0024 20.9965 11.886C20.8224 11.7696 20.6867 11.6042 20.6066 11.4107C20.5265 11.2172 20.5056 11.0043 20.5465 10.7989C20.5873 10.5934 20.6882 10.4048 20.8363 10.2567C20.9845 10.1086 21.1732 10.0078 21.3786 9.96694C21.584 9.9261 21.7969 9.94708 21.9904 10.0272C22.1839 10.1074 22.3493 10.2431 22.4656 10.4173C22.582 10.5914 22.6441 10.7962 22.6441 11.0056C22.6441 11.1447 22.6167 11.2824 22.5635 11.4109C22.5102 11.5394 22.4322 11.6562 22.3338 11.7545C22.2355 11.8529 22.1187 11.9309 21.9902 11.9841C21.8616 12.0373 21.7239 12.0647 21.5848 12.0646Z"
                            fill="white" />
                    </svg>

                </a>
            </li>

            <li>
                <a href="https://t.me/+855967777516">
                    <svg width="25" height="25" viewBox="0 0 34 34" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M16.6579 33.3161C25.8599 33.3161 33.3157 25.8603 33.3157 16.6582C33.3157 7.45614 25.8599 0.000366211 16.6579 0.000366211C7.45578 0.000366211 0 7.45614 0 16.6582C0 25.8603 7.45578 33.3161 16.6579 33.3161ZM7.62236 16.2973L23.6833 10.1047C24.4287 9.83544 25.0798 10.2866 24.8382 11.4138L24.8396 11.4124L22.105 24.2958C21.9023 25.2093 21.3595 25.4314 20.6002 25.001L16.4357 21.9318L14.4271 23.8669C14.205 24.089 14.0176 24.2764 13.5873 24.2764L13.8829 20.0384L21.6011 13.0657C21.937 12.77 21.5261 12.6034 21.0833 12.8977L11.5453 18.9029L7.43357 17.6202C6.54098 17.337 6.52155 16.7276 7.62236 16.2973Z"
                            fill="white" />
                    </svg>

                </a>
            </li>
        </ul>
    </div>
</div>


<script>
    document.addEventListener("DOMContentLoaded", () => {
        const hamburger = document.getElementById('hamburger');
        const drawer = document.getElementById('drawer');
        const closeDrawer = document.getElementById('closeDrawer');
        const searchIcon = document.getElementById('search-icon');
        const searchSection = document.getElementById('search-section');
        const searchBtn = document.getElementById('search-btn');
        // 🧭 Drawer toggle
        if (hamburger && drawer && closeDrawer) {
            const hamburgerIcon = document.getElementById('hamburgerIcon');
            const closeIcon = document.getElementById('closeIcon');

            hamburger.addEventListener('click', () => {
                const isOpen = !drawer.classList.contains('-translate-x-full');
                drawer.classList.toggle('-translate-x-full');

                // Change icon + background
                if (isOpen) {
                    hamburger.classList.remove('bg-black');
                    hamburgerIcon.classList.remove('hidden');
                    closeIcon.classList.add('hidden');
                } else {
                    hamburger.classList.add('bg-black');
                    hamburgerIcon.classList.add('hidden');
                    closeIcon.classList.remove('hidden');
                }
            });

            closeDrawer.addEventListener('click', () => {
                drawer.classList.add('-translate-x-full');
                hamburger.classList.remove('bg-black');
                hamburgerIcon.classList.remove('hidden');
                closeIcon.classList.add('hidden');
            });
        }

        // 🔍 Toggle Search Section + Load Items
        if (searchIcon && searchSection && searchBtn) {
            searchIcon.addEventListener('click', async () => {
                const isActive = !searchSection.classList.contains('hidden');

                // Toggle section visibility
                searchSection.classList.toggle('hidden');

                // Change background and icon color
                if (!isActive) {
                    searchBtn.classList.add('bg-black');
                    searchIcon.classList.replace('text-black', 'text-white');
                } else {
                    searchBtn.classList.remove('bg-black');
                    searchIcon.classList.replace('text-white', 'text-black');
                }

                // If opening, load items
                if (!isActive) {
                    const url = new URL(window.location);
                    const currentType = url.searchParams.get('type');
                    const currentFilter = url.searchParams.get('filter');

                    if (!currentType || currentFilter === 'new') {
                        url.pathname = '/item';
                        url.searchParams.set('type', 'men');
                        url.searchParams.delete('filter');
                        window.history.pushState({}, '', url);
                    }

                    const alpineComp = Alpine.$data(searchSection);
                    if (!alpineComp) return console.warn('⚠️ Alpine component not found.');

                    alpineComp.selectedType = 'men';
                    alpineComp.currentFilter = '';
                    alpineComp.isLoading = true;

                    try {
                        const res = await fetch(`/item?type=men`);
                        const text = await res.text();
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(text, 'text/html');
                        const dataAttr = doc.querySelector('#search-section')?.getAttribute(
                            'data-items');
                        const newItems = JSON.parse(dataAttr || '[]');
                        alpineComp.items = newItems.map(formatItem);
                        Alpine.flushAndStopDeferringMutations();
                    } catch (err) {
                        console.error('⚠️ Failed to load items:', err);
                    } finally {
                        alpineComp.isLoading = false;
                    }
                }
            });
        }
    });

    // 🧠 Common helper to normalize item structure
    function formatItem(i) {
        return {
            id: i.id,
            name: i.name,
            slug: i.slug,
            type: i.type?.slug?.toLowerCase?.() || i.type?.toLowerCase?.() || '',
            price: parseFloat(i.price || 0),
            discount: parseFloat(i.discount || 0),
            status: Boolean(i.status),
            image: i.image || '/assets/images/no-image.png',
            color: i.color || '',
            sizes: Array.isArray(i.sizes) ?
                i.sizes : (Array.isArray(i.size) ? i.size : [])
        };
    }

    document.addEventListener('alpine:init', () => {
        // // 🛒 Cart Store
        Alpine.store('cart', {
            items: JSON.parse(localStorage.getItem('cart_items') || '[]'),

            get count() {
                return this.items.reduce((sum, i) => sum + i.qty, 0);
            },
            get total() {
                return this.items.reduce((sum, item) => {
                    const price = item.discount > 0 ?
                        item.price * (1 - item.discount / 100) :
                        item.price;
                    return sum + price * item.qty;
                }, 0).toFixed(2);
            },
            add(item) {
                const existing = this.items.find(i => i.id === item.id && i.size === item.size);
                if (existing) existing.qty++;
                else this.items.push({
                    ...item,
                    qty: 1
                });
                this.save();
            },
            save() {
                localStorage.setItem('cart_items', JSON.stringify(this.items));
            },
        });

        // 🔍 Search Component
        Alpine.data('searchComponent', (items, types, currentType, currentFilter) => ({
            query: '',
            types: types.map(t => ({
                id: t.id,
                type: t.type,
                slug: (t.slug || '').toLowerCase()
            })),
            selectedType: (currentType || types[0]?.slug || '').toLowerCase(),
            currentFilter: currentFilter || '',
            items: (items || []).map(formatItem),
            loading: false, // 👈 NEW

            get filteredItems() {
                let results = this.items;
                if (this.selectedType) results = results.filter(i => i.type === this
                    .selectedType);
                if (this.currentFilter === 'new') results = results.filter(i => i.status ===
                    true);
                if (this.query.trim()) {
                    const q = this.query.toLowerCase();
                    results = results.filter(i => i.name.toLowerCase().includes(q));
                }
                return results;
            },

            async selectType(slug) {
                this.selectedType = slug;
                this.currentFilter = '';
                this.loading = true; // 👈 show loading before fetch

                const url = new URL(window.location);
                url.pathname = '/item';
                url.searchParams.set('type', slug);
                window.history.pushState({}, '', url);

                try {
                    const res = await fetch(`/item?type=${slug}`);
                    const text = await res.text();
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(text, 'text/html');
                    const dataAttr = doc.querySelector('#search-section')?.getAttribute(
                        'data-items');
                    const newItems = JSON.parse(dataAttr || '[]');

                    this.items = newItems.map(formatItem);
                } catch (error) {
                    console.error('⚠️ Failed to load items for type:', slug, error);
                } finally {
                    this.loading = false; // 👈 hide loading after fetch
                }
            },

            formatCurrency(value) {
                return `$${parseFloat(value).toFixed(2)}`;
            }
        }));

    });
</script>
