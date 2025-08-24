@php
    $type ??= 'text';
    $class ??= null;
    $name ??= '';
    $value ??= '';
    $label ??= ucfirst($name);
@endphp
<div class="space-y-12">
    <div class="sm:col-span-3">
        <label for="{{ $name }}" class="block text-sm/6 font-medium text-gray-900">{{ $label }}</label>
        @if ($type === 'textarea')
            <textarea id="{{ $name }}" name="{{ $name }}" rows="2"
                class="block @error($name) is-invalid @enderror w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">{{ old($name, $value) }}</textarea>
        @else
            <input id="{{ $name }}" type="{{ $type }}" name="{{ $name }}" value="{{ old($name, $value) }}"
                class="block @error($name) is-invalid @enderror w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6" />
        @endif

        @error($name)
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
