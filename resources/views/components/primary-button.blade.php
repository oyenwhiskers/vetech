<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-[#c1eaf7] border border-transparent rounded-md font-semibold text-xs text-[#222] uppercase tracking-widest hover:bg-[#8fd3e6] focus:bg-[#8fd3e6] active:bg-[#8fd3e6] focus:outline-none focus:ring-2 focus:ring-[#c1eaf7] focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
