@props(['id', 'name', 'value' => ''])

<input
    type="hidden"
    name="{{ $name }}"
    id="{{ $id }}_input"
    value="{{ $value }}" />

<div class="border border-gray-300 focus-within:ring-2 focus-within:border-[#3db87a] focus-within:ring-[#99ddbb] rounded-md text-sm">
    <trix-toolbar
        class="[&_.trix-button]:bg-none [&_.trix-button.trix-active]:bg-gray-300"
        id="{{ $id }}_toolbar"></trix-toolbar>

    <trix-editor
        id="{{ $id }}"
        toolbar="{{ $id }}_toolbar"
        input="{{ $id }}_input"
        {{ $attributes->merge(['class' => 'trix-content border-0']) }}></trix-editor>
</div>