@props(['type' => 'submit', 'variant' => 'primary', 'size' => 'md', 'tag' => 'button'])

@php
    $baseClasses = 'inline-flex items-center justify-center font-black uppercase tracking-widest transition-all active:scale-95 disabled:opacity-50 disabled:pointer-events-none rounded-full';
    
    $variants = [
        'primary' => 'bg-surface-900 dark:bg-white text-white dark:text-surface-900 hover:opacity-90 shadow-lg shadow-surface-900/10 dark:shadow-white/5',
        'brand' => 'bg-brand text-white hover:bg-brand-dark shadow-lg shadow-brand/20',
        'outline' => 'border-2 border-surface-200 dark:border-surface-800 text-surface-600 dark:text-surface-400 hover:border-surface-900 dark:hover:border-white hover:text-surface-900 dark:hover:text-white',
        'danger' => 'bg-red-600 text-white hover:bg-red-700 shadow-lg shadow-red-600/20',
    ];

    $sizes = [
        'sm' => 'px-5 py-2.5 text-[10px]',
        'md' => 'px-8 py-3.5 text-xs',
        'lg' => 'px-12 py-4.5 text-xs tracking-[0.2em]',
    ];

    $classes = $baseClasses . ' ' . ($variants[$variant] ?? $variants['primary']) . ' ' . ($sizes[$size] ?? $sizes['md']);
@endphp

@if($tag === 'a')
    <a {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
