@props(['href' => null, 'type' => 'primary'])

@if ($href)
    <a href="{{ $href }}" class="btn btn-{{ $type }}">
        {{ $slot }}
    </a>
@else
    <button class="btn btn-{{ $type }}">
        {{ $slot }}
    </button>
@endif
