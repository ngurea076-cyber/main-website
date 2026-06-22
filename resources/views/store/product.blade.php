@extends('layouts.store')

@section('title',$product->title)

@section('content')
@php
    $whatsAppNumber = preg_replace('/\D+/', '', config('services.whatsapp.number', '254713869018')) ?: '254713869018';
    $price = (float) $product->price;
    $oldPrice = $product->old_price && (float) $product->old_price > $price ? (float) $product->old_price : null;
    $images = collect($product->images ?? [])->filter()->values();
    $specs = collect($product->specs ?? [])->filter();
    $buyText = 'Hello, I am interested in '.$product->title.' - KES '.number_format($price);
@endphp

<section class="bg-white">
    <div class="site-desktop-width mx-auto px-4 py-8 md:px-6">
        <div class="mb-6 flex flex-wrap items-center gap-2 text-xs text-[#6b7280]">
            <a href="{{ route('home') }}" class="hover:text-[#E30613]">Home</a>
            <span>/</span>
            <a href="{{ route('shop') }}" class="hover:text-[#E30613]">Shop</a>
            @if($product->category)
                <span>/</span>
                <a href="{{ route('shop', ['category' => $product->category->slug]) }}" class="hover:text-[#E30613]">{{ $product->category->name }}</a>
            @endif
        </div>

        <div class="grid gap-8 lg:grid-cols-[minmax(0,1fr)_440px]">
            <div class="rounded-[18px] border border-[#eeeeee] bg-white p-4 shadow-soft">
                <div class="grid gap-3 md:grid-cols-[96px_minmax(0,1fr)]">
                    <div class="hidden flex-col gap-3 md:flex">
                        @foreach($images->take(5) as $image)
                            <div class="aspect-square overflow-hidden rounded-[12px] border border-[#eeeeee] bg-white p-2">
                                <img src="{{ $image }}" alt="{{ $product->title }}" class="h-full w-full object-contain">
                            </div>
                        @endforeach
                    </div>
                    <div class="flex min-h-[360px] items-center justify-center rounded-[14px] bg-white p-4">
                        <img src="{{ $product->primary_image }}" alt="{{ $product->title }}" class="max-h-[520px] w-full object-contain">
                    </div>
                </div>
            </div>

            <div class="lg:pt-4">
                @if($product->brand)
                    <p class="text-xs font-bold uppercase tracking-[0.16em] text-[#E30613]">{{ $product->brand }}</p>
                @endif
                <h1 class="mt-2 text-[32px] font-bold leading-tight text-[#111827] md:text-[42px]">{{ $product->title }}</h1>

                <div class="mt-5 flex flex-wrap items-end gap-3">
                    <p class="text-3xl font-extrabold text-[#E30613]">KES {{ number_format($price) }}</p>
                    @if($oldPrice)
                        <p class="pb-1 text-sm text-[#9CA3AF] line-through">KES {{ number_format($oldPrice) }}</p>
                    @endif
                </div>

                <p class="mt-4 inline-flex rounded-full bg-[#f2f4f7] px-3 py-1 text-xs font-semibold text-[#4b5563]">
                    {{ str_replace('_', ' ', ucfirst($product->stock_status ?? 'In stock')) }}
                </p>

                @if($product->description)
                    <p class="mt-6 leading-7 text-[#4b5563]">{{ $product->description }}</p>
                @endif

                <div class="mt-8 grid gap-3 sm:grid-cols-2">
                    <a href="https://wa.me/{{ $whatsAppNumber }}?text={{ urlencode($buyText) }}" class="inline-flex h-12 items-center justify-center rounded-full bg-[#e92d48] px-7 text-sm font-bold text-white hover:bg-[#d61f3d]">
                        Buy now on WhatsApp
                    </a>
                    <a href="{{ route('shop') }}" class="inline-flex h-12 items-center justify-center rounded-full border border-[#dddddd] bg-white px-7 text-sm font-semibold text-[#111827] hover:border-[#E30613] hover:text-[#E30613]">
                        Continue shopping
                    </a>
                </div>

                @if($specs->isNotEmpty())
                    <div class="mt-8 rounded-[12px] border border-[#eeeeee] bg-[#fafafa] p-4">
                        <h2 class="text-sm font-bold text-[#222222]">Specifications</h2>
                        <dl class="mt-3 grid gap-3 text-sm">
                            @foreach($specs as $key => $value)
                                <div class="grid grid-cols-[130px_minmax(0,1fr)] gap-3 border-b border-[#eeeeee] pb-2 last:border-b-0 last:pb-0">
                                    <dt class="font-medium text-[#6b7280]">{{ is_string($key) ? $key : 'Spec' }}</dt>
                                    <dd class="text-[#222222]">{{ is_array($value) ? implode(', ', $value) : $value }}</dd>
                                </div>
                            @endforeach
                        </dl>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
