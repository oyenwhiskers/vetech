@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 focus:border-[#550000] focus:ring-[#550000] rounded-md shadow-sm']) }}>
