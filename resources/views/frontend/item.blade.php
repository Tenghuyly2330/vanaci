@extends('layouts.master')

@section('content')
    <style>
        /* Hide scrollbar but keep scrolling */
        .scrollbar-hide {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;     /* Firefox */
        }
        .scrollbar-hide::-webkit-scrollbar {
            display: none; /* Chrome, Safari, Opera */
        }
    </style>
    <section class="relative h-screen md:h-[120vh] flex items-center justify-center text-center overflow-x-hidden">

        {{-- <div class="w-full h-full absolute inset-0">
            <img src="{{ asset('assets/images/banner-2.png') }}" alt="" class="w-full h-full object-cover">
        </div>
        @if ($typeName == 'Men')
            <div class="w-full h-full absolute inset-0">
                <img src="{{ asset('assets/images/banner-2.png') }}" alt="" class="w-full h-full object-cover">
            </div>
        @elseif ($typeName == 'Women')
            <div class="w-full h-full absolute inset-0">
                <img src="{{ asset('assets/images/banner-1.jpg') }}" alt="" class="w-full h-full object-cover">
            </div>
        @elseif ($typeName == 'Skin care')
            <div class="w-full h-full absolute inset-0">
                <img src="{{ asset('assets/images/banner-1.jpg') }}" alt="" class="w-full h-full object-cover">
            </div>
        @else
            <div class="w-full h-full absolute inset-0">
                <img src="{{ asset('assets/images/banner-2.png') }}" alt="" class="w-full h-full object-cover">
            </div>
        @endif --}}
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

    {{-- Content Container for AJAX updates --}}
    <section>
        {{-- @if ($subcategories->count())
            <div class="flex whitespace-nowrap space-x-2 mt-10 px-4 w-full overflow-x-auto scrollbar-hide">
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
        @endif --}}
        <div id="content-container">
            @include('frontend.partials.item_grid')
        </div>
    </section>
   <script>
    document.addEventListener('DOMContentLoaded', () => {
        // Function to scroll to the subcategory bar
        const scrollToBar = () => {
            const bar = document.querySelector('.subcategory-bar');
            if (bar) {
                // Call scrollIntoView only on initial page load
                bar.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        };
        
        // **1. Initial scroll for the first load (Keep this)**
        scrollToBar();

        // Function to handle AJAX link clicks
        const handleAjaxLink = (event) => {
            const link = event.currentTarget;
            const url = link.getAttribute('href');

            // Check if it's a subcategory link (or 'View All' link)
            if (link.closest('.subcategory-bar')) {
                event.preventDefault(); // Stop the default link behavior (full page refresh)
                
                // Add a loading state if desired (e.g., dim the items)
                const contentContainer = document.getElementById('content-container');
                contentContainer.style.opacity = 0.5;
                
                fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest' // Laravel recognizes this as an AJAX request
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // 1. Update the content container with the new HTML
                    contentContainer.innerHTML = data.items_html;
                    
                    // 2. Update the URL without reloading the page
                    window.history.pushState({}, '', url);
                    
                    // 3. Update the banner title (optional)
                    const bannerTitle = document.getElementById('banner-title');
                    if (bannerTitle && data.categoryName) {
                        bannerTitle.textContent = data.categoryName;
                    }
                    
                    // 4. Remove loading state
                    contentContainer.style.opacity = 1;

                    // 5. REMOVE SCROLL HERE (Previously: scrollToBar();)
                    // If you want NO scroll after click, remove the call here.

                    // 6. Re-bind the event listeners for the new links
                    bindAjaxLinks();
                })
                .catch(error => {
                    console.error('Error fetching items:', error);
                    contentContainer.style.opacity = 1; // Remove loading state on error
                });
            }
        };
        
        // Function to bind event listeners to the links
        const bindAjaxLinks = () => {
            // Select all links within the subcategory-bar class
            const subcategoryLinks = document.querySelectorAll('.subcategory-bar a');
            
            subcategoryLinks.forEach(link => {
                // Remove existing listener to prevent duplicates (important after AJAX refresh)
                link.removeEventListener('click', handleAjaxLink); 
                // Add the new AJAX handler
                link.addEventListener('click', handleAjaxLink);
            });
        };

        // Initial binding of event listeners
        bindAjaxLinks();
    });
</script>

@endsection
