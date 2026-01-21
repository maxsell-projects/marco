@extends('layouts.app')

@section('title', __('about.meta.title') . ' | Porthouse Private Office')

@section('content')

{{-- 1. HERO: MINIMALISTA & ELEGANTE --}}
<section class="relative h-[60vh] min-h-[500px] flex items-center justify-center bg-brand-secondary text-white overflow-hidden">
    {{-- Textura de fundo sutil --}}
    <div class="absolute inset-0 opacity-5 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
    
    {{-- Elemento Decorativo --}}
    <div class="absolute top-0 right-0 w-1/2 h-full bg-gradient-to-l from-black/20 to-transparent pointer-events-none"></div>

    <div class="container mx-auto px-6 relative z-10 text-center" data-aos="fade-up">
        <p class="text-brand-sand font-mono text-xs uppercase tracking-[0.4em] mb-8 animate-pulse flex items-center justify-center gap-4">
            <span class="w-8 h-[1px] bg-brand-sand"></span>
            {{ __('about.hero.subtitle') }}
            <span class="w-8 h-[1px] bg-brand-sand"></span>
        </p>
        <h1 class="text-6xl md:text-9xl font-serif leading-none mb-8 text-white">
            Porthouse
        </h1>
        <div class="w-24 h-[1px] bg-brand-sand mx-auto opacity-50"></div>
    </div>
</section>

{{-- 2. MANIFESTO (TEXTO DE IMPACTO) --}}
<section class="py-32 bg-brand-background">
    <div class="container mx-auto px-6 max-w-5xl text-center" data-aos="fade-up">
        <h2 class="text-3xl md:text-5xl font-serif text-brand-secondary leading-tight mb-12">
            "{{ __('about.manifesto.quote_part1') }} <span class="italic text-brand-primary border-b border-brand-primary/20 pb-1">{{ __('about.manifesto.quote_part2') }}</span>"
        </h2>
        
        <div class="text-brand-text/70 font-light text-lg leading-relaxed text-justify md:text-center max-w-3xl mx-auto space-y-6">
            <p>{!! __('about.manifesto.text_p1') !!}</p>
            <p>{!! __('about.manifesto.text_p2') !!}</p>
        </div>
    </div>
</section>

{{-- 3. A BIO & FOTO --}}
<section class="py-24 bg-white border-y border-brand-sand/10">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">
            
            {{-- Coluna da Foto --}}
            <div class="lg:col-span-5 relative" data-aos="fade-right">
                <div class="relative overflow-hidden aspect-[3/4] group shadow-2xl">
                    {{-- FOTO DO MARCO AQUI --}}
                    <img src="{{ asset('img/marco.jpg') }}" 
                         alt="Marco Moura - Founder" 
                         class="w-full h-full object-cover grayscale transition-all duration-1000 group-hover:grayscale-0 group-hover:scale-105">
                    
                    {{-- Badge Flutuante --}}
                    <div class="absolute bottom-0 left-0 bg-brand-primary text-white p-8 max-w-[85%] border-t-4 border-brand-sand">
                        <p class="font-serif text-3xl">15+ {{ __('about.bio.years') }}</p>
                        <p class="text-[10px] uppercase tracking-widest text-brand-sand mt-1">{{ __('about.bio.experience') }}</p>
                    </div>
                </div>
                {{-- Elemento Decorativo --}}
                <div class="absolute -z-10 top-8 -right-8 w-full h-full border-2 border-brand-secondary/10"></div>
            </div>

            {{-- Coluna de Texto --}}
            <div class="lg:col-span-7 space-y-12 pl-0 lg:pl-12">
                <div data-aos="fade-up">
                    <h3 class="text-xs font-bold uppercase tracking-widest text-brand-primary mb-6 flex items-center gap-3">
                        <span class="w-6 h-[1px] bg-brand-primary"></span>
                        {{ __('about.bio.label') }}
                    </h3>
                    <h2 class="text-4xl md:text-5xl font-serif text-brand-secondary mb-8 leading-tight">
                        {{ __('about.bio.title') }}
                    </h2>
                    
                    <div class="prose prose-lg text-gray-500 font-light leading-relaxed space-y-6 text-justify">
                        <p>{!! __('about.bio.p1') !!}</p>
                        <p>{!! __('about.bio.p2') !!}</p>
                        <p>{!! __('about.bio.p3') !!}</p>
                    </div>
                </div>

                {{-- Assinatura --}}
                <div data-aos="fade-up" data-aos-delay="200" class="border-t border-gray-100 pt-8">
                    <p class="font-serif italic text-3xl text-brand-secondary">Marco Moura</p>
                    <p class="text-xs text-brand-primary uppercase tracking-widest mt-2">Private Office Consultant</p>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- 4. PILARES / VALORES --}}
