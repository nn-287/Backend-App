<div>
    <label for="{{ $name }}" class="block font-medium text-sm text-gray-700">{{ $label }}</label>
    <input type="checkbox" name="{{ $name }}" id="{{ $name }}" {{ $attributes->merge(['class' => 'form-checkbox rounded-md text-indigo-600']) }}>
</div>
