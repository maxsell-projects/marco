@extends('layouts.app')

@section('title', __('home.meta.title') . ' | Porthouse Private Office')

@section('content')

{{-- 1. HERO SECTION --}}
<section class="relative h-screen w-full overflow-hidden bg-brand-secondary text-brand-sand flex flex-col justify-between pt-32 pb-10">
    
    {{-- Background --}}
    <div class="absolute inset-0 z-0">
        <div class="absolute inset-0 bg-brand-secondary/40 z-10"></div>
        <img src="{{ asset('img/porto_dark.jpeg') }}" 
             class="w-full h-full object-cover opacity-60 animate-[kenburns_20s_infinite_alternate]" 
             alt="Porthouse Private Real Estate">
    </div>

    {{-- Conteúdo Superior --}}
    <div class="container mx-auto px-6 relative z-20 flex justify-between items-start">
        <div class="hidden md:block">
            <p class="text-[10px] font-bold uppercase tracking-[0.4em] text-white writing-vertical-rl rotate-180 border-l border-white/20 pl-4 h-32">
                {{ __('home.hero.locations') }}
            </p>
        </div>
        
        <div class="text-right flex flex-col items-end">
            {{-- LOGO GRANDE NA HERO (Tamanho Reduzido) --}}
            <img src="{{ asset('img/Ativo_5.png') }}" 
                 alt="Porthouse Logo" 
                 class="h-16 md:h-32 w-auto object-contain mix-blend-overlay opacity-90 mb-4"
                 data-aos="fade-left" data-aos-duration="1500">
                 
            {{-- Nome (Texto) Removido --}}
        </div>
    </div>

    {{-- Conteúdo Inferior --}}
    <div class="container mx-auto px-6 relative z-20 mt-auto">
        <div class="flex flex-col md:flex-row items-end justify-between gap-8 border-t border-brand-sand/20 pt-8">
            <div class="max-w-xl" data-aos="fade-up" data-aos-delay="500">
                <h2 class="text-2xl md:text-3xl font-light text-white leading-snug mb-6">
                    {{ __('home.hero.title_part1') }} <br>
                    <span class="font-serif italic text-brand-sand">{{ __('home.hero.title_part2') }}</span>
                </h2>
                <div class="flex gap-4">
                    <a href="#private-collection" class="px-8 py-3 bg-brand-primary text-white font-bold text-xs uppercase tracking-widest hover:bg-white hover:text-brand-secondary transition-all duration-500">
                        {{ __('home.hero.cta_collection') }}
                    </a>
                    <a href="#contact-focus" class="px-8 py-3 border border-white/30 text-white font-bold text-xs uppercase tracking-widest hover:border-brand-sand hover:text-brand-sand transition-all duration-300">
                        {{ __('home.hero.cta_office') }}
                    </a>
                </div>
            </div>

            {{-- Scroll Hint --}}
            <div class="animate-bounce hidden md:block">
                <svg class="w-6 h-6 text-brand-sand" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
            </div>
        </div>
    </div>
</section>

{{-- 2. THE MANIFESTO --}}
<section class="py-24 md:py-40 bg-brand-background text-brand-secondary relative overflow-hidden">
    <span class="absolute -left-20 top-20 text-[20rem] font-serif text-brand-sand/10 leading-none select-none pointer-events-none">&</span>

    <div class="container mx-auto px-6 relative z-10">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-12 items-center">
            <div class="md:col-span-5 relative">
                <div class="aspect-[4/5] bg-gray-200 relative overflow-hidden shadow-2xl" data-aos="fade-right">
                    {{-- FOTO DO MARCO --}}
                    <img src="{{ asset('img/marco.jpg') }}" alt="Marco Moura - Founder" class="w-full h-full object-cover grayscale hover:grayscale-0 transition-all duration-1000">
                    
                    {{-- Badge --}}
                    <div class="absolute bottom-8 -right-8 bg-brand-primary text-white p-6 md:p-8 max-w-[200px] shadow-2xl" data-aos="zoom-in" data-aos-delay="400">
                        <p class="font-serif text-2xl italic leading-none mb-2">15+</p>
                        <p class="text-[10px] uppercase tracking-widest leading-tight opacity-80">{{ __('home.manifesto.experience_badge') }}</p>
                    </div>
                </div>
            </div>
            
            <div class="md:col-span-1"></div>

            <div class="md:col-span-6" data-aos="fade-up">
                <h3 class="text-xs font-bold text-brand-primary uppercase tracking-[0.3em] mb-4">{{ __('home.manifesto.subtitle') }}</h3>
                <p class="font-serif text-4xl md:text-5xl leading-tight mb-8">
                    "{{ __('home.manifesto.quote_part1') }}<br> 
                    <span class="text-brand-primary">{{ __('home.manifesto.quote_part2') }}</span>"
                </p>
                <div class="prose prose-lg text-brand-text font-light">
                    <p>{{ __('home.manifesto.text_paragraph1') }}</p>
                    <p class="mt-4">{{ __('home.manifesto.text_paragraph2') }}</p>
                </div>
                
                <div class="mt-12 flex items-center gap-4">
                    <span class="h-[1px] w-12 bg-brand-primary"></span>
                    <span class="font-signature text-4xl text-brand-primary">Marco Moura</span>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- 3. INTERACTIVE SLIDER --}}
