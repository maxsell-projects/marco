@extends('layouts.app')

@section('title', __('home.meta.title') . ' | Porthouse Private Office')

@section('content')

{{-- 
    ESTRUTURA CLEAN LUXURY 
    Base: Branco (#FFFFFF)
    Texto: Escuro (#1a1a1a) / Detalhes: Verde (#1D4C42)
--}}

<div x-data="{ 
        loaded: false, 
        videoPlaying: true,
        toggleVideo() {
            const vid = document.getElementById('heroVideo');
            if (vid.paused) { vid.play(); this.videoPlaying = true; } 
            else { vid.pause(); this.videoPlaying = false; }
        },
        init() { 
            setTimeout(() => this.loaded = true, 800) 
        } 
    }" 
    class="bg-white min-h-screen relative overflow-hidden selection:bg-brand-secondary selection:text-white">

    {{-- 1. INTRO / LOADING SCREEN (Fundo Branco Clean) --}}
    <div x-show="!loaded" 
         x-transition:leave="transition ease-in-out duration-1000"
         x-transition:leave-start="transform translate-y-0"
         x-transition:leave-end="transform -translate-y-full"
         class="fixed inset-0 z-[100] bg-white flex items-center justify-center">
        
        <div class="text-center" x-transition:leave="transition duration-500 opacity-0">
            {{-- Logo Apenas Ícone/Imagem --}}
            <img src="{{ asset('img/Ativo_5.png') }}" alt="Porthouse" class="h-24 w-auto object-contain opacity-80 mb-6 animate-pulse">
            <p class="text-brand-secondary font-sans font-light text-xs tracking-[0.4em] uppercase">Private Office</p>
        </div>
    </div>

    {{-- 2. HERO VIDEO (Cinematográfica & Conceitual) --}}
    <section class="relative h-screen w-full overflow-hidden flex items-center justify-center">
        
        {{-- Vídeo de Background --}}
        <video id="heroVideo" autoplay muted loop playsinline 
               poster="{{ asset('img/porto_dark.jpeg') }}"
               class="absolute inset-0 w-full h-full object-cover z-0">
            <source src="{{ asset('video/hero.mp4') }}" type="video/mp4">
        </video>

        {{-- Overlay Escuro --}}
        <div class="absolute inset-0 bg-black/40 z-10"></div>

        {{-- Conteúdo Central --}}
        <div class="relative z-20 container mx-auto px-6 text-center text-white flex flex-col items-center justify-center h-full" data-aos="fade-up" data-aos-duration="1500">
            
            {{-- FRASE CONCEITO (Traduzida) --}}
            <h1 class="font-sans font-thin text-5xl md:text-7xl lg:text-8xl tracking-widest uppercase leading-tight mb-12">
                {{ __('home.hero.title_1') }} <br>
                <span class="font-light">{{ __('home.hero.title_2') }}</span>
            </h1>

            {{-- Play Button --}}
            <button @click="toggleVideo()" 
                    class="group flex flex-col items-center gap-4 transition-all duration-500 hover:scale-110 focus:outline-none">
                
                {{-- Círculo do Play --}}
                <div class="w-20 h-20 rounded-full border border-white/40 backdrop-blur-md flex items-center justify-center group-hover:bg-white group-hover:text-brand-secondary transition-all duration-500">
                    <span x-show="!videoPlaying" x-cloak class="ml-1 text-2xl">▶</span>
                    <span x-show="videoPlaying" class="block w-3 h-3 bg-current rounded-sm"></span>
                </div>
                
                {{-- Texto do Botão (Traduzido) --}}
                <span class="text-[10px] uppercase tracking-[0.3em] opacity-80 group-hover:opacity-100 transition-opacity">
                    {{ __('home.hero.cta') }}
                </span>
            </button>
        </div>

        {{-- Scroll Indicator --}}
        <div class="absolute bottom-10 left-1/2 -translate-x-1/2 z-20 animate-bounce opacity-60">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
        </div>
    </section>

    {{-- 3. O MANIFESTO (Traduzido) --}}
    <section class="py-32 md:py-48 px-6 bg-white relative overflow-hidden">
        {{-- Elemento Decorativo --}}
        <div class="absolute top-20 left-0 text-[20rem] font-serif text-brand-secondary/5 leading-none -ml-20 select-none pointer-events-none">
            &
        </div>

        <div class="container mx-auto max-w-6xl relative z-10">
            <div class="flex flex-col gap-20">
                
                {{-- Título Manifesto --}}
                <div class="max-w-2xl" data-aos="fade-up">
                    <div class="flex items-center gap-4 mb-8">
                        <span class="w-12 h-px bg-brand-secondary"></span> 
                        <span class="text-xs font-bold uppercase tracking-[0.4em] text-brand-secondary">{{ __('home.manifesto.label') }}</span>
                    </div>
                    <h2 class="font-serif text-4xl md:text-6xl text-brand-text leading-tight">
                        {!! __('home.manifesto.title_1') !!}
                    </h2>
                </div>

                {{-- Texto Fluido --}}
                <div class="self-end max-w-3xl text-right" data-aos="fade-up" data-aos-delay="200">
                    <p class="font-sans font-light text-xl md:text-3xl text-neutral-600 leading-relaxed">
                        {!! __('home.manifesto.subtitle') !!}
                    </p>
                    
                    <div class="mt-16 flex flex-col items-end gap-6">
                        <p class="font-serif text-2xl md:text-4xl text-brand-secondary leading-snug max-w-xl">
                            “{{ __('home.manifesto.quote_text') }} <span class="italic text-brand-primary">{!! __('home.manifesto.quote_emphasis') !!}</span>”
                        </p>
                        <div class="flex items-center gap-4 mt-4">
                             <span class="h-px w-20 bg-brand-secondary/20"></span>
                             <span class="font-signature text-3xl text-brand-secondary">Marco Moura</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- 4. PRIVATE COLLECTION --}}
    <section id="private-collection" class="py-32 bg-neutral-50 border-t border-neutral-100">
        <div class="container mx-auto px-6">
            
            <div class="flex flex-col md:flex-row justify-between items-end mb-24">
                <div>
                    <h3 class="font-sans font-light text-5xl md:text-7xl text-brand-text uppercase tracking-tight">
                        {{ __('home.collection.title_1') }} <br>
                        <span class="font-serif italic text-brand-secondary lowercase">{{ __('home.collection.title_2') }}</span>
                    </h3>
                    <p class="text-neutral-400 mt-6 max-w-md font-light">
                        {{ __('home.collection.subtitle') }}
                    </p>
                </div>
                <a href="{{ route('portfolio') }}" class="hidden md:inline-block text-xs font-bold uppercase tracking-[0.2em] text-brand-secondary border-b border-brand-secondary pb-1 hover:text-brand-primary hover:border-brand-primary transition-all">
                    {{ __('home.collection.explore_all') }}
                </a>
            </div>

            {{-- GRID CLEAN (3 Colunas) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-16">
                @foreach($properties->take(3) as $property)
                    <div class="group cursor-pointer" data-aos="fade-up">
                        <a href="{{ route('properties.show', $property->slug) }}" class="block">
                            <div class="relative overflow-hidden aspect-[4/5] bg-gray-200 mb-6">
                                <img src="{{ $property->cover_image ? asset('storage/' . $property->cover_image) : asset('img/placeholder.jpg') }}" 
                                     class="w-full h-full object-cover transition-transform duration-[1.2s] ease-out group-hover:scale-105 filter grayscale-[20%] group-hover:grayscale-0"
                                     alt="{{ $property->title }}">
                                
                                <div class="absolute top-0 right-0 bg-white/90 backdrop-blur text-brand-secondary px-4 py-2 text-sm font-serif">
                                    {{ number_format($property->price, 0, ',', '.') }} €
                                </div>
                            </div>

                            <div class="flex justify-between items-start border-t border-neutral-200 pt-4 group-hover:border-brand-secondary/50 transition-colors">
                                <div>
                                    <h4 class="font-serif text-2xl text-brand-text group-hover:text-brand-secondary transition-colors">{{ $property->title }}</h4>
                                    <p class="text-[10px] font-bold uppercase tracking-widest text-neutral-400 mt-1">{{ $property->location }}</p>
                                </div>
                                <span class="text-brand-secondary opacity-0 -translate-x-2 group-hover:opacity-100 group-hover:translate-x-0 transition-all duration-300">→</span>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            {{-- Lista Compacta --}}
            @if($properties->count() > 3)
            <div class="mt-32 border-t border-neutral-200 pt-16" data-aos="fade-up">
                <p class="text-xs font-bold uppercase tracking-[0.3em] text-neutral-400 mb-12 text-center">{{ __('home.collection.more_opportunities') }}</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    @foreach($properties->skip(3)->take(4) as $property)
                    <a href="{{ route('properties.show', $property->slug) }}" class="group block">
                        <div class="aspect-[3/2] bg-gray-100 mb-4 overflow-hidden relative">
                             <img src="{{ $property->cover_image ? asset('storage/' . $property->cover_image) : asset('img/placeholder.jpg') }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105 grayscale">
                        </div>
                        <h5 class="font-serif text-lg text-brand-text truncate">{{ $property->title }}</h5>
                        <p class="text-xs text-neutral-500 font-light">{{ number_format($property->price, 0, ',', '.') }} €</p>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            <div class="text-center mt-16 md:hidden">
                <a href="{{ route('portfolio') }}" class="inline-block border-b border-brand-secondary pb-1 text-brand-secondary uppercase text-xs font-bold tracking-widest">
                    {{ __('home.collection.explore_all') }}
                </a>
            </div>
        </div>
    </section>

    {{-- 5. SERVICES --}}
    <section class="py-32 px-6 bg-white">
        <div class="container mx-auto max-w-5xl">
            <div class="text-center mb-24">
                <p class="font-bold text-xs uppercase tracking-[0.3em] text-brand-secondary mb-4">{{ __('home.services.label') }}</p>
                <h3 class="font-serif text-5xl md:text-6xl text-brand-text">{{ __('home.services.main_title') }}</h3>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 divide-y md:divide-y-0 md:divide-x divide-neutral-100">
                {{-- Service 1 --}}
                <div class="pt-8 md:pt-0 md:px-8 text-center group" data-aos="fade-up">
                    <span class="block font-serif text-4xl text-neutral-200 mb-6 group-hover:text-brand-primary transition-colors">01</span>
                    <h4 class="text-xl font-serif text-brand-text mb-4">{{ __('home.services.1_title') }}</h4>
                    <p class="font-light text-sm text-neutral-500 leading-relaxed">{{ __('home.services.1_desc') }}</p>
                </div>

                {{-- Service 2 --}}
                <div class="pt-8 md:pt-0 md:px-8 text-center group" data-aos="fade-up" data-aos-delay="100">
                    <span class="block font-serif text-4xl text-neutral-200 mb-6 group-hover:text-brand-primary transition-colors">02</span>
                    <h4 class="text-xl font-serif text-brand-text mb-4">{{ __('home.services.2_title') }}</h4>
                    <p class="font-light text-sm text-neutral-500 leading-relaxed">{{ __('home.services.2_desc') }}</p>
                </div>

                {{-- Service 3 --}}
                <div class="pt-8 md:pt-0 md:px-8 text-center group" data-aos="fade-up" data-aos-delay="200">
                    <span class="block font-serif text-4xl text-neutral-200 mb-6 group-hover:text-brand-primary transition-colors">03</span>
                    <h4 class="text-xl font-serif text-brand-text mb-4">{{ __('home.services.3_title') }}</h4>
                    <p class="font-light text-sm text-neutral-500 leading-relaxed">{{ __('home.services.3_desc') }}</p>
                </div>
            </div>
        </div>
    </section>

    {{-- 6. CONTACTO --}}
    <section id="contact-focus" class="py-32 px-6 border-t border-neutral-100 bg-white">
        <div class="container mx-auto max-w-4xl text-center" data-aos="zoom-in">
            <p class="font-mono text-xs uppercase tracking-[0.4em] mb-8 text-brand-secondary">{{ __('home.contact.label') }}</p>
            <h2 class="text-5xl md:text-8xl font-serif mb-12 text-brand-text leading-none">
                {{ __('home.contact.title_1') }} <br><span class="italic text-brand-secondary">{{ __('home.contact.title_2') }}</span>
            </h2>
            
            <div class="flex flex-col md:flex-row justify-center items-center gap-6">
                  <a href="https://wa.me/351910000000" target="_blank" class="px-10 py-4 bg-brand-secondary text-white font-bold uppercase tracking-widest hover:bg-brand-primary transition-colors duration-300 min-w-[200px]">
                      {{ __('home.contact.whatsapp') }}
                  </a>
                  <span class="font-serif italic text-2xl text-neutral-300">{{ __('home.contact.or') }}</span>
                  <a href="mailto:contact@porthouse.pt" class="px-10 py-4 border border-brand-secondary text-brand-secondary font-bold uppercase tracking-widest hover:bg-brand-secondary hover:text-white transition-colors duration-300 min-w-[200px]">
                      {{ __('home.contact.email') }}
                  </a>
            </div>
            
            <div class="mt-20 pt-8 border-t border-neutral-100 text-[10px] text-neutral-400 font-light uppercase tracking-widest">
                Porthouse Private Office • Porto, Portugal
            </div>
        </div>
    </section>

</div>

<style>
    [x-cloak] { display: none !important; }
</style>

@endsection