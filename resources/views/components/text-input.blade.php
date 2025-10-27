@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 focus:border-[#c1eaf7] focus:ring-[#c1eaf7] rounded-md shadow-sm']) }}>
