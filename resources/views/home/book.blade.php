@if (page_live('book'))
@php
    $themes = items('book_themes');
    $author = trim(content('profile.given_name').' '.content('profile.surname'));
    $roman = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
    $leaves = 14;
@endphp
<section class="tome" id="book" aria-labelledby="book-title" data-tome>
    <div class="tome-sticky">
        <div class="tome-glow" aria-hidden="true"></div>
        <div class="tome-motes" aria-hidden="true"><span style="--x: -9.2%; --dx: -63px; --s: 2px; --d: 2.56s; --w: -2.14s"></span><span style="--x: -7.0%; --dx: -80px; --s: 5px; --d: 2.87s; --w: -0.34s"></span><span style="--x: -4.3%; --dx: -47px; --s: 5px; --d: 3.33s; --w: -3.31s"></span><span style="--x: -19.6%; --dx: -50px; --s: 5px; --d: 4.48s; --w: -2.31s"></span><span style="--x: -5.4%; --dx: 86px; --s: 2px; --d: 3.62s; --w: -0.53s"></span><span style="--x: -4.2%; --dx: 7px; --s: 5px; --d: 3.08s; --w: -3.26s"></span><span style="--x: -16.6%; --dx: 15px; --s: 3px; --d: 3.22s; --w: -2.19s"></span><span style="--x: -22.7%; --dx: -79px; --s: 3px; --d: 3.49s; --w: -2.13s"></span><span style="--x: 14.4%; --dx: -6px; --s: 4px; --d: 3.20s; --w: -0.99s"></span><span style="--x: -16.7%; --dx: 50px; --s: 2px; --d: 3.66s; --w: -2.10s"></span><span style="--x: 19.5%; --dx: 41px; --s: 3px; --d: 3.74s; --w: -0.29s"></span><span style="--x: 0.6%; --dx: -60px; --s: 3px; --d: 2.73s; --w: -1.96s"></span><span style="--x: -24.0%; --dx: 30px; --s: 5px; --d: 3.66s; --w: -3.50s"></span><span style="--x: -9.7%; --dx: 35px; --s: 5px; --d: 3.49s; --w: -3.19s"></span><span style="--x: -22.4%; --dx: -73px; --s: 3px; --d: 3.44s; --w: -2.66s"></span><span style="--x: -22.8%; --dx: 36px; --s: 5px; --d: 4.58s; --w: -3.29s"></span><span style="--x: -11.2%; --dx: -21px; --s: 3px; --d: 2.45s; --w: -1.85s"></span><span style="--x: -17.3%; --dx: -69px; --s: 2px; --d: 2.88s; --w: -1.15s"></span><span style="--x: 12.4%; --dx: -18px; --s: 4px; --d: 2.58s; --w: -1.80s"></span><span style="--x: 2.6%; --dx: 69px; --s: 4px; --d: 4.30s; --w: -1.11s"></span><span style="--x: -4.4%; --dx: -25px; --s: 4px; --d: 4.51s; --w: -0.60s"></span><span style="--x: -16.8%; --dx: -48px; --s: 3px; --d: 2.43s; --w: -3.32s"></span></div>

        <header class="tome-intro">
            <p class="eyebrow">{{ content('navigation.book_label') }} · {{ content('book.release') }}</p>
            <h2 id="book-title" class="display">{{ content_html('book.cover_title') }}</h2>
            <p class="tome-lede">{{ content('home.book_text') }}</p>
            <p class="tome-hint"><span></span>{{ content('book.tome_hint') }}</p>
        </header>

        <div class="tome-scene">
            <div class="tome-book" data-tome-book>
                {{-- Back board and the block of pages it carries. The right-hand page of the final spread lives here. --}}
                <div class="tome-board" style="--cloth: url('{{ content_image('book.tome_cover') }}')"></div>
                <div class="tome-block" aria-hidden="true"><i class="tome-edge is-fore"></i><i class="tome-edge is-head"></i><i class="tome-edge is-tail"></i></div>
                <div class="tome-page is-right">
                    <div class="tome-paper">
                        <p class="tome-folio">{{ content('book.tome_contents_label') }}</p>
                        <ol class="tome-contents">
                            @foreach ($themes->take(10) as $theme)
                                <li><span class="tome-num">{{ $roman[$loop->index] ?? $loop->iteration }}</span><span class="tome-ch">{{ $theme->title }}</span><span class="tome-dots"></span><span class="tome-pg">{{ 3 + $loop->index * 24 }}</span></li>
                            @endforeach
                        </ol>
                        <p class="tome-colophon">{{ content('book.formats') }} · {{ content('book.release') }}</p>
                    </div>
                </div>

                {{-- The riffle: printed leaves that fan past before the book settles. --}}
                @for ($i = 0; $i < $leaves; $i++)
                    <div class="tome-leaf is-riffle" data-tome-leaf style="--n: {{ $i }}" aria-hidden="true">
                        <div class="tome-seg">
                            <div class="tome-face is-front"><span class="tome-type"></span></div>
                            <div class="tome-face is-back"><span class="tome-type"></span></div>
                            <div class="tome-seg is-outer">
                                <div class="tome-face is-front"><span class="tome-type"></span></div>
                                <div class="tome-face is-back"><span class="tome-type"></span></div>
                            </div>
                        </div>
                    </div>
                @endfor

                {{-- The last leaf: its reverse is the left-hand page of the final spread. --}}
                <div class="tome-leaf is-last" data-tome-leaf style="--n: {{ $leaves }}">
                    <div class="tome-face is-front" aria-hidden="true"><span class="tome-type"></span></div>
                    <div class="tome-face is-back">
                        <div class="tome-paper">
                            @if (content_image('book.tome_plate'))
                                <img class="tome-plate" src="{{ content_image('book.tome_plate') }}" alt="" loading="lazy">
                            @endif
                            <blockquote class="tome-epigraph">
                                <p>{{ content('book.tome_epigraph') }}</p>
                                <cite>{{ content('book.tome_epigraph_by') }}</cite>
                            </blockquote>
                        </div>
                    </div>
                </div>

                {{-- Front board: cloth and gold foil outside, marbled endpaper inside. --}}
                <div class="tome-cover" data-tome-cover>
                    <div class="tome-face is-front" style="--cloth: url('{{ content_image('book.tome_cover') }}')">
                        <p class="tome-foil tome-foil-title">{{ content_html('book.cover_title') }}</p>
                        <p class="tome-foil tome-foil-author">{{ $author }}</p>
                        <i class="tome-sheen"></i>
                    </div>
                    <div class="tome-face is-back" style="--endpaper: url('{{ content_image('book.tome_endpaper') }}')"></div>
                </div>
                <i class="tome-spine" style="--cloth: url('{{ content_image('book.tome_cover') }}')"><span>{{ content('book.title') }}</span></i>
            </div>
        </div>

        <div class="tome-actions">
            @if (content('book.order_link'))
                <a class="btn" href="{{ content_url('book.order_link') }}">{{ content('book.order_label') }} <span class="btn-icon"><x-line-icon name="arrow" /></span></a>
            @else
                <a class="btn" href="{{ route('book') }}#waitlist">Join the waiting list <span class="btn-icon"><x-line-icon name="arrow" /></span></a>
            @endif
            <a class="link-arrow" href="{{ route('book') }}">About the book <x-line-icon name="arrow" /></a>
        </div>
    </div>
</section>
@endif
