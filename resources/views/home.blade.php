@extends('layouts.app')

@section('title', __('home.meta.title') . ' | Porthouse Private Office')

@section('content')

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

    {{-- 1. INTRO / LOADING --}}
    <div x-show="!loaded" 
         x-transition:leave="transition ease-in-out duration-1000"
         x-transition:leave-start="transform translate-y-0"
         x-transition:leave-end="transform -translate-y-full"
         class="fixed inset-0 z-[100] bg-white flex items-center justify-center">
        
        <div class="text-center" x-transition:leave="transition duration-500 opacity-0">
            <img src="{{ asset('img/Ativo_5.png') }}" alt="Porthouse" class="h-24 w-auto object-contain opacity-80 mb-6 animate-pulse">
            <p class="text-brand-secondary font-sans font-light text-xs tracking-[0.4em] uppercase">Private Office</p>
        </div>
    </div>

    {{-- 2. HERO SECTION --}}
    <section class="relative h-screen w-full overflow-hidden flex items-center justify-center">
        
        {{-- Video BG --}}
        <video id="heroVideo" autoplay muted loop playsinline 
               poster="{{ asset('img/porto_dark.jpeg') }}"
               class="absolute inset-0 w-full h-full object-cover z-0">
            <source src="{{ asset('video/hero.mp4') }}" type="video/mp4">
        </video>

        <div class="absolute inset-0 bg-black/30 z-10"></div>

        {{-- TOP BAR: Login Button --}}
        <div class="absolute top-0 left-0 w-full z-30 p-8 flex justify-between items-start">
            <div class="w-10"></div> {{-- Spacer --}}
            
            <a href="{{ route('login') }}" 
               class="px-8 py-3 border border-white/30 backdrop-blur-sm bg-white/5 hover:bg-white hover:text-brand-secondary text-white text-xs font-bold uppercase tracking-[0.2em] transition-all duration-500 rounded-sm">
                Member Login
            </a>
        </div>

        {{-- Center Play --}}
        <div class="relative z-20 text-center text-white" data-aos="fade-up" data-aos-duration="1500">
            <button @click="toggleVideo()" class="group flex flex-col items-center gap-6 focus:outline-none">
                <div class="w-24 h-24 rounded-full border border-white/40 backdrop-blur-md flex items-center justify-center group-hover:bg-white group-hover:text-brand-secondary transition-all duration-500 transform group-hover:scale-110">
                    <span x-show="!videoPlaying" x-cloak class="ml-1 text-2xl">▶</span>
                    <span x-show="videoPlaying" class="block w-3 h-3 bg-current rounded-sm"></span>
                </div>
            </button>
        </div>

        {{-- BOTTOM: Discover Button --}}
        <div class="absolute bottom-12 left-1/2 -translate-x-1/2 z-20 flex flex-col items-center gap-3">
            <a href="#private-collection" class="group flex flex-col items-center gap-2 text-white/80 hover:text-white transition-colors cursor-pointer">
                <span class="text-[10px] uppercase tracking-[0.4em] font-light group-hover:tracking-[0.5em] transition-all duration-500">
                    Discover
                </span>
                <svg class="w-6 h-6 animate-bounce mt-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                </svg>
            </a>
        </div>
    </section>

    {{-- 3. PRIVATE COLLECTION --}}
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

            {{-- Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-16">
                @foreach($properties as $property)
                    <div class="group cursor-pointer" data-aos="fade-up">
                        <a href="{{ route('properties.show', $property->slug ?? $property->id) }}" class="block">
                            <div class="relative overflow-hidden aspect-[4/5] bg-gray-200 mb-6">
                                <img src="{{ $property->cover_image ? asset('storage/' . $property->cover_image) : asset('img/placeholder.jpg') }}" 
                                     class="w-full h-full object-cover transition-transform duration-[1.2s] ease-out group-hover:scale-105 filter grayscale-[20%] group-hover:grayscale-0"
                                     alt="{{ $property->title }}">
                                
                                <div class="absolute top-0 right-0 bg-white/90 backdrop-blur text-brand-secondary px-4 py-2 text-sm font-serif">
                                    {{ number_format($property->price, 0, ',', '.') }} €
                                </div>

                                {{-- Badge Off-Market se aplicável --}}
                                @if($property->visibility === 'off_market')
                                    <div class="absolute top-0 left-0 bg-brand-secondary text-white px-3 py-1 text-[10px] uppercase tracking-widest">
                                        Private Access
                                    </div>
                                @endif
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
        </div>
    </section>

    {{-- 4. NOVO: OFF-MARKET ACCESS CTA --}}
    <section class="py-24 bg-[#1a1a1a] text-white relative overflow-hidden">
        {{-- Background Decoration --}}
        <div class="absolute top-0 right-0 w-1/2 h-full bg-brand-secondary/5 skew-x-12"></div>

        <div class="container mx-auto px-6 relative z-10">
            <div class="max-w-4xl mx-auto text-center">
                <span class="inline-block border border-white/20 px-4 py-1 rounded-full text-[10px] uppercase tracking-[0.3em] mb-8 text-neutral-300">
                    Members Only
                </span>
                <h2 class="font-serif text-4xl md:text-6xl mb-6">
                    Acesso Off-Market
                </h2>
                <p class="font-light text-neutral-400 text-lg mb-10 max-w-xl mx-auto leading-relaxed">
                    Obtenha acesso exclusivo a propriedades que não estão listadas publicamente. Entre na sua conta ou solicite acesso ao nosso portfólio privado.
                </p>
                
                <div class="flex flex-col sm:flex-row gap-6 justify-center">
                    <a href="{{ route('login') }}" class="px-10 py-4 bg-white text-brand-text font-bold uppercase tracking-widest hover:bg-neutral-200 transition-colors min-w-[200px]">
                        Acessar Conta
                    </a>
                    <a href="{{ route('contact') }}" class="px-10 py-4 border border-white/30 text-white font-bold uppercase tracking-widest hover:bg-white/10 transition-colors min-w-[200px]">
                        Solicitar Convite
                    </a>
                </div>
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
                <div class="pt-8 md:pt-0 md:px-8 text-center group" data-aos="fade-up">
                    <span class="block font-serif text-4xl text-neutral-200 mb-6 group-hover:text-brand-primary transition-colors">01</span>
                    <h4 class="text-xl font-serif text-brand-text mb-4">{{ __('home.services.1_title') }}</h4>
                    <p class="font-light text-sm text-neutral-500 leading-relaxed">{{ __('home.services.1_desc') }}</p>
                </div>
                <div class="pt-8 md:pt-0 md:px-8 text-center group" data-aos="fade-up" data-aos-delay="100">
                    <span class="block font-serif text-4xl text-neutral-200 mb-6 group-hover:text-brand-primary transition-colors">02</span>
                    <h4 class="text-xl font-serif text-brand-text mb-4">{{ __('home.services.2_title') }}</h4>
                    <p class="font-light text-sm text-neutral-500 leading-relaxed">{{ __('home.services.2_desc') }}</p>
                </div>
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