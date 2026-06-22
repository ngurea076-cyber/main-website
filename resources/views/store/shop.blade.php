@extends('layouts.store')

@section('title','Shop Products')

@section('content')
@php
    $activeCategory = request('category');
    $pageTitle = request('q')
        ? 'Search results for "'.request('q').'"'
        : (($categories ?? collect())->firstWhere('slug', $activeCategory)?->name ?? 'All Categories');
@endphp

<section class="bg-white">
    <div class="site-desktop-width mx-auto px-1 py-8 md:px-6">
        <div class="mb-5 flex items-center justify-between gap-4 lg:hidden">
            <h1 class="text-[34px] font-normal leading-none text-[#222222]">{{ $pageTitle }}</h1>
            <button data-toggle-menu type="button" class="inline-flex items-center gap-2 rounded-[3px] border border-[#dddddd] px-4 py-2 text-sm text-[#222222]">
                <i data-lucide="sliders-horizontal" class="h-4 w-4"></i>
                Filters
            </button>
        </div>

        <div class="grid gap-[30px] lg:grid-cols-[250px_minmax(0,1fr)]">
            <aside class="hidden h-fit border border-[#dddddd] bg-white lg:block">
                <div class="flex items-center justify-between border-b border-[#dddddd] bg-[#f7f7f7] px-4 py-3">
                    <h2 class="text-sm font-bold text-[#222222]">Categories</h2>
                </div>
                <div>
                    <a href="{{ route('shop') }}" class="{{ !$activeCategory ? 'bg-[#e92d48] text-white' : 'text-[#4b5563] hover:bg-[#fafafa]' }} flex h-[38px] w-full items-center border-b border-[#dddddd] px-3 text-left text-sm transition-colors">
                        All Categories
                    </a>
                    @foreach($categories as $category)
                        <a href="{{ route('shop', ['category' => $category->slug]) }}" class="{{ $activeCategory === $category->slug ? 'bg-[#e92d48] text-white' : 'text-[#4b5563] hover:bg-[#fafafa]' }} flex h-[38px] w-full items-center border-b border-[#dddddd] px-3 text-left text-sm transition-colors">
                            <span class="truncate pr-2">{{ $category->name }}</span>
                        </a>
                    @endforeach
                </div>
            </aside>

            <main>
                <h1 class="hidden text-[34px] font-normal leading-none text-[#222222] lg:block">{{ $pageTitle }}</h1>

                <div class="mt-3 hidden border-b border-[#dddddd] pb-4 md:flex md:flex-row md:items-center md:justify-between">
                    <p class="text-[13px] text-[#222222]">
                        Showing {{ $products->firstItem() ?? 0 }} to {{ $products->lastItem() ?? 0 }} of {{ $products->total() }} results.
                    </p>

                    <form action="{{ route('shop') }}" class="flex h-10 min-w-[280px] items-center rounded-[3px] border border-[#dddddd] bg-white pl-3">
                        @if($activeCategory)
                            <input type="hidden" name="category" value="{{ $activeCategory }}">
                        @endif
                        <input name="q" value="{{ request('q') }}" placeholder="Search products" class="h-full min-w-0 flex-1 bg-transparent text-[13px] outline-none">
                        <button class="grid h-10 w-10 place-items-center text-[#E30613]">
                            <i data-lucide="search" class="h-4 w-4"></i>
                        </button>
                    </form>
                </div>

                <div class="mt-8 grid grid-cols-2 gap-1 md:grid-cols-4 md:gap-3 2xl:grid-cols-6 2xl:gap-3">
                    @forelse($products as $product)
                        <x-product-card :product="$product" />
                    @empty
                        <div class="col-span-full rounded-[8px] border border-[#eeeeee] bg-[#fafafa] px-4 py-8 text-center">
                            <p class="text-sm font-medium text-[#222222]">Product not found.</p>
                            <p class="mt-1 text-sm text-[#6b7280]">Try clearing the filter or searching another keyword.</p>
                            <a href="{{ route('shop') }}" class="mt-4 inline-flex h-9 items-center justify-center rounded-[3px] border border-[#e92d48] bg-white px-4 text-sm font-medium text-[#e92d48]">
                                Clear filter
                            </a>
                        </div>
                    @endforelse
                </div>

                <div class="mt-10">
                    {{ $products->links() }}
                </div>
            </main>
        </div>
    </div>
</section>
@endsection
