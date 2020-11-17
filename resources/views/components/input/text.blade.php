@props(['leadingAddOn'])

<div class="max-w-lg flex rounded-md shadow-sm">
    @isset ($leadingAddOn)
        <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">{{ $leadingAddOn }}</span>
    @endif
    <input {{ $attributes }} class="@isset($leadingAddOn) rounded-none rounded-r-md @endif flex-1 form-input block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5"/>
</div>