<section id="private-collection" class="py-32 bg-brand-secondary text-white overflow-hidden">
    <div class="container mx-auto px-6 mb-16 flex flex-col md:flex-row justify-between items-end">
        <div>
            <h2 class="font-serif text-5xl md:text-7xl text-brand-sand">{{ __('home.collection.title') }}</h2>
            <p class="text-white/60 mt-4 max-w-md font-light">
                {{ __('home.collection.subtitle') }}
            </p>
        </div>
        
        <div class="flex gap-4 mt-8 md:mt-0">
            <button class="w-12 h-12 rounded-full border border-white/20 flex items-center justify-center hover:bg-brand-primary hover:border-brand-primary transition-all">←</button>
            <button class="w-12 h-12 rounded-full border border-white/20 flex items-center justify-center hover:bg-brand-primary hover:border-brand-primary transition-all">→</button>
        </div>
    </div>

    {{-- SCROLL SNAP --}}
    <div class="pl-6 md:pl-[max(2rem,calc((100vw-1280px)/2))] overflow-x-auto pb-12 scrollbar-hide flex gap-8 snap-x snap-mandatory">
        
        @foreach($properties as $property)
        <div class="snap-center shrink-0 w-[85vw] md:w-[400px] group relative" data-aos="fade-up">
            <a href="{{ route('properties.show', $property->slug) }}" class="block relative aspect-[3/4] overflow-hidden bg-gray-800">
                <div class="absolute inset-0 bg-brand-primary/20 opacity-0 group-hover:opacity-100 transition-opacity z-10 duration-500 mix-blend-multiply"></div>
                
                <img src="{{ $property->cover_image ? asset('storage/' . $property->cover_image) : asset('img/placeholder.jpg') }}" 
                     loading="lazy"
                     class="w-full h-full object-cover transition-transform duration-[1.5s] group-hover:scale-110 grayscale-[30%] group-hover:grayscale-0">
                
                <div class="absolute top-6 right-6 bg-white/10 backdrop-blur-md px-4 py-2 border border-white/20">
                    <span class="font-serif text-lg text-brand-sand">{{ number_format($property->price, 0, ',', '.') }} €</span>
                </div>

                <div class="absolute inset-x-0 bottom-0 p-8 transform translate-y-4 group-hover:translate-y-0 opacity-0 group-hover:opacity-100 transition-all duration-500 z-20">
                    <span class="inline-block px-3 py-1 bg-brand-primary text-white text-[10px] uppercase tracking-widest mb-3">
                        {{ $property->type }}
                    </span>
                    <button class="flex items-center gap-2 text-xs uppercase tracking-widest border-b border-white pb-1">
                        {{ __('home.collection.view_details') }} <span class="group-hover:translate-x-2 transition-transform">→</span>
                    </button>
                </div>
            </a>

            <div class="mt-6">
                <p class="text-xs font-bold text-brand-sand uppercase tracking-widest mb-1">{{ $property->location }}</p>
                <h3 class="font-serif text-2xl leading-tight group-hover:text-brand-primary transition-colors">
                    <a href="{{ route('properties.show', $property->slug) }}">{{ $property->title }}</a>
                </h3>
                <p class="text-white/40 text-sm mt-2 font-mono">
                    {{ $property->bedrooms }} {{ __('home.collection.bedrooms') }} • {{ $property->area_gross }} m²
                </p>
            </div>
        </div>
        @endforeach

        {{-- "View All" Card --}}
        <div class="snap-center shrink-0 w-[85vw] md:w-[300px] flex items-center justify-center bg-brand-primary/10 border border-white/10 aspect-[3/4] hover:bg-brand-primary transition-colors group cursor-pointer">
            <a href="{{ route('portfolio') }}" class="text-center">
                <span class="block text-4xl mb-4 group-hover:rotate-90 transition-transform duration-500">→</span>
                <span class="font-serif text-2xl italic text-brand-sand">{!! __('home.collection.explore_all') !!}</span>
            </a>
        </div>
    </div>
</section>