<section class="py-32 bg-brand-primary text-white">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-16 divide-y md:divide-y-0 md:divide-x divide-white/10">
            
            <div class="px-6 py-8 md:py-0 text-center md:text-left group" data-aos="fade-up" data-aos-delay="0">
                <span class="text-brand-sand font-serif text-6xl mb-8 block group-hover:scale-110 transition-transform opacity-50 group-hover:opacity-100">01.</span>
                <h4 class="text-xl font-bold uppercase tracking-widest mb-6">{{ __('about.values.1_title') }}</h4>
                <p class="text-white/70 font-light leading-relaxed text-sm">
                    {{ __('about.values.1_desc') }}
                </p>
            </div>

            <div class="px-6 py-8 md:py-0 text-center md:text-left group" data-aos="fade-up" data-aos-delay="200">
                <span class="text-brand-sand font-serif text-6xl mb-8 block group-hover:scale-110 transition-transform opacity-50 group-hover:opacity-100">02.</span>
                <h4 class="text-xl font-bold uppercase tracking-widest mb-6">{{ __('about.values.2_title') }}</h4>
                <p class="text-white/70 font-light leading-relaxed text-sm">
                    {!! __('about.values.2_desc') !!}
                </p>
            </div>

            <div class="px-6 py-8 md:py-0 text-center md:text-left group" data-aos="fade-up" data-aos-delay="400">
                <span class="text-brand-sand font-serif text-6xl mb-8 block group-hover:scale-110 transition-transform opacity-50 group-hover:opacity-100">03.</span>
                <h4 class="text-xl font-bold uppercase tracking-widest mb-6">{{ __('about.values.3_title') }}</h4>
                <p class="text-white/70 font-light leading-relaxed text-sm">
                    {{ __('about.values.3_desc') }}
                </p>
            </div>

        </div>
    </div>
</section>

{{-- 5. CTA EDITORIAL --}}
<section class="py-32 bg-white text-center relative overflow-hidden">
    {{-- Detalhe lateral --}}
    <div class="absolute left-0 top-1/2 -translate-y-1/2 w-2 h-32 bg-brand-secondary"></div>

    <div class="container mx-auto px-6" data-aos="zoom-in">
        <h2 class="text-4xl md:text-6xl font-serif text-brand-secondary mb-8 leading-tight">
            {{ __('about.cta.title_part1') }}<br>
            <span class="italic text-brand-primary">{{ __('about.cta.title_part2') }}</span>
        </h2>
        
        <p class="text-gray-500 mb-12 font-light text-lg">{{ __('about.cta.subtitle') }}</p>
        
        <a href="{{ route('contact') }}" class="group relative inline-flex items-center gap-4 px-12 py-5 bg-brand-secondary text-white text-xs font-bold uppercase tracking-[0.2em] overflow-hidden hover:bg-brand-primary transition-colors duration-500 shadow-xl">
            <span>{{ __('about.cta.btn') }}</span>
            <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 8l4 4m0 0l-4 4m4-4H3" />
            </svg>
        </a>
    </div>
</section>

@endsection