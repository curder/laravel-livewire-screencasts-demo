@props([
    'initialValue' => ''
])
<div wire:ignore
     {{ $attributes }}
     x-data
     @trix-blur="$dispatch('change', $event.target.value)"
     class="rounded-md shadow-sm">
    <input id="x" type="hidden" value="{{ $initialValue }}">
    <trix-editor input="x" class="form-textarea block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"></trix-editor>
</div>
@push('styles')
<link href="https://cdn.bootcdn.net/ajax/libs/trix/1.3.0/trix.min.css" rel="stylesheet">
@endpush
@push('scripts')
<script src="https://cdn.bootcdn.net/ajax/libs/trix/1.3.0/trix.min.js"></script>
@endpush

