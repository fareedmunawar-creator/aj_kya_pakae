@props(['align' => 'right', 'width' => '48', 'contentClasses' => 'py-1 bg-white'])

@php
$alignmentClasses = match ($align) {
    'left' => 'dropdown-menu-start',
    'right' => 'dropdown-menu-end',
    default => 'dropdown-menu-end',
};
@endphp

<div class="dropdown">
    <div class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
        {{ $trigger }}
    </div>

    <ul class="dropdown-menu {{ $alignmentClasses }}">
        {{ $content }}
    </ul>
</div>
