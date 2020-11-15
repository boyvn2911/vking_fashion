<section class="section--instagram">
    <div class="half-circle-spinner">
        <div class="circle circle-1"></div>
        <div class="circle circle-2"></div>
    </div>
    <div class="instagram-images"></div>
    @if ($title || $description || $store)
        <div class="section__follow-instagram" style="display: none">
            <figure>
                <h3>{!! clean($title) !!}</h3>
                @if ($description)
                    <p>{!! clean($description) !!}</p>
                @endif
            </figure><a href="https://www.instagram.com/{{ $username }}">{{ $store }}</a>
        </div>
    @endif
</section>
<div data-instagram-username="{{ $username }}"></div>
