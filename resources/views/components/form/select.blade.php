@props(['disabled' => false])

<select 
    {{ $disabled ? 'disabled' : '' }} 
    {!! $attributes->merge(['class' => 'w-full px-5 py-3.5 bg-white dark:bg-surface-950 border border-surface-200 dark:border-surface-800 rounded-2xl text-sm dark:text-white focus:border-brand focus:ring-4 focus:ring-brand/5 outline-none transition-all shadow-sm hover:border-surface-300 dark:hover:border-surface-700 disabled:bg-surface-50 cursor-pointer font-medium']) !!}
>
    {{ $slot }}
</select>
