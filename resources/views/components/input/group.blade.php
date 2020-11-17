@props([
'label',
'for',
'error',
'helpText',
])

<div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-t sm:border-gray-200 sm:pt-5">
    <label for="{{ $for }}" class="block text-sm font-medium leading-5 text-gray-700 sm:mt-px sm:pt-2">
        {{ $label }}
    </label>

    <div class="mt-1 sm:mt-0 sm:col-span-2">
        {{ $slot }}

        @isset($helpText)<p class="mt-2 text-sm text-gray-500">{{ $helpText }}</p>@endif

        @if($error)<p class="mt-2 text-sm text-red-500">{{ $error }}</p>@endif
    </div>
</div>
