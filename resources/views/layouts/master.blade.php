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

    {{-- @include('components.footer') --}}

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
            Alpine.store('cart', {
                items: JSON.parse(localStorage.getItem('cart_items') || '[]'),

                get count() {
                    return this.items.reduce((sum, i) => sum + (i.qty || 0), 0);
                },

                get total() {
                    return this.items.reduce((sum, item) => {
                        const price = item.discount && item.discount > 0 ?
                            item.price * (1 - item.discount / 100) :
                            item.price;
                        return sum + price * (item.qty || 0);
                    }, 0).toFixed(2);
                },

                add(item) {
                    // Ensure qty is a number and at least 1
                    const qtyToAdd = Number(item.qty) && Number(item.qty) > 0 ? Number(item.qty) : 1;
                    const existing = this.items.find(i =>
                        i.name === item.name &&
                        i.size === item.size &&
                        i.color === item.color
                    );

                    if (existing) {
                        existing.qty = (existing.qty || 0) + qtyToAdd;
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
                    this.items[index].qty = (this.items[index].qty || 0) + 1;
                    this.save();
                    this.toast(`Increased quantity: ${this.items[index].name}`);
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
                    this.save();
                    this.toast(`Removed: ${removedItem.name}`);
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
                    if (this.items.length === 0) return alert("Cart is empty!");
                    const items = this.items.map(i => {
                        const finalPrice = i.discount && i.discount > 0 ?
                            (i.price * (1 - i.discount / 100)).toFixed(2) :
                            i.price.toFixed(2);

                        const details = [];
                        if (i.size) details.push(`Size: ${i.size}`);
                        if (i.color) details.push(`Color: ${i.color}`);

                        return `${i.name} - $${finalPrice} x ${i.qty}${details.length ? ` (${details.join(", ")})` : ""}`;
                    }).join("\n");

                    const total = this.total;
                    const message = encodeURIComponent(`🛒 My Order:\n${items}\n\nTotal: $${total}`);
                    const telegramLink = `https://t.me/Teng_huy?text=${message}`;
                    window.open(telegramLink, '_blank');
                }
            });
        });
    </script>


</body>

</html>
