@extends('layouts.store')

@section('title','Shop ICT Gadgets Kenya')

@section('content')
@php
    $heroProduct = $featured->first();
    $categorySections = ($categories ?? collect())->take(5);
    $heroImage = $heroProduct ? \App\Support\ImageCdn::responsive($heroProduct->primary_image, [
        'width' => 760,
        'height' => 520,
        'mode' => 'fit',
        'widths' => [320, 480, 640, 760],
        'sizes' => '(max-width: 767px) 42vw, (max-width: 1279px) 36vw, 320px',
        'quality' => 'q_auto:eco',
    ]) : null;
@endphp

<section class="bg-white">
    <div class="site-desktop-width mx-auto px-3 py-5 md:px-6 md:py-8">
        <div class="grid gap-4 lg:grid-cols-[250px_minmax(0,1fr)]">
            <aside class="hidden overflow-hidden rounded-[3px] border border-[#dddddd] bg-white lg:block">
                <div class="border-b border-[#dddddd] bg-[#f7f7f7] px-4 py-3">
                    <h2 class="text-sm font-bold text-[#222222]">Categories</h2>
                </div>
                <nav>
                    <a href="{{ route('shop') }}" class="flex h-[38px] items-center border-b border-[#dddddd] px-3 text-sm font-medium text-[#4b5563] hover:bg-[#fafafa] hover:text-[#ef2b10]">All Categories</a>
                    @foreach($categories as $category)
                        <a href="{{ route('shop', ['category' => $category->slug]) }}" class="flex h-[38px] items-center border-b border-[#dddddd] px-3 text-sm font-medium text-[#4b5563] hover:bg-[#fafafa] hover:text-[#ef2b10]">{{ $category->name }}</a>
                    @endforeach
                </nav>
            </aside>

            <div class="grid gap-4 xl:grid-cols-[minmax(0,1fr)_34%]">
                <a href="{{ route('shop') }}" class="relative overflow-hidden rounded-[18px] bg-[#f3f5f9] px-5 py-7 shadow-soft sm:px-8 lg:min-h-[360px]">
                    <div class="relative z-10 max-w-xl">
                        <p class="text-xs font-bold uppercase tracking-[0.18em] text-[#E30613]">Premium Electronics in Kenya</p>
                        <h1 class="mt-3 text-[34px] font-extrabold leading-[0.98] text-[#111827] sm:text-5xl lg:text-6xl">
                            Smart deals on premium gadgets
                        </h1>
                        <p class="mt-4 max-w-md text-sm leading-6 text-[#4b5563] sm:text-base">
                            Shop laptops, phones, monitors, printers, networking gear, CCTV and accessories from Shop ICT Gadgets.
                        </p>
                        <span class="mt-6 inline-flex items-center gap-2 rounded-full bg-[#e92d48] px-5 py-2.5 text-sm font-semibold text-white">
                            Shop now <i data-lucide="arrow-up-right" class="h-4 w-4"></i>
                        </span>
                    </div>

                    @if($heroProduct && $heroImage)
                        <img
                            src="{{ $heroImage['src'] }}"
                            @if($heroImage['srcset']) srcset="{{ $heroImage['srcset'] }}" @endif
                            @if($heroImage['sizes']) sizes="{{ $heroImage['sizes'] }}" @endif
                            width="{{ $heroImage['width'] ?? 760 }}"
                            height="{{ $heroImage['height'] ?? 520 }}"
                            alt="{{ $heroProduct->title }}"
                            fetchpriority="high"
                            decoding="async"
                            class="absolute bottom-0 right-0 hidden h-[78%] w-[46%] object-contain drop-shadow-[0_18px_24px_rgba(37,99,235,0.18)] md:block"
                        >
                    @endif
                </a>

                <div class="grid gap-4">
                    <a href="{{ route('shop', ['category' => 'laptops']) }}" class="relative min-h-[170px] overflow-hidden rounded-[18px] bg-[#111827] p-5 text-white shadow-soft">
                        <p class="text-xs font-bold uppercase tracking-[0.16em] text-white/70">Performance Picks</p>
                        <h2 class="mt-2 text-2xl font-bold">Fresh laptop picks</h2>
                        <p class="mt-2 text-sm text-white/70">Work, school and gaming machines.</p>
                    </a>
                    <a href="{{ route('shop', ['category' => 'smartphones']) }}" class="relative min-h-[170px] overflow-hidden rounded-[18px] bg-[#fff2f3] p-5 text-[#111827] shadow-soft">
                        <p class="text-xs font-bold uppercase tracking-[0.16em] text-[#E30613]">Pocket Tech</p>
                        <h2 class="mt-2 text-2xl font-bold">Top phone offers</h2>
                        <p class="mt-2 text-sm text-[#4b5563]">Smartphones and mobile essentials.</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="bg-white">
    <div class="site-desktop-width mx-auto px-3 py-6 md:px-6">
        <div class="mb-4 flex items-center justify-between gap-4">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.16em] text-[#E30613]">Popular now</p>
                <h2 class="text-2xl font-bold tracking-tight text-[#111827]">Best Deals</h2>
            </div>
            <a href="{{ route('shop') }}" class="inline-flex items-center gap-2 rounded-full border border-[#dddddd] px-4 py-2 text-sm font-medium text-[#111827] hover:border-[#E30613] hover:text-[#E30613]">
                View all <i data-lucide="arrow-up-right" class="h-4 w-4"></i>
            </a>
        </div>

        <div class="grid grid-cols-2 gap-1 md:grid-cols-4 md:gap-3 2xl:grid-cols-6">
            @forelse($featured as $product)
                <x-product-card :product="$product" />
            @empty
                <p class="col-span-full rounded-[8px] border border-[#eeeeee] bg-[#fafafa] px-4 py-8 text-center text-sm text-[#6b7280]">
                    Products will appear after the catalogue import.
                </p>
            @endforelse
        </div>
    </div>
</section>

@foreach($categorySections as $category)
    @php
        $sectionProducts = \App\Models\Product::with('category')->where('category_id', $category->id)->latest()->take(12)->get();
    @endphp
    @if($sectionProducts->isNotEmpty())
        <section class="bg-white">
            <div class="site-desktop-width mx-auto px-3 py-6 md:px-6">
                <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.16em] text-[#E30613]">Shop by category</p>
                        <h2 class="text-2xl font-bold tracking-tight text-[#111827]">{{ $category->name }}</h2>
                    </div>
                    <a href="{{ route('shop', ['category' => $category->slug]) }}" class="inline-flex items-center gap-2 rounded-full border border-[#dddddd] px-4 py-2 text-sm font-medium text-[#111827] hover:border-[#E30613] hover:text-[#E30613]">
                        View more <i data-lucide="arrow-up-right" class="h-4 w-4"></i>
                    </a>
                </div>
                <div class="grid grid-cols-2 gap-1 md:grid-cols-4 md:gap-3 2xl:grid-cols-6">
                    @foreach($sectionProducts as $product)
                        <x-product-card :product="$product" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endforeach
@endsection
