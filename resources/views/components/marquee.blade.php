@if($marqueeItems->isNotEmpty())
<div class="marquee-wrap dynamic-marquee" data-marquee>
    <div class="marquee-inner">
        <div class="marquee-copy">@foreach($marqueeItems as $item)<span class="marquee-item">{{ $item->name }} <span aria-hidden="true">✳</span></span>@endforeach</div>
        <div class="marquee-copy" aria-hidden="true">@foreach($marqueeItems as $item)<span class="marquee-item">{{ $item->name }} <span>✳</span></span>@endforeach</div>
    </div>
    <button class="marquee-pause" type="button" aria-pressed="false" data-marquee-pause>Jeda animasi</button>
</div>
@endif
