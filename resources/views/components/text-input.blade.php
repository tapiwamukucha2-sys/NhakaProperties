@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 focus:border-[--forest] focus:ring-[--forest] rounded-md shadow-sm']) }}>
