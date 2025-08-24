@php
    $class = $class ?? null;
    $name = $name ?? '';
    $value = $value ?? collect();
    $label = $label ?? ucfirst($name);
@endphp
<div class="space-y-12">
    <div class="sm:col-span-3">
        <label for="{{ $name }}" class="block text-sm/6 font-medium text-gray-900">{{ $label }}</label>
        <select name="{{ $name }}" id="{{ $name }}" multiple>
            @foreach ($category as $k => $v)
                <option value="{{ $k }}" @if($value->contains($k)) selected @endif>{{ $v }}</option>
            @endforeach
        </select>
        @error($name)
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>


    <div class="mb-3">
        @include('shared.input', [
            'label' => 'Utilisateur',
            'name' => 'user_id',
            'value' => old('user_id', $user->user_id ?? ''),
            'multiple' => true
        ])
    </div>
