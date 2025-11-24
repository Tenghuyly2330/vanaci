<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="author" content="PayWay">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>

    <title>Vanaci</title>
    <link rel="icon" href="{{ asset('assets/images/logo.png') }}">

    <!-- Fonts -->
    {{-- <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" /> --}}
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] {
            display: none !important;
        }

        .prose ul {
            list-style-type: disc;
            padding-left: 1.25rem;
            font-size: 14px;
        }

        .prose ol {
            list-style-type: decimal;
            padding-left: 1.25rem;
            font-size: 14px;
        }

        .prose p {
            font-size: 14px;
        }

        .prose strong {
            font-size: 14px;
        }

        @media (max-width: 639px) {

            .prose strong {
                font-size: 12px;
            }

            .prose p {
                font-size: 12px;
            }

            .prose ul {
                list-style-type: disc;
                padding-left: 1.25rem;
                font-size: 12px;
            }
        }
    </style>
    @yield('css')
</head>

<body class="" style="font-family: 'Inter', sans-serif;">

    @include('components.navbar', ['types' => $types, 'categories' => $categories])

    <div class="relative">
        @yield('content')
    </div>

    @include('components.footer')

    @yield('js')
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        AOS.init({
            offset: 10,
        });
    </script>
    <script>
        document.addEventListener('alpine:init', () => {

            /* ---------------- CART STORE ---------------- */
            Alpine.store('cart', {
                items: JSON.parse(localStorage.getItem('cart_items') || '[]'),

                get count() {
                    return this.items.reduce((sum, i) => sum + (i.qty || 0), 0);
                },

                get total() {
                    return this.items.reduce((sum, item) => {
                        const price = item.discount > 0 ?
                            item.price * (1 - item.discount / 100) :
                            item.price;

                        return sum + price * (item.qty || 0);
                    }, 0).toFixed(2);
                },

                add(item) {
                    const qtyToAdd = item.qty > 0 ? Number(item.qty) : 1;

                    const existing = this.items.find(i =>
                        i.slug === item.slug &&
                        i.color === item.color &&
                        i.size === item.size
                    );

                    if (existing) {
                        existing.qty += qtyToAdd;
                        this.toast(`Increased quantity: ${item.name}`);
                    } else {
                        this.items.push({
                            ...item,
                            qty: qtyToAdd
                        });
                        this.toast(`${item.name} added to cart`);
                    }

                    this.save();
                },

                increase(index) {
                    this.items[index].qty++;
                    this.toast(`Increased quantity: ${this.items[index].name}`);
                    this.save();
                },

                decrease(index) {
                    if (this.items[index].qty > 1) {
                        this.items[index].qty--;
                        this.toast(`Decreased quantity: ${this.items[index].name}`);
                    } else {
                        const removedItem = this.items[index];
                        this.items.splice(index, 1);
                        this.toast(`Removed: ${removedItem.name}`);
                    }
                    this.save();
                },

                remove(index) {
                    const removedItem = this.items[index];
                    this.items.splice(index, 1);
                    this.toast(`Removed: ${removedItem.name}`);
                    this.save();
                },

                save() {
                    localStorage.setItem('cart_items', JSON.stringify(this.items));
                },

                toast(message) {
                    const t = document.createElement('div');
                    t.textContent = message;
                    t.className =
                        'fixed bottom-4 right-4 bg-black text-white px-4 py-2 rounded shadow-lg text-sm animate-fadeIn z-[999]';
                    document.body.appendChild(t);

                    setTimeout(() => {
                        t.classList.add('opacity-0', 'transition', 'duration-500');
                        setTimeout(() => t.remove(), 500);
                    }, 1500);
                },


                checkout() {
                    if (this.items.length === 0) {
                        this.toast("❌ Cart is empty!");
                        return;
                    }

                    // Check stock
                    const invalidItems = this.items.filter(i => i.qty > i.stock);
                    if (invalidItems.length > 0) {
                        let msg = "❗ Some items exceed stock:\n";
                        invalidItems.forEach(i => {
                            msg += `${i.name} → Qty: ${i.qty}, Stock: ${i.stock}\n`;
                        });
                        this.toast(msg);
                        return;
                    }

                    // All good → open policy first
                    window.dispatchEvent(new CustomEvent('open-policy'));
                },

                // After user accepts policy, perform the real checkout
                confirmCheckout() {
                    // Build message
                    const itemsText = this.items.map(i => {
                        const price = i.discount > 0 ?
                            (i.price * (1 - i.discount / 100)).toFixed(2) :
                            i.price.toFixed(2);

                        const itemUrl = i.url ? i.url.trim() : '';

                        return `📌 ${i.name} $${price} x ${i.qty} (Color: ${i.color}, Size: ${i.size})\n${itemUrl}`;
                    }).join("\n\n");

                    const message = encodeURIComponent(
                        `🛒 My Order:\n${itemsText}\n\nTotal: $${this.total}`
                    );

                    this.toast("✅ Redirecting to Telegram...");

                    setTimeout(() => {
                        window.open(`https://t.me/+855967777516?text=${message}`, "_blank");
                    }, 1000);
                }

            });


            /* ---------------- FAVORITE STORE ---------------- */
            Alpine.store('favorite', {
                items: JSON.parse(localStorage.getItem('favorite_items') || '[]'),

                get count() {
                    return this.items.length;
                },

                add(item) {
                    const exists = this.items.find(i =>
                        i.slug === item.slug &&
                        i.color === item.color
                    );

                    if (exists) {
                        return this.toast(`${item.name} already in favorites`);
                    }

                    this.items.push(item);
                    this.save();
                    this.toast(`${item.name} added to favorites`);
                },

                remove(index) {
                    const removed = this.items[index];
                    this.items.splice(index, 1);
                    this.save();
                    this.toast(`Removed: ${removed.name} from favorite`);
                },

                save() {
                    localStorage.setItem('favorite_items', JSON.stringify(this.items));
                },

                toast(message) {
                    const t = document.createElement('div');
                    t.textContent = message;
                    t.className =
                        'fixed bottom-4 right-4 bg-black text-white px-4 py-2 rounded shadow-lg text-sm animate-fadeIn z-[999]';
                    document.body.appendChild(t);

                    setTimeout(() => {
                        t.classList.add('opacity-0', 'transition', 'duration-500');
                        setTimeout(() => t.remove(), 500);
                    }, 1500);
                }
            });

        });
    </script>

    <script>
        var swiper = new Swiper(".mySwiper", {
            slidesPerView: 3.5,

            breakpoints: {
                // Mobile
                0: {
                    slidesPerView: 1.2,
                },
                // Small screens (tablet)
                640: {
                    slidesPerView: 2.2,
                },
                // Medium screens
                768: {
                    slidesPerView: 3,
                },
                // Large screens
                1024: {
                    slidesPerView: 3.5,
                }
            }, // ← FIXED: add comma here

            spaceBetween: 30,

            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },

            // autoplay: {
            //     delay: 2500,
            //     disableOnInteraction: false,
            // },
        });
    </script>
</body>

</html>
