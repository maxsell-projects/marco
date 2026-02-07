@extends('layouts.app')

@section('content')
<div class="bg-white py-24">
    <div class="container mx-auto px-6">
        
        {{-- HEADER EDITORIAL --}}
        <div class="text-center max-w-3xl mx-auto mb-20">
            <span class="text-[10px] font-bold uppercase tracking-[0.5em] text-brand-secondary mb-4 block">Editorial</span>
            <h1 class="font-serif text-5xl md:text-6xl text-brand-text mb-6">Blog & Insights</h1>
            <div class="h-px w-24 bg-brand-sand mx-auto mb-6"></div>
            <p class="text-gray-500 font-light text-lg">As vozes do mercado, tendências de design e a curadoria exclusiva da nossa equipe.</p>
        </div>

        {{-- GRID DE POSTS --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-16">
            @forelse($posts as $post)
            <article class="group flex flex-col h-full bg-white transition-all duration-500">
                
                {{-- IMAGEM COM EFEITO LUXURY --}}
                <a href="{{ route('blog.show', $post->slug) }}" class="relative block aspect-[4/5] overflow-hidden mb-8 bg-slate-100">
                    @if($post->image_path)
                        <img src="{{ asset('storage/' . $post->image_path) }}" 
                             alt="{{ $post->title }}" 
                             class="w-full h-full object-cover grayscale-[30%] group-hover:grayscale-0 group-hover:scale-105 transition-all duration-700 ease-out">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-brand-sand uppercase text-[10px] tracking-widest font-bold">
                            Porthouse Collection
                        </div>
                    @endif
                    {{-- Overlay sutil no hover --}}
                    <div class="absolute inset-0 bg-brand-secondary/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                </a>

                {{-- CONTEÚDO --}}
                <div class="flex-1 flex flex-col">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="text-[10px] font-bold uppercase tracking-widest text-brand-secondary">Insights</span>
                        <span class="h-px w-8 bg-brand-sand"></span>
                        <p class="text-[10px] font-bold uppercase tracking-widest text-gray-400">{{ $post->created_at->format('d M, Y') }}</p>
                    </div>

                    <h2 class="font-serif text-2xl text-brand-text mb-4 leading-tight group-hover:text-brand-primary transition-colors duration-300">
                        <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                    </h2>

                    <p class="text-gray-500 text-sm leading-relaxed mb-8 flex-1 line-clamp-3 font-light">
                        {{ Str::limit(strip_tags($post->content), 140) }}
                    </p>

                    <div class="mt-auto">
                        <a href="{{ route('blog.show', $post->slug) }}" class="inline-block text-[10px] font-bold uppercase tracking-[0.2em] text-brand-text group-hover:text-brand-primary transition-all border-b border-transparent group-hover:border-brand-primary pb-1">
                            Continuar Leitura &nbsp; <span class="group-hover:translate-x-1 inline-block transition-transform">→</span>
                        </a>
                    </div>
                </div>
            </article>
            @empty
            <div class="col-span-full text-center py-32 border border-dashed border-slate-200 rounded-sm">
                <p class="font-serif text-2xl text-slate-300 italic">Em breve, novas perspetivas sobre o mercado.</p>
            </div>
            @endforelse
        </div>

        {{-- PAGINAÇÃO --}}
        <div class="mt-24 flex justify-center">
            <div class="custom-pagination">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
</div>

<style>
    /* Estilização da Paginação para manter o luxo */
    .custom-pagination nav svg { height: 1.25rem; width: 1.25rem; }
    .custom-pagination nav span, .custom-pagination nav a { 
        border-radius: 0 !important;
        border: none !important;
        font-size: 0.75rem !important;
        text-transform: uppercase !important;
        letter-spacing: 0.1em !important;
        font-weight: 700 !important;
    }
    .custom-pagination .bg-white { background-color: transparent !important; }
</style>
@endsection