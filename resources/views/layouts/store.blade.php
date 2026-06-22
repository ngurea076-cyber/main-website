@php
    $navCategories = ($categories ?? collect())->take(6);
    if ($navCategories->isEmpty()) {
        $navCategories = \App\Models\Category::orderBy('priority')->orderBy('name')->take(6)->get();
    }
    $whatsAppNumber = preg_replace('/\D+/', '', config('services.whatsapp.number', '254713869018')) ?: '254713869018';
@endphp
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="theme-color" content="#E30613">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://res.cloudinary.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap">
    <link rel="manifest" href="/manifest.webmanifest">
    <link rel="icon" href="/app-icon.jpg" type="image/jpeg">
    <title>@yield('title','Shop ICT Gadgets — Premium Electronics in Kenya')</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-background text-foreground">
    <header class="sticky top-0 z-40 border-b border-[#eeeeee] bg-white">
        <div class="hidden lg:block">
            <div class="border-b border-[#eeeeee] bg-[#f8f8f8]">
                <div class="site-desktop-width mx-auto flex h-9 items-center justify-between px-6 text-[13px] text-[#4b5563]">
                    <p>Nairobi, Laxmi Plaza, 3rd Flr, Room No 5</p>
                    <div class="flex items-center gap-5">
                        <a href="tel:+254713869018" class="inline-flex items-center gap-2 hover:text-[#E30613]"><i data-lucide="phone" class="h-3.5 w-3.5"></i> +254713869018</a>
                        <a href="mailto:ictgadgetsshop@gmail.com" class="inline-flex items-center gap-2 hover:text-[#E30613]"><i data-lucide="mail" class="h-3.5 w-3.5"></i> ictgadgetsshop@gmail.com</a>
                    </div>
                </div>
            </div>

            <div class="site-desktop-width mx-auto flex h-[84px] items-center gap-8 px-6">
                <a href="{{ route('home') }}" class="shrink-0">
                    <img src="/logo.png" width="512" height="454" alt="Shop ICT Kenya" class="h-14 w-auto object-contain">
                </a>

                <form action="{{ route('shop') }}" class="mx-auto w-full max-w-2xl">
                    <div class="flex h-12 items-center rounded-full border border-[#eeeeee] bg-white pl-5 pr-2 shadow-[0_1px_10px_rgba(15,23,42,0.04)]">
                        <input name="q" value="{{ request('q') }}" placeholder="Search laptops, phones, printers and accessories" class="h-full min-w-0 flex-1 bg-transparent text-[14px] text-[#111827] outline-none placeholder:text-[#9ca3af]">
                        <button class="grid h-9 w-9 place-items-center rounded-full bg-[#E30613] text-white" aria-label="Search">
                            <i data-lucide="search" class="h-4 w-4"></i>
                        </button>
                    </div>
                </form>

                <div class="flex items-center gap-2">
                    <a href="{{ route('shop') }}" class="inline-flex h-10 items-center gap-2 rounded-full border border-[#eeeeee] px-4 text-sm font-medium text-[#111827] hover:border-[#E30613] hover:text-[#E30613]">
                        <i data-lucide="grid-3-x-3" class="h-4 w-4"></i>
                        Shop
                    </a>
                    <a href="https://wa.me/{{ $whatsAppNumber }}" class="inline-flex h-10 items-center rounded-full bg-[#e92d48] px-5 text-sm font-semibold text-white hover:bg-[#d61f3d]">
                        WhatsApp
                    </a>
                </div>
            </div>

            <nav class="border-t border-[#eeeeee] bg-white">
                <div class="site-desktop-width mx-auto flex h-12 items-center gap-7 px-6 text-[14px] font-medium text-[#4b5563]">
                    <a href="{{ route('home') }}" class="hover:text-[#E30613]">Home</a>
                    <a href="{{ route('shop') }}" class="hover:text-[#E30613]">All Products</a>
                    @foreach($navCategories as $category)
                        <a href="{{ route('shop', ['category' => $category->slug]) }}" class="hover:text-[#E30613]">{{ $category->name }}</a>
                    @endforeach
                    <a href="https://maps.app.goo.gl/7A3d34gMimEMCx6u6" target="_blank" rel="noreferrer" class="ml-auto inline-flex items-center gap-2 hover:text-[#E30613]">
                        <i data-lucide="map-pin" class="h-4 w-4"></i>
                        Find Us
                    </a>
                </div>
            </nav>
        </div>

        <div class="lg:hidden">
            <div class="flex h-[28px] items-center overflow-hidden border-b border-[#eeeeee] bg-[#f8f8f8]">
                <div class="mobile-location-marquee whitespace-nowrap px-4 text-[11px] font-medium text-[#4b5563]">
                    Nairobi, Laxmi Plaza, 3rd Flr, Room No 5 | +254713869018
                </div>
            </div>
            <div class="mx-auto grid h-[84px] w-full grid-cols-[auto_minmax(0,1fr)_auto] items-center gap-3 px-4 sm:px-6">
                <a href="{{ route('home') }}" class="justify-self-start text-[#111827]">
                    <img src="/logo.png" width="512" height="454" alt="Shop ICT Kenya" class="h-11 w-auto object-contain">
                </a>

                <form action="{{ route('shop') }}" class="mx-auto min-w-0 w-full max-w-[190px] sm:max-w-[240px]">
                    <div class="flex h-10 items-center rounded-full border border-[#eeeeee] bg-white pl-3 pr-2">
                        <input name="q" value="{{ request('q') }}" placeholder="Search gadgets" class="h-full min-w-0 flex-1 bg-transparent text-[13px] text-[#111827] outline-none placeholder:text-[#9ca3af]">
                        <button class="grid h-8 w-8 shrink-0 place-items-center rounded-full text-[#ef2b10]" aria-label="Search">
                            <i data-lucide="search" class="h-4 w-4"></i>
                        </button>
                    </div>
                </form>

                <button data-toggle-menu class="inline-flex h-10 w-10 items-center justify-center rounded-full transition-colors hover:bg-[#f5f5f5]" aria-label="Menu">
                    <i data-lucide="menu" class="h-5 w-5"></i>
                </button>
            </div>
        </div>

        <div data-mobile-menu class="fixed inset-0 z-[80] hidden bg-black/30 backdrop-blur-[2px] lg:hidden">
            <div class="absolute right-0 top-0 h-full w-[86vw] max-w-sm overflow-y-auto bg-white px-6 pb-8 pt-6 shadow-[0_24px_60px_-24px_rgba(17,24,39,0.35)]">
                <div class="mb-8 flex items-center justify-between">
                    <a href="{{ route('home') }}"><img src="/logo.png" width="512" height="454" alt="Shop ICT Kenya" class="h-12 w-auto object-contain"></a>
                    <button data-close-menu class="inline-flex h-10 w-10 items-center justify-center rounded-full hover:bg-[#f5f5f5]" aria-label="Close menu">
                        <i data-lucide="x" class="h-5 w-5 text-[#111827]"></i>
                    </button>
                </div>

                <div class="overflow-hidden rounded-[3px] border border-[#dddddd] bg-white">
                    <div class="border-b border-[#dddddd] bg-[#f7f7f7] px-4 py-3">
                        <h2 class="text-sm font-bold text-[#222222]">Categories</h2>
                    </div>
                    <nav>
                        <a href="{{ route('shop') }}" class="flex h-[38px] items-center border-b border-[#dddddd] px-3 text-sm font-medium text-[#4b5563] hover:bg-[#fafafa] hover:text-[#ef2b10]">All Categories</a>
                        @foreach($navCategories as $category)
                            <a href="{{ route('shop', ['category' => $category->slug]) }}" class="flex h-[38px] items-center border-b border-[#dddddd] px-3 text-sm font-medium text-[#4b5563] hover:bg-[#fafafa] hover:text-[#ef2b10]">{{ $category->name }}</a>
                        @endforeach
                    </nav>
                </div>

                <nav class="mt-4 border-t border-[#eeeeee] pt-3">
                    <a href="https://wa.me/{{ $whatsAppNumber }}" class="block rounded-[4px] px-3 py-3 text-[15px] font-medium text-[#111827] hover:bg-[#f5f5f5]">WhatsApp Us</a>
                    <a href="{{ route('login') }}" class="block rounded-[4px] px-3 py-3 text-[15px] font-medium text-[#111827] hover:bg-[#f5f5f5]">Attendant</a>
                </nav>
            </div>
        </div>
    </header>

    <main class="min-h-screen pb-24 lg:pb-0">@yield('content')</main>

    <section class="border-t bg-background">
        <div class="site-desktop-width mx-auto px-6 py-10">
            <div class="mb-4 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <h3 class="text-2xl font-bold tracking-tight">Find Us</h3>
                    <p class="mt-1 text-sm text-muted-foreground">Visit our location or open directions in Google Maps.</p>
                </div>
                <a href="https://maps.app.goo.gl/7A3d34gMimEMCx6u6" target="_blank" rel="noreferrer" class="inline-flex items-center justify-center gap-2 rounded-full bg-primary px-5 py-2.5 text-center text-sm font-medium text-primary-foreground transition-colors hover:bg-primary/90">
                    Get Direction
                </a>
            </div>
            <a href="https://maps.app.goo.gl/7A3d34gMimEMCx6u6" target="_blank" rel="noreferrer" class="block overflow-hidden rounded-3xl border shadow-soft">
                <iframe title="Shop ICT Gadgets location" src="https://www.google.com/maps?q=Laxmi%20Plaza%20Nairobi&z=16&output=embed" class="h-[360px] w-full" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </a>
        </div>
    </section>

    <footer class="border-t bg-surface">
        <div class="site-desktop-width mx-auto grid gap-10 px-6 py-14 md:grid-cols-4">
            <div>
                <p class="text-sm text-muted-foreground">Dealers in IT products, Electronics, Accessories, Phones, Homewear, Servers, Networking Accessories, etc.</p>
                <div class="mt-4 flex gap-2">
                    <a href="https://www.facebook.com/Shopictgadgets" target="_blank" rel="noreferrer" class="grid h-9 w-9 place-items-center rounded-full border text-xs font-bold hover:bg-background">f</a>
                    <a href="https://www.instagram.com/jamesndiba_/" target="_blank" rel="noreferrer" class="grid h-9 w-9 place-items-center rounded-full border text-xs font-bold hover:bg-background">ig</a>
                    <a href="https://www.tiktok.com/@shop.ict.gadgets" target="_blank" rel="noreferrer" class="grid h-9 w-9 place-items-center rounded-full border text-xs font-bold hover:bg-background">tk</a>
                </div>
            </div>
            <div>
                <h4 class="mb-3 text-sm font-semibold">Shop</h4>
                <ul class="space-y-2 text-sm text-muted-foreground">
                    <li><a href="{{ route('shop') }}">All Products</a></li>
                    @foreach($navCategories as $category)
                        <li><a href="{{ route('shop', ['category' => $category->slug]) }}">{{ $category->name }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div>
                <h4 class="mb-3 text-sm font-semibold">Reach Us</h4>
                <ul class="space-y-2 text-sm text-muted-foreground">
                    <li class="flex items-center gap-2"><i data-lucide="phone" class="h-3.5 w-3.5"></i> +254713869018</li>
                    <li class="flex items-center gap-2"><i data-lucide="mail" class="h-3.5 w-3.5"></i> ictgadgetsshop@gmail.com</li>
                    <li class="flex items-center gap-2"><i data-lucide="map-pin" class="h-3.5 w-3.5"></i> Nairobi, Kenya</li>
                </ul>
            </div>
            <div>
                <h4 class="mb-3 text-sm font-semibold">Trusted Distributor For</h4>
                <div class="grid grid-cols-3 gap-x-3 gap-y-3">
                    @foreach(['hp','Lenovo','DELL','SAMSUNG','EPSON','Canon','acer','Apple','Logitech'] as $brand)
                        <div class="flex h-7 items-center text-xs font-bold text-[#9CA3AF]">{{ $brand }}</div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="border-t py-5 text-center text-xs text-muted-foreground">© {{ date('Y') }} Shop ICT Gadgets. All rights reserved.</div>
    </footer>

    <a href="https://wa.me/{{ $whatsAppNumber }}" class="fixed bottom-24 right-5 z-40 hidden h-14 w-14 place-items-center rounded-full bg-[#25D366] text-white shadow-[0_16px_35px_rgba(37,211,102,0.35)] lg:grid" aria-label="WhatsApp">
        <i data-lucide="message-circle" class="h-7 w-7"></i>
    </a>

    <nav class="fixed inset-x-0 bottom-0 z-40 border-t border-[#eeeeee] bg-white px-3 py-2 shadow-[0_-8px_24px_rgba(15,23,42,0.08)] lg:hidden">
        <div class="grid grid-cols-4 text-[11px] font-medium text-[#4b5563]">
            <a href="{{ route('home') }}" class="flex flex-col items-center gap-1 rounded-xl py-1.5"><i data-lucide="home" class="h-5 w-5"></i>Home</a>
            <a href="{{ route('shop') }}" class="flex flex-col items-center gap-1 rounded-xl py-1.5"><i data-lucide="grid-3-x-3" class="h-5 w-5"></i>Shop</a>
            <a href="https://wa.me/{{ $whatsAppNumber }}" class="flex flex-col items-center gap-1 rounded-xl py-1.5 text-[#25D366]"><i data-lucide="message-circle" class="h-5 w-5"></i>WhatsApp</a>
            <a href="{{ route('login') }}" class="flex flex-col items-center gap-1 rounded-xl py-1.5"><i data-lucide="store" class="h-5 w-5"></i>Attendant</a>
        </div>
    </nav>

    @livewireScripts
</body>
</html>