{{-- 4. SERVICES --}}
<section class="py-32 bg-white text-brand-text">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 divide-y md:divide-y-0 md:divide-x divide-gray-100">
            
            {{-- Pillar 1 --}}
            <div class="px-6 py-8 hover:bg-brand-background transition-colors duration-500 group">
                <span class="text-brand-primary text-5xl font-serif block mb-6 opacity-30 group-hover:opacity-100 transition-opacity">01.</span>
                <h3 class="text-lg font-bold uppercase tracking-widest mb-4">{{ __('home.services.1_title') }}</h3>
                <p class="font-light text-gray-500 leading-relaxed">{{ __('home.services.1_desc') }}</p>
            </div>

            {{-- Pillar 2 --}}
            <div class="px-6 py-8 hover:bg-brand-background transition-colors duration-500 group">
                <span class="text-brand-primary text-5xl font-serif block mb-6 opacity-30 group-hover:opacity-100 transition-opacity">02.</span>
                <h3 class="text-lg font-bold uppercase tracking-widest mb-4">{{ __('home.services.2_title') }}</h3>
                <p class="font-light text-gray-500 leading-relaxed">{{ __('home.services.2_desc') }}</p>
            </div>

            {{-- Pillar 3 --}}
            <div class="px-6 py-8 hover:bg-brand-background transition-colors duration-500 group">
                <span class="text-brand-primary text-5xl font-serif block mb-6 opacity-30 group-hover:opacity-100 transition-opacity">03.</span>
                <h3 class="text-lg font-bold uppercase tracking-widest mb-4">{{ __('home.services.3_title') }}</h3>
                <p class="font-light text-gray-500 leading-relaxed">{{ __('home.services.3_desc') }}</p>
            </div>

        </div>
    </div>
</section>

{{-- 5. CONTACT FORM --}}
<section id="contact-focus" class="relative py-32 bg-brand-primary overflow-hidden">
    <div class="absolute top-0 right-0 w-2/3 h-full bg-[#962235] skew-x-12 transform origin-top-right mix-blend-multiply"></div>
    
    <div class="container mx-auto px-6 relative z-10">
        <div class="max-w-4xl mx-auto">
            
            <div class="text-center mb-16">
                <p class="text-brand-sand font-mono text-xs uppercase tracking-[0.4em] mb-4">{{ __('home.contact.subtitle') }}</p>
                <h2 class="font-serif text-5xl md:text-6xl text-white mb-6">{{ __('home.contact.title') }}</h2>
                <p class="text-white/70 font-light max-w-lg mx-auto">
                    {{ __('home.contact.description') }}
                    <span class="italic text-brand-sand">{{ __('home.contact.privacy_note') }}</span>
                </p>
            </div>

            <div class="bg-white/5 backdrop-blur-lg border border-white/10 p-8 md:p-12 shadow-2xl">
                <form action="{{ route('contact.send') }}" method="POST" class="space-y-8">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="relative">
                            <input type="text" name="name" required placeholder="{{ __('home.form.name') }}" 
                                   class="w-full bg-transparent border-b border-white/30 py-4 text-white placeholder-white/30 focus:outline-none focus:border-brand-sand transition-colors font-light">
                        </div>
                        <div class="relative">
                            <input type="email" name="email" required placeholder="{{ __('home.form.email') }}" 
                                   class="w-full bg-transparent border-b border-white/30 py-4 text-white placeholder-white/30 focus:outline-none focus:border-brand-sand transition-colors font-light">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="relative">
                            <input type="tel" name="phone" required placeholder="{{ __('home.form.phone') }}" 
                                   class="w-full bg-transparent border-b border-white/30 py-4 text-white placeholder-white/30 focus:outline-none focus:border-brand-sand transition-colors font-light">
                        </div>
                        <div class="relative">
                            <select name="goal" required class="w-full bg-transparent border-b border-white/30 py-4 text-white focus:outline-none focus:border-brand-sand transition-colors font-light appearance-none">
                                <option value="" class="text-black">{{ __('home.form.goal_default') }}</option>
                                <option value="Comprar" class="text-black">{{ __('home.form.goal_buy') }}</option>
                                <option value="Vender" class="text-black">{{ __('home.form.goal_sell') }}</option>
                                <option value="Investir" class="text-black">{{ __('home.form.goal_invest') }}</option>
                            </select>
                        </div>
                    </div>

                    {{-- Hidden fields atualizados para Porthouse --}}
                    <input type="hidden" name="timeline" value="Não especificado (Homepage)">
                    <input type="hidden" name="sell_to_buy" value="Não especificado">
                    <input type="hidden" name="subject" value="Novo Contacto via Porthouse Homepage">

                    <div class="flex items-start gap-3 mt-4">
                        <input type="checkbox" name="privacy_check" id="privacy_check" required 
                               class="mt-1 bg-transparent border-white/40 rounded-sm text-brand-sand focus:ring-0">
                        <label for="privacy_check" class="text-xs text-white/50 font-light">
                            {{ __('home.form.accept') }} <a href="#" class="underline hover:text-white">{{ __('home.form.privacy_policy') }}</a>. 
                            {{ __('home.form.privacy_disclaimer') }}
                        </label>
                    </div>

                    <div class="text-center pt-8">
                        <button type="submit" class="group relative px-12 py-5 bg-brand-sand text-brand-primary font-bold uppercase tracking-widest overflow-hidden transition-all hover:scale-105 shadow-xl">
                            <span class="relative z-10">{{ __('home.form.submit_btn') }}</span>
                            <div class="absolute inset-0 bg-white transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-500"></div>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<style>
    @keyframes kenburns {
        0% { transform: scale(1); }
        100% { transform: scale(1.1); }
    }
    .writing-vertical-rl { writing-mode: vertical-rl; }
</style>

@endsection