@php
    $whatsAppNumber = preg_replace('/\D+/', '', config('services.whatsapp.number', '254713869018')) ?: '254713869018';
    $price = (float) $product->price;
    $oldPrice = $product->old_price && (float) $product->old_price > $price ? (float) $product->old_price : null;
    $discount = $oldPrice ? round((($oldPrice - $price) / $oldPrice) * 100) : null;
    $buyText = 'Hello, I am interested in '.$product->title.' - KES '.number_format($price);
@endphp

<article class="group relative mb-3 flex h-full w-full flex-col overflow-hidden rounded-[8px] border border-black/5 bg-white shadow-[0_1px_4px_rgba(0,0,0,0.08)] transition duration-200 ease-[ease] hover:-translate-y-0.5 active:scale-[0.98] sm:mb-0 sm:rounded-xl sm:border sm:bg-card sm:p-[4px] sm:shadow-none">
    <a href="{{ route('products.show', $product) }}" class="relative block h-[220px] w-full overflow-hidden bg-white sm:aspect-square sm:h-auto sm:rounded-[calc(theme(borderRadius.xl)-4px)]">
        <img src="{{ $product->primary_image }}" alt="{{ $product->title }}" loading="lazy" decoding="async" class="h-full w-full object-contain object-center transition-transform duration-200 ease-[ease] group-hover:scale-[1.02]">

        <div class="absolute left-2 right-2 top-2 flex items-start justify-between sm:left-3 sm:right-3 sm:top-3">
            @if($discount)
                <span class="inline-flex rounded-full bg-primary px-2 py-0.5 text-[9px] font-semibold tracking-[0.04em] text-primary-foreground sm:px-2.5 sm:py-1 sm:text-[10px]">
                    {{ $discount }}% OFF
                </span>
            @elseif($product->featured)
                <span class="inline-flex rounded-full bg-primary px-2 py-0.5 text-[9px] font-semibold tracking-[0.04em] text-primary-foreground sm:px-2.5 sm:py-1 sm:text-[10px]">
                    Featured
                </span>
            @else
                <span></span>
            @endif

            <span class="inline-flex h-7 w-7 items-center justify-center rounded-full bg-white/90 text-[#111827] shadow-[0_6px_18px_rgba(15,23,42,0.14)] backdrop-blur transition group-hover:scale-105 sm:h-8 sm:w-8">
                <i data-lucide="heart" class="h-3 w-3 sm:h-3.5 sm:w-3.5"></i>
            </span>
        </div>
    </a>

    <a href="{{ route('products.show', $product) }}" class="bg-white px-[4px] pb-[10px] pt-2 sm:mt-1.5 sm:flex sm:flex-col sm:gap-0.5 sm:bg-transparent sm:px-[1px] sm:pb-[1px] sm:pt-0" title="{{ $product->title }}">
        <div class="mb-1.5 flex items-center justify-between gap-2 whitespace-nowrap">
            <span class="text-[14px] font-bold leading-none text-[#E30613] transition-colors group-hover:text-[#c70511] sm:text-[13px] sm:text-foreground sm:group-hover:text-primary">
                KES {{ number_format($price) }}
            </span>
            @if($oldPrice)
                <span class="ml-auto text-[10px] text-[#9CA3AF] line-through sm:text-[10px] sm:text-muted-foreground">
                    KES {{ number_format($oldPrice) }}
                </span>
            @endif
        </div>

        <span class="overflow-hidden text-[13px] font-normal leading-[1.35] text-[#222222] [display:-webkit-box] [-webkit-line-clamp:2] [-webkit-box-orient:vertical] sm:line-clamp-2 sm:min-h-[2.15rem] sm:text-[12px] sm:font-medium sm:leading-[1.3] sm:text-[#3f3f46] sm:group-hover:text-primary">
            {{ $product->title }}
        </span>
    </a>

    <div class="hidden sm:mt-1.5 sm:grid sm:grid-cols-[1.7fr_1fr] sm:gap-1.5 sm:px-[1px] sm:pb-[1px]">
        <a href="https://wa.me/{{ $whatsAppNumber }}?text={{ urlencode($buyText) }}" class="inline-flex h-8 w-full items-center justify-center rounded-full bg-[#e92d48] px-2 text-[11px] font-medium text-white hover:bg-[#d61f3d]">
            Buy now
        </a>
        <a href="{{ route('products.show', $product) }}" class="inline-flex h-8 w-full items-center justify-center gap-1 rounded-full border border-[#d4d4d8] bg-white px-0 text-[11px] text-[#3f3f46] hover:bg-[#f4f4f5] hover:text-[#27272a]">
            <i data-lucide="shopping-cart" class="h-3.5 w-3.5"></i>
            <span>View</span>
        </a>
    </div>
</article>
