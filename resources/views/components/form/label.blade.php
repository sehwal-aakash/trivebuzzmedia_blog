@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-[11px] font-black uppercase tracking-widest text-surface-500 dark:text-surface-400 mb-1.5']) }}>
    {{ $value ?? $slot }}
</label>
