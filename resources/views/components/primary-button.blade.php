<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-[#550000] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#3a0000] focus:bg-[#3a0000] active:bg-black focus:outline-none focus:ring-2 focus:ring-[#550000] focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
