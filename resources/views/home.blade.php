@extends('layouts.app')

@section('title', __('home.meta.title') . ' | Porthouse Private Office')

@section('content')

{{-- 
    ESTRUTURA BOUTIQUE & ASSIMÉTRICA 
    Cor de Fundo: Brand Sand (#E5C2A4)
    Texto: Brand Secondary (#1D4C42)
--}}

<div x-data="{ 
        loaded: false, 
        init() { 
            setTimeout(() => this.loaded = true, 800) 
        } 
    }" 
    class="bg-brand-sand min-h-screen relative overflow-hidden selection:bg-brand-secondary selection:text-brand-sand">

    {{-- 1. INTRO / LOADING SCREEN --}}
    <div x-show="!loaded" 
         x-transition:leave="transition ease-in-out duration-1000"
         x-transition:leave-start="transform translate-y-0"
         x-transition:leave-end="transform -translate-y-full"
         class="fixed inset-0 z-[100] bg-brand-secondary flex items-center justify-center">
        
        <div class="text-center" x-transition:leave="transition duration-500 opacity-0">
            <img src="{{ asset('img/Ativo_5.png') }}" alt="Porthouse" class="h-24 w-auto object-contain brightness-0 invert opacity-80 mb-6 animate-pulse">
            <p class="text-brand-sand font-serif italic text-xl tracking-[0.3em]">PRIVATE OFFICE</p>
        </div>
    </div>

    {{-- 2. HERO --}}
    <section class="relative min-h-screen pt-48 pb-0 px-0 flex flex-col justify-center">
        <div class="absolute inset-0 pointer-events-none opacity-10 flex justify-between px-6 md:px-20">
            <div class="w-px h-full bg-brand-secondary"></div>
            <div class="w-px h-full bg-brand-secondary hidden md:block"></div>
            <div class="w-px h-full bg-brand-secondary"></div>
        </div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-center">
                <div class="md:col-span-7 mix-blend-multiply" data-aos="fade-right" data-aos-duration="1200">
                    <h1 class="text-brand-secondary font-serif text-7xl md:text-[9rem] leading-[0.85] tracking-tight">
                        Port<br>
                        <span class="italic ml-12 md:ml-24 opacity-80">house</span><br>
                        <span class="text-3xl md:text-5xl tracking-widest font-sans font-light uppercase mt-4 block border-t border-brand-secondary/30 pt-6">
                            Private Office
                        </span>
                    </h1>
                </div>

                <div class="md:col-span-5 relative mt-12 md:mt-0" data-aos="zoom-in" data-aos-delay="400">
                    <div class="relative aspect-[3/4] md:aspect-[4/5] overflow-hidden rounded-t-[100px] shadow-2xl border border-brand-secondary/20">
                        <img src="{{ asset('img/porto_dark.jpeg') }}" 
                             onerror="this.src='https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&q=80'"
                             class="w-full h-full object-cover grayscale hover:grayscale-0 transition-all duration-1000 scale-110 hover:scale-100" 
                             alt="Luxury Real Estate Porto">
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 3. O MANIFESTO (TRADUZIDO) --}}
    <section class="py-32 px-6 relative overflow-hidden">
        <div class="absolute top-0 right-0 text-[30rem] font-serif text-brand-secondary opacity-5 leading-none -mr-20 select-none pointer-events-none">
            &
        </div>

        <div class="container mx-auto max-w-5xl">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
                <div data-aos="fade-up">
                      <p class="text-brand-secondary font-bold text-xs uppercase tracking-[0.4em] mb-12 flex items-center gap-4">
                        <span class="w-12 h-px bg-brand-secondary"></span> {{ __('home.manifesto.label') }}
                      </p>
                      
                      <div class="space-y-8">
                          <h2 class="text-4xl md:text-6xl font-serif text-brand-secondary leading-tight">
                              {!! __('home.manifesto.title_1') !!}
                          </h2>
                          <p class="text-xl md:text-2xl font-light text-brand-secondary/80 ml-8 md:ml-16 border-l border-brand-secondary/30 pl-6">
                              {!! __('home.manifesto.subtitle') !!}
                          </p>
                          <h2 class="text-4xl md:text-6xl font-serif text-brand-secondary leading-tight text-right">
                              {!! __('home.manifesto.title_2') !!}
                          </h2>
                      </div>
                </div>

                <div class="relative pt-20 md:pt-0" data-aos="fade-up" data-aos-delay="200">
                    <div class="bg-brand-secondary p-12 text-brand-sand shadow-2xl relative transform md:rotate-2 hover:rotate-0 transition-transform duration-500">
                        <span class="absolute -top-4 -left-4 text-6xl text-brand-primary">“</span>
                        <p class="font-serif text-2xl leading-relaxed">
                            {{ __('home.manifesto.quote_text') }} <br>
                            <span class="text-brand-primary italic">{!! __('home.manifesto.quote_emphasis') !!}</span>
                        </p>
                        <div class="mt-8 flex justify-end">
                            <span class="font-signature text-3xl">Marco Moura</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- 4. PRIVATE COLLECTION --}}
    <section id="private-collection" class="py-32 bg-brand-secondary text-brand-sand relative">
        <div class="container mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-end mb-24 border-b border-brand-sand/20 pb-8">
                <h3 class="font-serif text-5xl md:text-7xl">Private<br><span class="italic text-brand-primary">Collection</span></h3>
                <p class="text-brand-sand/60 max-w-sm text-right mt-6 md:mt-0 font-light">
                    {{ __('home.collection.subtitle') }}
                </p>
            </div>

            {{-- TOP 3 --}}
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 md:gap-y-24 mb-32">
                @foreach($properties->take(3) as $index => $property)
                    @php
                        $colClass = match($index) {
                            0 => 'md:col-span-7',
                            1 => 'md:col-span-5 md:mt-32',
                            2 => 'md:col-span-10 md:col-start-2',
                            default => 'md:col-span-6'
                        };
                        $aspectClass = match($index) {
                            0 => 'aspect-[16/10]',
                            1 => 'aspect-[3/4]',
                            2 => 'aspect-[21/9]',
                            default => 'aspect-[4/3]'
                        };
                    @endphp

                    <div class="{{ $colClass }} group relative" data-aos="fade-up">
                        <a href="{{ route('properties.show', $property->slug) }}" class="block w-full h-full">
                            <div class="relative w-full {{ $aspectClass }} overflow-hidden bg-brand-primary/10">
                                <img src="{{ $property->cover_image ? asset('storage/' . $property->cover_image) : asset('img/placeholder.jpg') }}" 
                                     class="w-full h-full object-cover transition-transform duration-[1.5s] group-hover:scale-110 grayscale group-hover:grayscale-0"
                                     alt="{{ $property->title }}">
                                <div class="absolute top-0 right-0 bg-brand-sand text-brand-secondary px-6 py-4 font-serif text-xl z-20">
                                    {{ number_format($property->price, 0, ',', '.') }} €
                                </div>
                            </div>
                            <div class="flex justify-between items-start mt-6 border-t border-brand-sand/20 pt-4">
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-widest text-brand-primary mb-2">{{ $property->location }}</p>
                                    <h4 class="font-serif text-3xl group-hover:text-brand-primary transition-colors">{{ $property->title }}</h4>
                                </div>
                                <div class="hidden md:block">
                                    <span class="inline-flex items-center justify-center w-12 h-12 rounded-full border border-brand-sand/30 group-hover:bg-brand-sand group-hover:text-brand-secondary transition-all">→</span>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            {{-- GRID MENOR (4 COLUNAS) --}}
            @if($properties->count() > 3)
            <div class="mb-24" data-aos="fade-up">
                <div class="flex items-center gap-4 mb-12">
                      <span class="h-px w-12 bg-brand-sand/30"></span>
                      <p class="text-xs uppercase tracking-[0.3em] opacity-60">More from our portfolio</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 gap-y-10">
                    @foreach($properties->skip(3)->take(6) as $property)
                    <div class="group cursor-pointer">
                        <a href="{{ route('properties.show', $property->slug) }}" class="block">
                            <div class="aspect-[3/2] overflow-hidden bg-brand-primary/5 mb-4 relative">
                                <img src="{{ $property->cover_image ? asset('storage/' . $property->cover_image) : asset('img/placeholder.jpg') }}" 
                                     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105 grayscale-[30%] group-hover:grayscale-0">
                                <div class="absolute inset-0 bg-brand-secondary/90 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                    <span class="bg-brand-sand text-brand-secondary px-3 py-1 text-[10px] font-bold uppercase tracking-widest">View</span>
                                </div>
                            </div>
                            <div class="flex justify-between items-end border-b border-brand-sand/10 pb-3 group-hover:border-brand-sand/40 transition-colors">
                                <div>
                                    <h4 class="font-serif text-base text-brand-sand leading-tight group-hover:text-white transition-colors truncate max-w-[150px]">{{ $property->title }}</h4>
                                    <p class="text-[9px] font-bold uppercase tracking-widest text-brand-sand/50 mt-1">{{ $property->location }}</p>
                                </div>
                                <div class="text-right">
                                    <span class="block text-xs font-serif opacity-80">{{ number_format($property->price, 0, ',', '.') }} €</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- LINK COM BR CORRIGIDO (USO DE {!! !!}) --}}
            <div class="text-center pt-12">
                <a href="{{ route('portfolio') }}" class="inline-block border-b border-brand-sand pb-1 text-2xl font-serif italic hover:text-brand-primary hover:border-brand-primary transition-all leading-tight">
                    {!! __('home.collection.explore_all') !!}
                </a>
            </div>
        </div>
    </section>

    {{-- 5. SERVICES --}}
    <section class="py-32 px-6 bg-brand-sand text-brand-secondary">
        <div class="container mx-auto max-w-4xl">
            <div class="text-center mb-20">
                <p class="font-bold text-xs uppercase tracking-[0.3em] mb-4">Expertise</p>
                <h3 class="font-serif text-5xl">Bespoke Services</h3>
            </div>
            <div class="space-y-0 divide-y divide-brand-secondary/20 border-t border-b border-brand-secondary/20">
                <div class="group py-12 flex flex-col md:flex-row md:items-center justify-between hover:bg-white/20 transition-colors px-4 cursor-default" data-aos="fade-up">
                    <div class="flex items-baseline gap-8">
                        <span class="font-serif text-brand-secondary/30 text-3xl group-hover:text-brand-primary transition-colors">01</span>
                        <h4 class="text-2xl font-serif">{{ __('home.services.1_title') }}</h4>
                    </div>
                    <p class="mt-4 md:mt-0 max-w-sm text-sm opacity-70 font-light group-hover:opacity-100 transition-opacity">{{ __('home.services.1_desc') }}</p>
                </div>
                <div class="group py-12 flex flex-col md:flex-row md:items-center justify-between hover:bg-white/20 transition-colors px-4 cursor-default" data-aos="fade-up" data-aos-delay="100">
                    <div class="flex items-baseline gap-8">
                        <span class="font-serif text-brand-secondary/30 text-3xl group-hover:text-brand-primary transition-colors">02</span>
                        <h4 class="text-2xl font-serif">{{ __('home.services.2_title') }}</h4>
                    </div>
                    <p class="mt-4 md:mt-0 max-w-sm text-sm opacity-70 font-light group-hover:opacity-100 transition-opacity">{{ __('home.services.2_desc') }}</p>
                </div>
                <div class="group py-12 flex flex-col md:flex-row md:items-center justify-between hover:bg-white/20 transition-colors px-4 cursor-default" data-aos="fade-up" data-aos-delay="200">
                    <div class="flex items-baseline gap-8">
                        <span class="font-serif text-brand-secondary/30 text-3xl group-hover:text-brand-primary transition-colors">03</span>
                        <h4 class="text-2xl font-serif">{{ __('home.services.3_title') }}</h4>
                    </div>
                    <p class="mt-4 md:mt-0 max-w-sm text-sm opacity-70 font-light group-hover:opacity-100 transition-opacity">{{ __('home.services.3_desc') }}</p>
                </div>
            </div>
        </div>
    </section>

    {{-- 6. CONTACTO --}}
    <section id="contact-focus" class="py-32 px-6 pb-40">
        <div class="container mx-auto max-w-6xl relative">
            <div class="bg-brand-secondary text-brand-sand rounded-t-[50px] md:rounded-t-[100px] p-12 md:p-24 text-center shadow-2xl overflow-hidden relative" data-aos="zoom-in-up">
                <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] mix-blend-overlay"></div>
                <p class="font-mono text-xs uppercase tracking-[0.4em] mb-8 text-brand-primary">Inquiry</p>
                <h2 class="text-5xl md:text-8xl font-serif mb-12 leading-none">Start the <br><span class="italic text-brand-primary">Conversation</span></h2>
                <div class="flex flex-col md:flex-row justify-center items-center gap-6 relative z-10">
                      <a href="https://wa.me/351910000000" target="_blank" class="px-10 py-4 bg-brand-sand text-brand-secondary font-bold uppercase tracking-widest hover:bg-white transition-all duration-500 min-w-[200px]">WhatsApp</a>
                      <span class="font-serif italic text-2xl opacity-50">or</span>
                      <a href="mailto:contact@porthouse.pt" class="px-10 py-4 border border-brand-sand text-brand-sand font-bold uppercase tracking-widest hover:bg-brand-primary hover:border-brand-primary hover:text-white transition-all duration-500 min-w-[200px]">Email Us</a>
                </div>
                <div class="mt-16 pt-8 border-t border-brand-sand/10 text-xs opacity-40 font-light uppercase tracking-widest">Porthouse Private Office • Porto, Portugal</div>
            </div>
        </div>
    </section>

</div>

<style>
    .writing-vertical-rl { writing-mode: vertical-rl; }
    [x-cloak] { display: none !important; }
</style>

@endsection