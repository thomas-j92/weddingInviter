@component('mail::layout')
    {{-- Header --}}
    @if(isset($showHeader) && $showHeader)
        @slot('header')
            @component('mail::header', ['url' => config('app.url')])
                {{ config('app.name') }}
            @endcomponent
        @endslot
    @endif

    {{-- Body --}}
    {{ $slot }}

    {{-- Subcopy --}}
    @isset($subcopy)
        @slot('subcopy')
            @component('mail::subcopy')
                {{ $subcopy }}
            @endcomponent
        @endslot
    @endisset

    {{-- Footer --}}
    @if(isset($showFooter) && $showFooter)
        @slot('footer')
            @component('mail::footer')
                © {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')
            @endcomponent
        @endslot
    @endif
@endcomponent
