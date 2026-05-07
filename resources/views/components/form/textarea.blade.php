@props(['disabled' => false])

<textarea 
    {{ $disabled ? 'disabled' : '' }} 
    {!! $attributes->merge(['class' => 'w-full px-5 py-3.5 bg-white dark:bg-surface-950 border border-surface-200 dark:border-surface-800 rounded-2xl text-sm dark:text-white placeholder-surface-400 dark:placeholder-surface-600 focus:border-brand focus:ring-4 focus:ring-brand/5 outline-none transition-all shadow-sm hover:border-surface-300 dark:hover:border-surface-700 disabled:bg-surface-50 disabled:text-surface-500 resize-none font-medium']) !!}
></textarea>
