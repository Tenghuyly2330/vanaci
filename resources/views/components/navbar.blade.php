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
<div class="sticky top-0 left-0 w-full flex items-center justify-between h-16 lg:h-20 text-white px-4 z-[45] bg-white">

    <div class="flex items-center gap-2" x-data="{ cartOpen: false, menuOpen: false }">
        <div class="flex items-center gap-2 text-[#000]">
            <div @click="menuOpen = !menuOpen" class="cursor-pointer p-3 rounded-full transition-all duration-300">
                <svg class="w-6 h-6" viewBox="0 0 25 20" fill="none">
                    <rect width="24.1667" height="1.66667" fill="black" />
                    <rect y="9.16666" width="24.1667" height="1.66667" fill="black" />
                    <rect y="18.3333" width="24.1667" height="1.66667" fill="black" />
                </svg>
            </div>
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


            </div>

            <!-- Menu Items -->
            <ul class="p-4 space-y-4 text-[#000] mt-4">
                <li>
                    <a href="{{ route('item', ['filter' => 'new']) }}" class="block text-[20px] italic">New Arrivals</a>
                </li>

                <li>
                    <a href="{{ route('item', ['filter' => 'promotion']) }}"
                        class="block text-[20px] italic">Promotion</a>
                </li>

                <li>
                    <a href="{{ route('item', ['filter' => 'best_sellers']) }}" class="block text-[20px] italic">Best
                        Sales</a>
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

            <div class="fixed w-full md:w-96 bottom-4">
                <div class="flex items-center justify-center gap-2 pt-10">
                    <svg width="16" height="12" viewBox="0 0 16 12" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M15.3728 0.0756024C15.2937 0.124453 15.2186 0.206451 15.1349 0.216337C14.2492 0.323343 13.5891 0.790331 13.1605 1.54228C12.5918 2.54197 12.0649 3.56666 11.5438 4.5931C10.3664 6.91272 9.19764 9.23719 8.03764 11.5665C7.95564 11.7305 7.8719 11.8171 7.66952 11.8154C7.47819 11.8154 7.42992 11.7148 7.36363 11.5752C5.91982 8.52323 4.47291 5.4728 3.02291 2.42391C2.87345 2.10987 2.68968 1.81212 2.53092 1.50215C2.07905 0.619354 1.34339 0.210521 0.369874 0.190749C0.292527 0.190749 0.215181 0.182608 0.137253 0.173885C0.120969 0.173885 0.106424 0.152949 0 0.0738578C0.167487 0.0395462 0.264022 0.00232621 0.36056 0.00232621C2.28899 -0.000775404 4.21742 -0.000775404 6.14584 0.00232621H6.98387C6.9955 0.0337301 7.00712 0.065133 7.01817 0.0959553C6.94722 0.133756 6.88035 0.190168 6.80417 0.20587C6.55875 0.257046 6.30461 0.273329 6.06269 0.337881C5.29155 0.543169 4.94843 1.20207 5.26247 1.93192C5.85216 3.30031 6.4686 4.65649 7.07516 6.01732C7.58286 7.15542 8.09231 8.29236 8.62617 9.48629C8.69829 9.35137 8.75237 9.25832 8.80064 9.16178C9.8137 7.10696 10.8248 5.04982 11.834 2.99034C11.9827 2.67551 12.1045 2.34868 12.1981 2.01333C12.4964 0.995617 12.0102 0.294265 10.9553 0.190749C10.8666 0.175254 10.7793 0.152695 10.6942 0.123288C10.7011 0.0907214 10.7075 0.057574 10.7145 0.0244255C10.7872 0.0138801 10.8604 0.00708596 10.9338 0.0040708C12.3295 0.0040708 13.7252 0.0040708 15.1209 0.0040708C15.2047 0.0040708 15.2884 0.0505956 15.3728 0.0756024Z"
                            fill="black" />
                    </svg>
                    <svg width="16" height="12" viewBox="0 0 16 12" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M15.1698 11.6013C15.1034 11.5877 15.0358 11.5803 14.968 11.5793C14.4446 11.5083 13.8997 11.4455 13.5397 11.0221C13.1906 10.6224 12.8891 10.1835 12.6412 9.71421C11.0338 6.56026 9.44287 3.39816 7.86841 0.227927C7.74163 -0.0273744 7.56891 0.0238025 7.37525 0.00286661C7.1816 -0.0180693 7.10599 0.0773053 7.03271 0.235488C6.12956 2.16217 5.22991 4.0906 4.31106 6.01089C3.67135 7.35485 3.03571 8.70522 2.33378 10.0184C1.89471 10.8413 1.25267 11.4862 0.240189 11.6019C0.155863 11.6112 0.0796727 11.6909 0 11.738C0.0843251 11.763 0.168656 11.8101 0.252981 11.8107C1.62971 11.8154 3.00605 11.8154 4.382 11.8107C4.48901 11.8107 4.59543 11.7526 4.70244 11.7182C4.59834 11.674 4.49831 11.606 4.39014 11.5891C3.44802 11.4437 2.70015 10.7779 3.14388 9.64617C3.47187 8.81048 3.86965 8.00096 4.24883 7.1862C4.28081 7.11816 4.41572 7.06175 4.50296 7.06117C5.90876 7.0538 7.31418 7.05497 8.71921 7.06466C8.77531 7.0717 8.82919 7.09098 8.87703 7.12112C8.92486 7.15127 8.96548 7.19155 8.99603 7.23912C9.19667 7.60318 9.38044 7.97769 9.55375 8.35629C9.83231 8.96168 10.1248 9.56243 10.358 10.1859C10.5034 10.5743 10.358 10.9488 10.0091 11.178C9.773 11.3321 9.49327 11.4315 9.22052 11.517C9.02046 11.5793 8.79947 11.5752 8.59069 11.6107C8.53893 11.6205 8.49649 11.6828 8.44996 11.7211C8.49754 11.7576 8.55 11.7871 8.60581 11.809C8.67286 11.8184 8.74078 11.82 8.80819 11.8136H12.9081C13.6543 11.8136 14.4004 11.8136 15.1471 11.809C15.2128 11.809 15.2786 11.7462 15.3443 11.7124C15.2906 11.6687 15.2321 11.6315 15.1698 11.6013ZM4.48203 6.68432L6.54887 2.23196L8.73957 6.68432H4.48203Z"
                            fill="black" />
                    </svg>
                    <svg width="16" height="12" viewBox="0 0 16 12" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M15.2471 0.10439C15.1789 0.136443 15.1088 0.164407 15.0372 0.188133C14.64 0.298628 14.2166 0.351549 13.8497 0.525433C13.2489 0.809812 13.0762 1.38555 13.05 2.00432C13.0285 2.50736 13.0279 3.01157 13.0274 3.51636C13.0274 6.17095 13.0274 8.82671 13.0274 11.4836V11.782C12.7471 11.8401 12.5476 11.8174 12.34 11.6017C9.1515 8.28528 5.95646 4.97489 2.75482 1.67051C2.7307 1.65368 2.70475 1.63964 2.67747 1.62864C2.66505 1.68947 2.6567 1.75105 2.65247 1.81299C2.65247 4.31328 2.65247 6.81395 2.65247 9.31502C2.65052 9.6057 2.67523 9.89595 2.72631 10.1821C2.88449 11.0207 3.46547 11.4953 4.40759 11.5848C4.5235 11.5912 4.63888 11.605 4.75303 11.6261C4.79141 11.6348 4.81642 11.7005 4.84725 11.7424C4.81338 11.7691 4.77717 11.7926 4.73907 11.8128C4.71065 11.8184 4.68142 11.8184 4.653 11.8128C3.15143 11.8128 1.64967 11.8128 0.147717 11.8128C0.10983 11.8096 0.0722882 11.8031 0.035481 11.7936L0 11.7116C0.0748329 11.6665 0.154657 11.6302 0.23786 11.6034C0.502467 11.5505 0.780446 11.5453 1.03458 11.4604C1.72023 11.24 2.10639 10.7549 2.16919 10.0338C2.20118 9.66744 2.22095 9.29932 2.22211 8.92887C2.22676 6.83528 2.22676 4.74169 2.22211 2.6481C2.2199 2.33826 2.20049 2.02879 2.16395 1.7211C2.06858 0.892974 1.50041 0.367833 0.583881 0.243962C0.459429 0.227097 0.331491 0.226514 0.209365 0.197437C0.141323 0.181153 0.0831677 0.122998 0.02036 0.0811262C0.0837492 0.0549563 0.146558 0.00726973 0.210529 0.00552507C0.539688 -0.00203511 0.869428 0.0020359 1.19917 0.0020359C2.0715 0.0020359 2.94383 -0.00610676 3.81615 0.0101767C3.97249 0.018611 4.12062 0.0827764 4.23371 0.19104C6.95886 3.03948 9.67859 5.89278 12.3929 8.75091C12.4523 8.82537 12.5077 8.90303 12.5586 8.98353C12.5749 8.81488 12.5877 8.74451 12.5877 8.67415C12.5877 6.67787 12.5877 4.68121 12.5877 2.68416C12.5843 2.36489 12.5649 2.04599 12.5295 1.72867C12.4516 0.972647 11.9759 0.453902 11.2228 0.293975C11.0053 0.248032 10.7814 0.232912 10.5633 0.19104C10.4941 0.178246 10.4331 0.124743 10.3679 0.0904312L10.3976 0.0241352H15.2245L15.2471 0.10439Z"
                            fill="black" />
                    </svg>
                    <svg width="16" height="12" viewBox="0 0 16 12" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M15.1698 11.6013C15.1034 11.5877 15.0358 11.5803 14.968 11.5793C14.4446 11.5083 13.8997 11.4455 13.5397 11.0221C13.1906 10.6224 12.8891 10.1835 12.6412 9.71421C11.0338 6.56026 9.44287 3.39816 7.86841 0.227927C7.74163 -0.0273744 7.56891 0.0238025 7.37525 0.00286661C7.1816 -0.0180693 7.10599 0.0773053 7.03271 0.235488C6.12956 2.16217 5.22991 4.0906 4.31106 6.01089C3.67135 7.35485 3.03571 8.70522 2.33378 10.0184C1.89471 10.8413 1.25267 11.4862 0.240189 11.6019C0.155863 11.6112 0.0796727 11.6909 0 11.738C0.0843251 11.763 0.168656 11.8101 0.252981 11.8107C1.62971 11.8154 3.00605 11.8154 4.382 11.8107C4.48901 11.8107 4.59543 11.7526 4.70244 11.7182C4.59834 11.674 4.49831 11.606 4.39014 11.5891C3.44802 11.4437 2.70015 10.7779 3.14388 9.64617C3.47187 8.81048 3.86965 8.00096 4.24883 7.1862C4.28081 7.11816 4.41572 7.06175 4.50296 7.06117C5.90876 7.0538 7.31418 7.05497 8.71921 7.06466C8.77531 7.0717 8.82919 7.09098 8.87703 7.12112C8.92486 7.15127 8.96548 7.19155 8.99603 7.23912C9.19667 7.60318 9.38044 7.97769 9.55375 8.35629C9.83231 8.96168 10.1248 9.56243 10.358 10.1859C10.5034 10.5743 10.358 10.9488 10.0091 11.178C9.773 11.3321 9.49327 11.4315 9.22052 11.517C9.02046 11.5793 8.79947 11.5752 8.59069 11.6107C8.53893 11.6205 8.49649 11.6828 8.44996 11.7211C8.49754 11.7576 8.55 11.7871 8.60581 11.809C8.67286 11.8184 8.74078 11.82 8.80819 11.8136H12.9081C13.6543 11.8136 14.4004 11.8136 15.1471 11.809C15.2128 11.809 15.2786 11.7462 15.3443 11.7124C15.2906 11.6687 15.2321 11.6315 15.1698 11.6013ZM4.48203 6.68432L6.54887 2.23196L8.73957 6.68432H4.48203Z"
                            fill="black" />
                    </svg>
                    <svg width="13" height="13" viewBox="0 0 13 13" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M12.7375 8.66026C12.5171 10.3631 11.5901 11.482 9.98618 11.9751C7.62334 12.6986 5.27559 12.5689 3.05929 11.4709C0.926737 10.4136 -0.0514239 8.58408 0.00207889 6.21658C0.0398798 4.54462 0.649351 3.10062 1.8677 1.94159C2.61907 1.22686 3.53792 0.798838 4.51493 0.480729C6.57479 -0.190383 8.62884 -0.137462 10.6829 0.506317C10.9234 0.58036 11.1678 0.641128 11.415 0.688343C11.6878 0.742428 11.9024 0.648215 12.0676 0.414431C12.1321 0.323127 12.2461 0.267881 12.338 0.195768L12.4206 0.253924L12.5462 4.07472L12.4589 4.13288C12.3764 4.05844 12.2635 3.99912 12.2164 3.90666C12.0007 3.48445 11.8308 3.03782 11.5947 2.62724C10.7689 1.19371 9.56629 0.349297 7.86874 0.287071C5.73503 0.209724 4.2509 1.25594 3.29773 3.05643C2.22535 5.0843 2.22535 7.1965 3.22853 9.25636C3.85719 10.5491 4.96854 11.3063 6.35787 11.6442C7.3814 11.8931 8.41366 11.889 9.44359 11.6884C11.0463 11.3755 12.0635 10.4363 12.4496 8.83589C12.5037 8.61665 12.5101 8.61665 12.7375 8.66026Z"
                            fill="black" />
                    </svg>
                    <svg width="7" height="12" viewBox="0 0 7 12" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M6.75356 11.7229L6.69541 11.7869H5.79633C3.95513 11.7869 2.11355 11.7857 0.271581 11.7834C0.187837 11.7834 0.104104 11.7363 0.02036 11.7107C0.100614 11.6648 0.176212 11.5944 0.262863 11.577C0.451286 11.5363 0.649006 11.5351 0.836266 11.4921C1.68359 11.2955 2.12672 10.7744 2.19011 9.90384C2.21221 9.60434 2.22386 9.30368 2.22444 9.0036C2.22715 6.93909 2.22715 4.87457 2.22444 2.81006C2.22444 2.51929 2.21221 2.22851 2.19476 1.93773C2.13312 0.932811 1.60042 0.360563 0.602481 0.222153C0.458837 0.202381 0.311708 0.199473 0.169809 0.170977C0.108746 0.158764 0.0535028 0.102354 0 0.0657157C0.00988639 0.0441983 0.0191912 0.022099 0.0290776 0H6.72332C6.73321 0.027333 6.74368 0.0540858 6.75356 0.0814188C6.6826 0.120285 6.60825 0.152597 6.53142 0.177955C6.21215 0.250067 5.87717 0.27682 5.57302 0.388478C4.97461 0.608305 4.64252 1.06657 4.58029 1.70162C4.54715 2.02904 4.52214 2.35878 4.52214 2.68736C4.51671 4.82941 4.51671 6.97146 4.52214 9.11351C4.52214 9.36474 4.54598 9.61539 4.56226 9.86662C4.63845 11.0239 5.32585 11.4461 6.34066 11.5584C6.43837 11.5599 6.53572 11.5706 6.63143 11.5903C6.6797 11.6066 6.71285 11.6776 6.75356 11.7229Z"
                            fill="black" />
                    </svg>


                </div>
            </div>
        </div>

        <!-- Cart Button -->
        <div class="relative">
            <button @click="cartOpen = !cartOpen" class="relative flex items-center gap-2 text-black">
                <span>Cart ( <span x-text="$store.cart.count > 0 ? $store.cart.count : 0"></span> )</span>
            </button>
        </div>

        <!-- Cart Drawer -->
        <div x-show="cartOpen" x-transition x-cloak x-data="{ tab: 'cart' }"
            class="fixed top-0 right-0 w-full md:w-[30rem] h-full bg-white shadow-lg border-l z-50 flex flex-col">

            <!-- Tabs -->
            <div class="flex border-b justify-between">
                <div class="text-[#000] px-4 py-4">
                    <button @click="tab = 'cart'"
                        :class="tab === 'cart' ? 'font-[400] border-b-2 border-black' : ''" class="px-4 py-2">
                        Cart ( <span x-text="$store.cart.count"></span> )
                    </button>

                    <button @click="tab = 'favorite'"
                        :class="tab === 'favorite' ? 'font-[400] border-b-2 border-black' : ''" class="px-4 py-2">
                        Favorite ( <span x-text="$store.favorite.count"></span> )
                    </button>
                </div>

                <div x-show="tab === 'cart'" class="flex items-center justify-between p-4 border-b">
                    <button @click="cartOpen = false" class="text-gray-800 hover:text-black">✕</button>
                </div>

                <div x-show="tab === 'favorite'" class="flex items-center justify-between p-4 border-b">
                    <button @click="cartOpen = false" class="text-gray-800 hover:text-black">✕</button>
                </div>
            </div>

            <!-- CART LIST -->
            <div x-show="tab === 'cart'" class="flex-1 overflow-y-auto">
                <div class="grid grid-cols-2 gap-4 items-start p-3">
                    <template x-for="(item, index) in $store.cart.items" :key="index">
                        <div class="flex flex-col text-[#000]">
                            <!-- Item image -->
                            <a :href="`/item/${item.slug}`" class="relative block mb-2">
                                <img :src="item.image" alt=""
                                    class="w-full h-[300px] object-cover transition">

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
                                            <span
                                                x-text="`$${(item.price * (1 - item.discount / 100)).toFixed(2)}`"></span>
                                            <span class="line-through text-gray-500 font-[400] text-[12px] pl-2"
                                                x-text="`$${item.price.toFixed(2)}`"></span>
                                        </template>

                                        <template x-if="!item.discount || item.discount == 0">
                                            <span x-text="`$${item.price.toFixed(2)}`"></span>
                                        </template>
                                    </p>

                                    <div class="flex items-center gap-2 mt-1">
                                        <span x-show="item.size"
                                            class="text-[14px] text-[#000] uppercase"
                                            x-text="item.size">
                                        </span>
                                        /
                                        <span
                                            class="text-[14px] text-[#000] capitalize"
                                            x-text="item.color"></span>
                                        /
                                        <span
                                            class="text-[14px] text-[#000]"
                                            x-text="item.stock"></span>
                                    </div>

                                    <div
                                        class="flex items-center border border-gray-300 rounded overflow-hidden w-max mt-2">
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

                                <div>
                                    <button @click="$store.cart.remove(index)"
                                        class="w-[32px] h-[32px] flex items-center justify-center transition">
                                        <img src="{{ asset('assets/images/icons/trash-red.svg') }}" alt=""
                                            class="w-6 h-6">

                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
                <p x-show="$store.cart.items.length === 0" class="text-center text-gray-500 mt-4">
                    Your cart is empty.
                </p>

                <h1 class="text-[20px] uppercase text-[#000] pt-10 px-4 text-center">What you may interest</h1>
                <div class="grid grid-cols-2 items-stretch gap-2 px-4 py-10">
                    @forelse ($items as $item)
                        @php
                            $sizes = is_array($item->size) ? $item->size : json_decode($item->size ?? '[]', true);
                            $colors = is_array($item->color) ? $item->color : json_decode($item->color ?? '[]', true);
                        @endphp

                        <div class="overflow-hidden relative">
                            <a href="{{ route('item.show', $item->slug) }}"
                                class="relative block border border-gray-300">
                                @php
                                    $colors = $item->color ?? [];
                                    $firstColor = $colors[0] ?? null;
                                    $firstCode = $firstColor['code'] ?? null;
                                    $firstName = $firstColor['name'] ?? null;
                                    $firstImage = $firstColor['images'][0] ?? null;
                                @endphp

                                @if ($firstImage)
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset($firstImage) }}"
                                            alt="{{ $firstColor['name'] ?? 'Color' }}"
                                            class="w-full h-[300px] object-cover transition">
                                    </div>
                                @else
                                    <img src="{{ asset('assets/images/default.jpg') }}" alt=""
                                        class="w-full h-[300px] object-cover transition">
                                @endif

                                @if ($item->discount && $item->discount > 0)
                                    @php
                                        // Discount is a percentage
                                        $discountedPrice = $item->price * (1 - $item->discount / 100);
                                    @endphp
                                    <!-- Discount badge -->
                                    <span
                                        class="absolute top-2 right-2 bg-green-500 text-white text-[14px] px-2 py-1 rounded">
                                        {{ number_format($item->discount, 0) }}%
                                    </span>
                                @endif
                            </a>

                            <div class="flex items-start justify-between p-2 mt-auto text-[#000]">
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
                                        <svg x-show="!added" x-cloak class="w-5 h-5 absolute inset-0 m-auto"
                                            viewBox="0 0 6 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M1.17606 1.4942H0.779054C0.504719 1.4942 0.277003 1.70623 0.257429 1.97997L0.00132482 5.56605C-0.00898516 5.71083 0.0412178 5.85338 0.140134 5.95962C0.239199 6.06586 0.377713 6.12622 0.52295 6.12622H4.66248C4.80771 6.12622 4.94623 6.06586 5.04529 5.95962C5.14421 5.85338 5.19441 5.71083 5.1841 5.56605L4.928 1.97997C4.90842 1.70623 4.68071 1.4942 4.40637 1.4942H4.0122V1.41949C4.0122 0.635483 3.37672 0 2.59271 0C1.8374 0 1.13931 0.601565 1.17322 1.41949C1.17427 1.44429 1.17517 1.46925 1.17606 1.4942ZM4.0122 1.94246V3.06311C4.0122 3.18683 3.91179 3.28724 3.78807 3.28724C3.66435 3.28724 3.56394 3.18683 3.56394 3.06311V1.94246H1.62148V3.06311C1.62148 3.18683 1.52107 3.28724 1.39735 3.28724C1.27363 3.28724 1.17322 3.18683 1.17322 3.06311C1.17322 3.06311 1.19265 2.53939 1.18622 1.94246H0.779054C0.739906 1.94246 0.707334 1.97279 0.704645 2.01179L0.448386 5.59787C0.446891 5.61864 0.454067 5.63896 0.468262 5.6542C0.482457 5.66929 0.50218 5.67796 0.52295 5.67796H4.66248C4.68325 5.67796 4.70297 5.66929 4.71717 5.6542C4.73136 5.63896 4.73854 5.61864 4.73704 5.59787L4.48078 2.01179C4.47809 1.97279 4.44552 1.94246 4.40637 1.94246H4.0122ZM3.56394 1.4942V1.41949C3.56394 0.883072 3.12913 0.44826 2.59271 0.44826C2.0563 0.44826 1.62148 0.883072 1.62148 1.41949V1.4942H3.56394Z"
                                                fill="black" />
                                        </svg>

                                        <!-- Added / Check Icon -->
                                        <svg x-show="added" x-cloak class="w-5 h-5 absolute inset-0 m-auto"
                                            viewBox="0 0 6 7" fill="none" xmlns="http://www.w3.org/2000/svg">
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

            </div>

            <!-- FAVORITE LIST -->
            <div x-show="tab === 'favorite'" class="flex-1 overflow-y-auto">

                <div class="grid grid-cols-2 gap-4 items-start p-3">
                    <template x-for="(item, index) in $store.favorite.items" :key="index">
                        <div class="flex flex-col text-[#000]">
                            <!-- Item image -->
                            <a :href="`/item/${item.slug}`" class="relative block border border-gray-300 mb-2">
                                <img :src="item.image" alt=""
                                    class="w-full h-[300px] object-cover transition">

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
                                            <span
                                                x-text="`$${(item.price * (1 - item.discount / 100)).toFixed(2)}`"></span>
                                            <span class="line-through text-gray-500 font-[400] text-[12px] pl-2"
                                                x-text="`$${item.price.toFixed(2)}`"></span>
                                        </template>

                                        <template x-if="!item.discount || item.discount == 0">
                                            <span x-text="`$${item.price.toFixed(2)}`"></span>
                                        </template>
                                    </p>
                                </div>

                                <div>
                                    <button @click="$store.favorite.remove(index)"
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

                <p x-show="$store.favorite.items.length === 0" class="text-center text-gray-500 mt-4">
                    No favorite items yet.
                </p>

            </div>


            <!-- FOOTER (CART ONLY) -->
            <div x-show="tab === 'cart'" class="p-4 border-t text-[#000]">
                <div class="flex justify-between font-semibold mb-4">
                    <span>Total:</span>
                    <span>$<span x-text="$store.cart.total"></span></span>
                </div>
                <button @click="$store.cart.checkout()"
                    class="w-full bg-black text-white py-2 rounded hover:bg-gray-800">
                    Checkout
                </button>
            </div>

        </div>

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
    class="hidden fixed top-0 left-0 w-full h-full bg-white flex flex-col items-center overflow-y-auto z-40 mt-16">

    <!-- 🔍 Search Input -->
    <div class="w-full max-w-3xl text-center pb-2 px-2 my-6">
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
    class="fixed top-0 left-0 h-screen overflow-y-auto w-full md:w-96 bg-[#FFF] shadow transform -translate-x-full transition-transform duration-300 z-40">
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
        <div class="flex items-center justify-center gap-2 pt-10">
            <svg width="16" height="12" viewBox="0 0 16 12" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M15.3728 0.0756024C15.2937 0.124453 15.2186 0.206451 15.1349 0.216337C14.2492 0.323343 13.5891 0.790331 13.1605 1.54228C12.5918 2.54197 12.0649 3.56666 11.5438 4.5931C10.3664 6.91272 9.19764 9.23719 8.03764 11.5665C7.95564 11.7305 7.8719 11.8171 7.66952 11.8154C7.47819 11.8154 7.42992 11.7148 7.36363 11.5752C5.91982 8.52323 4.47291 5.4728 3.02291 2.42391C2.87345 2.10987 2.68968 1.81212 2.53092 1.50215C2.07905 0.619354 1.34339 0.210521 0.369874 0.190749C0.292527 0.190749 0.215181 0.182608 0.137253 0.173885C0.120969 0.173885 0.106424 0.152949 0 0.0738578C0.167487 0.0395462 0.264022 0.00232621 0.36056 0.00232621C2.28899 -0.000775404 4.21742 -0.000775404 6.14584 0.00232621H6.98387C6.9955 0.0337301 7.00712 0.065133 7.01817 0.0959553C6.94722 0.133756 6.88035 0.190168 6.80417 0.20587C6.55875 0.257046 6.30461 0.273329 6.06269 0.337881C5.29155 0.543169 4.94843 1.20207 5.26247 1.93192C5.85216 3.30031 6.4686 4.65649 7.07516 6.01732C7.58286 7.15542 8.09231 8.29236 8.62617 9.48629C8.69829 9.35137 8.75237 9.25832 8.80064 9.16178C9.8137 7.10696 10.8248 5.04982 11.834 2.99034C11.9827 2.67551 12.1045 2.34868 12.1981 2.01333C12.4964 0.995617 12.0102 0.294265 10.9553 0.190749C10.8666 0.175254 10.7793 0.152695 10.6942 0.123288C10.7011 0.0907214 10.7075 0.057574 10.7145 0.0244255C10.7872 0.0138801 10.8604 0.00708596 10.9338 0.0040708C12.3295 0.0040708 13.7252 0.0040708 15.1209 0.0040708C15.2047 0.0040708 15.2884 0.0505956 15.3728 0.0756024Z"
                    fill="black" />
            </svg>
            <svg width="16" height="12" viewBox="0 0 16 12" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M15.1698 11.6013C15.1034 11.5877 15.0358 11.5803 14.968 11.5793C14.4446 11.5083 13.8997 11.4455 13.5397 11.0221C13.1906 10.6224 12.8891 10.1835 12.6412 9.71421C11.0338 6.56026 9.44287 3.39816 7.86841 0.227927C7.74163 -0.0273744 7.56891 0.0238025 7.37525 0.00286661C7.1816 -0.0180693 7.10599 0.0773053 7.03271 0.235488C6.12956 2.16217 5.22991 4.0906 4.31106 6.01089C3.67135 7.35485 3.03571 8.70522 2.33378 10.0184C1.89471 10.8413 1.25267 11.4862 0.240189 11.6019C0.155863 11.6112 0.0796727 11.6909 0 11.738C0.0843251 11.763 0.168656 11.8101 0.252981 11.8107C1.62971 11.8154 3.00605 11.8154 4.382 11.8107C4.48901 11.8107 4.59543 11.7526 4.70244 11.7182C4.59834 11.674 4.49831 11.606 4.39014 11.5891C3.44802 11.4437 2.70015 10.7779 3.14388 9.64617C3.47187 8.81048 3.86965 8.00096 4.24883 7.1862C4.28081 7.11816 4.41572 7.06175 4.50296 7.06117C5.90876 7.0538 7.31418 7.05497 8.71921 7.06466C8.77531 7.0717 8.82919 7.09098 8.87703 7.12112C8.92486 7.15127 8.96548 7.19155 8.99603 7.23912C9.19667 7.60318 9.38044 7.97769 9.55375 8.35629C9.83231 8.96168 10.1248 9.56243 10.358 10.1859C10.5034 10.5743 10.358 10.9488 10.0091 11.178C9.773 11.3321 9.49327 11.4315 9.22052 11.517C9.02046 11.5793 8.79947 11.5752 8.59069 11.6107C8.53893 11.6205 8.49649 11.6828 8.44996 11.7211C8.49754 11.7576 8.55 11.7871 8.60581 11.809C8.67286 11.8184 8.74078 11.82 8.80819 11.8136H12.9081C13.6543 11.8136 14.4004 11.8136 15.1471 11.809C15.2128 11.809 15.2786 11.7462 15.3443 11.7124C15.2906 11.6687 15.2321 11.6315 15.1698 11.6013ZM4.48203 6.68432L6.54887 2.23196L8.73957 6.68432H4.48203Z"
                    fill="black" />
            </svg>
            <svg width="16" height="12" viewBox="0 0 16 12" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M15.2471 0.10439C15.1789 0.136443 15.1088 0.164407 15.0372 0.188133C14.64 0.298628 14.2166 0.351549 13.8497 0.525433C13.2489 0.809812 13.0762 1.38555 13.05 2.00432C13.0285 2.50736 13.0279 3.01157 13.0274 3.51636C13.0274 6.17095 13.0274 8.82671 13.0274 11.4836V11.782C12.7471 11.8401 12.5476 11.8174 12.34 11.6017C9.1515 8.28528 5.95646 4.97489 2.75482 1.67051C2.7307 1.65368 2.70475 1.63964 2.67747 1.62864C2.66505 1.68947 2.6567 1.75105 2.65247 1.81299C2.65247 4.31328 2.65247 6.81395 2.65247 9.31502C2.65052 9.6057 2.67523 9.89595 2.72631 10.1821C2.88449 11.0207 3.46547 11.4953 4.40759 11.5848C4.5235 11.5912 4.63888 11.605 4.75303 11.6261C4.79141 11.6348 4.81642 11.7005 4.84725 11.7424C4.81338 11.7691 4.77717 11.7926 4.73907 11.8128C4.71065 11.8184 4.68142 11.8184 4.653 11.8128C3.15143 11.8128 1.64967 11.8128 0.147717 11.8128C0.10983 11.8096 0.0722882 11.8031 0.035481 11.7936L0 11.7116C0.0748329 11.6665 0.154657 11.6302 0.23786 11.6034C0.502467 11.5505 0.780446 11.5453 1.03458 11.4604C1.72023 11.24 2.10639 10.7549 2.16919 10.0338C2.20118 9.66744 2.22095 9.29932 2.22211 8.92887C2.22676 6.83528 2.22676 4.74169 2.22211 2.6481C2.2199 2.33826 2.20049 2.02879 2.16395 1.7211C2.06858 0.892974 1.50041 0.367833 0.583881 0.243962C0.459429 0.227097 0.331491 0.226514 0.209365 0.197437C0.141323 0.181153 0.0831677 0.122998 0.02036 0.0811262C0.0837492 0.0549563 0.146558 0.00726973 0.210529 0.00552507C0.539688 -0.00203511 0.869428 0.0020359 1.19917 0.0020359C2.0715 0.0020359 2.94383 -0.00610676 3.81615 0.0101767C3.97249 0.018611 4.12062 0.0827764 4.23371 0.19104C6.95886 3.03948 9.67859 5.89278 12.3929 8.75091C12.4523 8.82537 12.5077 8.90303 12.5586 8.98353C12.5749 8.81488 12.5877 8.74451 12.5877 8.67415C12.5877 6.67787 12.5877 4.68121 12.5877 2.68416C12.5843 2.36489 12.5649 2.04599 12.5295 1.72867C12.4516 0.972647 11.9759 0.453902 11.2228 0.293975C11.0053 0.248032 10.7814 0.232912 10.5633 0.19104C10.4941 0.178246 10.4331 0.124743 10.3679 0.0904312L10.3976 0.0241352H15.2245L15.2471 0.10439Z"
                    fill="black" />
            </svg>
            <svg width="16" height="12" viewBox="0 0 16 12" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M15.1698 11.6013C15.1034 11.5877 15.0358 11.5803 14.968 11.5793C14.4446 11.5083 13.8997 11.4455 13.5397 11.0221C13.1906 10.6224 12.8891 10.1835 12.6412 9.71421C11.0338 6.56026 9.44287 3.39816 7.86841 0.227927C7.74163 -0.0273744 7.56891 0.0238025 7.37525 0.00286661C7.1816 -0.0180693 7.10599 0.0773053 7.03271 0.235488C6.12956 2.16217 5.22991 4.0906 4.31106 6.01089C3.67135 7.35485 3.03571 8.70522 2.33378 10.0184C1.89471 10.8413 1.25267 11.4862 0.240189 11.6019C0.155863 11.6112 0.0796727 11.6909 0 11.738C0.0843251 11.763 0.168656 11.8101 0.252981 11.8107C1.62971 11.8154 3.00605 11.8154 4.382 11.8107C4.48901 11.8107 4.59543 11.7526 4.70244 11.7182C4.59834 11.674 4.49831 11.606 4.39014 11.5891C3.44802 11.4437 2.70015 10.7779 3.14388 9.64617C3.47187 8.81048 3.86965 8.00096 4.24883 7.1862C4.28081 7.11816 4.41572 7.06175 4.50296 7.06117C5.90876 7.0538 7.31418 7.05497 8.71921 7.06466C8.77531 7.0717 8.82919 7.09098 8.87703 7.12112C8.92486 7.15127 8.96548 7.19155 8.99603 7.23912C9.19667 7.60318 9.38044 7.97769 9.55375 8.35629C9.83231 8.96168 10.1248 9.56243 10.358 10.1859C10.5034 10.5743 10.358 10.9488 10.0091 11.178C9.773 11.3321 9.49327 11.4315 9.22052 11.517C9.02046 11.5793 8.79947 11.5752 8.59069 11.6107C8.53893 11.6205 8.49649 11.6828 8.44996 11.7211C8.49754 11.7576 8.55 11.7871 8.60581 11.809C8.67286 11.8184 8.74078 11.82 8.80819 11.8136H12.9081C13.6543 11.8136 14.4004 11.8136 15.1471 11.809C15.2128 11.809 15.2786 11.7462 15.3443 11.7124C15.2906 11.6687 15.2321 11.6315 15.1698 11.6013ZM4.48203 6.68432L6.54887 2.23196L8.73957 6.68432H4.48203Z"
                    fill="black" />
            </svg>
            <svg width="13" height="13" viewBox="0 0 13 13" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M12.7375 8.66026C12.5171 10.3631 11.5901 11.482 9.98618 11.9751C7.62334 12.6986 5.27559 12.5689 3.05929 11.4709C0.926737 10.4136 -0.0514239 8.58408 0.00207889 6.21658C0.0398798 4.54462 0.649351 3.10062 1.8677 1.94159C2.61907 1.22686 3.53792 0.798838 4.51493 0.480729C6.57479 -0.190383 8.62884 -0.137462 10.6829 0.506317C10.9234 0.58036 11.1678 0.641128 11.415 0.688343C11.6878 0.742428 11.9024 0.648215 12.0676 0.414431C12.1321 0.323127 12.2461 0.267881 12.338 0.195768L12.4206 0.253924L12.5462 4.07472L12.4589 4.13288C12.3764 4.05844 12.2635 3.99912 12.2164 3.90666C12.0007 3.48445 11.8308 3.03782 11.5947 2.62724C10.7689 1.19371 9.56629 0.349297 7.86874 0.287071C5.73503 0.209724 4.2509 1.25594 3.29773 3.05643C2.22535 5.0843 2.22535 7.1965 3.22853 9.25636C3.85719 10.5491 4.96854 11.3063 6.35787 11.6442C7.3814 11.8931 8.41366 11.889 9.44359 11.6884C11.0463 11.3755 12.0635 10.4363 12.4496 8.83589C12.5037 8.61665 12.5101 8.61665 12.7375 8.66026Z"
                    fill="black" />
            </svg>
            <svg width="7" height="12" viewBox="0 0 7 12" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M6.75356 11.7229L6.69541 11.7869H5.79633C3.95513 11.7869 2.11355 11.7857 0.271581 11.7834C0.187837 11.7834 0.104104 11.7363 0.02036 11.7107C0.100614 11.6648 0.176212 11.5944 0.262863 11.577C0.451286 11.5363 0.649006 11.5351 0.836266 11.4921C1.68359 11.2955 2.12672 10.7744 2.19011 9.90384C2.21221 9.60434 2.22386 9.30368 2.22444 9.0036C2.22715 6.93909 2.22715 4.87457 2.22444 2.81006C2.22444 2.51929 2.21221 2.22851 2.19476 1.93773C2.13312 0.932811 1.60042 0.360563 0.602481 0.222153C0.458837 0.202381 0.311708 0.199473 0.169809 0.170977C0.108746 0.158764 0.0535028 0.102354 0 0.0657157C0.00988639 0.0441983 0.0191912 0.022099 0.0290776 0H6.72332C6.73321 0.027333 6.74368 0.0540858 6.75356 0.0814188C6.6826 0.120285 6.60825 0.152597 6.53142 0.177955C6.21215 0.250067 5.87717 0.27682 5.57302 0.388478C4.97461 0.608305 4.64252 1.06657 4.58029 1.70162C4.54715 2.02904 4.52214 2.35878 4.52214 2.68736C4.51671 4.82941 4.51671 6.97146 4.52214 9.11351C4.52214 9.36474 4.54598 9.61539 4.56226 9.86662C4.63845 11.0239 5.32585 11.4461 6.34066 11.5584C6.43837 11.5599 6.53572 11.5706 6.63143 11.5903C6.6797 11.6066 6.71285 11.6776 6.75356 11.7229Z"
                    fill="black" />
            </svg>


        </div>
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
        const closeSearch = document.getElementById("close-search");
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
                    searchBtn.classList.add('bg-white');
                    searchIcon.classList.replace('text-black', 'text-black');
                } else {
                    searchBtn.classList.remove('bg-white');
                    searchIcon.classList.replace('text-black', 'text-black');
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
