@extends('layouts.app')

@section('title', __('contact.meta.title') . ' | Porthouse Private Office')

@section('content')

{{-- HERO SECTION --}}
<div class="bg-brand-secondary text-white py-32 md:py-40 text-center relative overflow-hidden">
    {{-- Textura Sutil --}}
    <div class="absolute inset-0 opacity-5 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
    
    {{-- Elemento Decorativo --}}
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] border border-white/5 rounded-full pointer-events-none"></div>

    <div class="container mx-auto px-6 relative z-10" data-aos="fade-up">
        <p class="text-brand-sand font-mono text-xs uppercase tracking-[0.4em] mb-6 flex items-center justify-center gap-3">
            <span class="w-8 h-[1px] bg-brand-sand"></span>
            {{ __('contact.hero.channels') }}
            <span class="w-8 h-[1px] bg-brand-sand"></span>
        </p>
        <h1 class="text-5xl md:text-7xl font-serif leading-tight text-white mb-8">
            {{ __('contact.hero.title') }}
        </h1>
        <p class="text-white/60 font-light max-w-2xl mx-auto text-lg leading-relaxed">
            {{ __('contact.hero.subtitle') }}
        </p>
    </div>
</div>

<section class="py-24 bg-brand-background relative">
    <div class="container mx-auto px-6 md:px-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 lg:gap-24">
            
            {{-- COLUNA 1: INFORMAÇÕES --}}
            <div class="space-y-12" data-aos="fade-right">
                <div>
                    <h3 class="text-3xl font-serif text-brand-secondary mb-6">{{ __('contact.info.title') }}</h3>
                    <p class="text-gray-500 font-light leading-relaxed mb-10 text-justify border-l-2 border-brand-sand pl-4">
                        {{ __('contact.info.description') }}
                    </p>
                    
                    <div class="space-y-8">
                        {{-- Escritório --}}
                        <div class="flex items-start gap-6 group">
                            <div class="p-4 bg-white border border-brand-sand/20 shadow-sm text-brand-primary group-hover:bg-brand-primary group-hover:text-white transition-colors duration-500">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold uppercase tracking-widest text-brand-secondary mb-2">{{ __('contact.info.office_label') }}</h4>
                                <p class="text-gray-600 font-light text-sm leading-relaxed">
                                    Rua Manuel Marques nº8, 7.ºD<br>
                                    1750-171 Lisboa, Portugal
                                </p>
                            </div>
                        </div>

                        {{-- Telefone --}}
                        <div class="flex items-start gap-6 group">
                            <div class="p-4 bg-white border border-brand-sand/20 shadow-sm text-brand-primary group-hover:bg-brand-primary group-hover:text-white transition-colors duration-500">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold uppercase tracking-widest text-brand-secondary mb-2">{{ __('contact.info.phone_label') }}</h4>
                                <a href="tel:+351925587906" class="block text-gray-600 font-light cursor-pointer hover:text-brand-primary transition text-lg font-serif">
                                    925 587 906
                                </a>
                                <p class="text-[10px] text-gray-400 mt-1 uppercase tracking-wider">
                                    {{ __('contact.info.schedule') }}
                                </p>
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="flex items-start gap-6 group">
                            <div class="p-4 bg-white border border-brand-sand/20 shadow-sm text-brand-primary group-hover:bg-brand-primary group-hover:text-white transition-colors duration-500">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold uppercase tracking-widest text-brand-secondary mb-2">{{ __('contact.info.email_label') }}</h4>
                                <a href="mailto:info@porthouserealestate.com" class="block text-gray-600 font-light cursor-pointer hover:text-brand-primary transition border-b border-transparent hover:border-brand-primary w-max">
                                    info@porthouserealestate.com
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Mapa --}}
                <div class="w-full h-64 bg-gray-200 relative overflow-hidden shadow-lg group">
                    <iframe 
                        src="https://maps.google.com/maps?q=Rua+Manuel+Marques+8,+1750-171+Lisboa&t=&z=15&ie=UTF8&iwloc=&output=embed" 
                        width="100%" 
                        height="100%" 
                        style="border:0; filter: grayscale(100%) contrast(1.2);" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade"
                        class="group-hover:grayscale-0 transition-all duration-1000">
                    </iframe>
                </div>
            </div>

            {{-- COLUNA 2: FORMULÁRIO --}}
            <div class="bg-white p-8 md:p-12 shadow-2xl border-t-8 border-brand-primary relative" data-aos="fade-left">
                
                {{-- Selo Decorativo (Alterado para PH) --}}
                <div class="absolute top-0 right-0 p-6 opacity-10">
                    <span class="font-serif text-6xl text-brand-primary">PH</span>
                </div>

                <h3 class="text-3xl font-serif text-brand-secondary mb-2">{{ __('contact.form.title') }}</h3>
                <p class="text-gray-400 text-xs mb-8 uppercase tracking-widest">{{ __('contact.form.response_time') }}</p>
                
                @if(session('success'))
                    <div class="mb-8 p-4 bg-brand-background border-l-4 border-brand-secondary text-brand-secondary text-sm flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('contact.send') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="group relative">
                            <input type="text" name="name" required placeholder=" " 
                                   class="peer w-full bg-gray-50 border-0 border-b-2 border-gray-100 px-3 py-3 focus:ring-0 focus:border-brand-primary transition-colors placeholder-transparent text-brand-secondary">
                            <label class="absolute left-3 top-3 text-xs text-gray-400 uppercase tracking-widest transition-all peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-xs peer-placeholder-shown:text-gray-400 peer-focus:-top-2 peer-focus:text-[10px] peer-focus:text-brand-primary">{{ __('contact.form.name') }}</label>
                        </div>
                        <div class="group relative">
                            <input type="tel" name="phone" required placeholder=" " 
                                   class="peer w-full bg-gray-50 border-0 border-b-2 border-gray-100 px-3 py-3 focus:ring-0 focus:border-brand-primary transition-colors placeholder-transparent text-brand-secondary">
                            <label class="absolute left-3 top-3 text-xs text-gray-400 uppercase tracking-widest transition-all peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-xs peer-placeholder-shown:text-gray-400 peer-focus:-top-2 peer-focus:text-[10px] peer-focus:text-brand-primary">{{ __('contact.form.phone') }}</label>
                        </div>
                    </div>

                    <div class="group relative">
                        <input type="email" name="email" required placeholder=" " 
                               class="peer w-full bg-gray-50 border-0 border-b-2 border-gray-100 px-3 py-3 focus:ring-0 focus:border-brand-primary transition-colors placeholder-transparent text-brand-secondary">
                        <label class="absolute left-3 top-3 text-xs text-gray-400 uppercase tracking-widest transition-all peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-xs peer-placeholder-shown:text-gray-400 peer-focus:-top-2 peer-focus:text-[10px] peer-focus:text-brand-primary">{{ __('contact.form.email') }}</label>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="group relative">
                            <select name="subject" class="w-full bg-gray-50 border-0 border-b-2 border-gray-100 px-3 py-3 focus:ring-0 focus:border-brand-primary transition-colors text-brand-secondary text-sm appearance-none">
                                <option value="" disabled selected>{{ __('contact.form.subject_default') }}</option>
                                <option value="Comprar Imóvel">{{ __('contact.form.subject_buy') }}</option>
                                <option value="Vender Imóvel">{{ __('contact.form.subject_sell') }}</option>
                                <option value="Investimento">{{ __('contact.form.subject_invest') }}</option>
                                <option value="Parcerias">{{ __('contact.form.subject_partnerships') }}</option>
                            </select>
                        </div>
                        <div class="group relative">
                            <select name="timeline" class="w-full bg-gray-50 border-0 border-b-2 border-gray-100 px-3 py-3 focus:ring-0 focus:border-brand-primary transition-colors text-brand-secondary text-sm appearance-none">
                                <option value="" disabled selected>{{ __('contact.form.timeline_default') }}</option>
                                <option value="Imediato">{{ __('contact.form.timeline_immediate') }}</option>
                                <option value="3 meses">{{ __('contact.form.timeline_3_months') }}</option>
                                <option value="6 meses">{{ __('contact.form.timeline_6_months') }}</option>
                                <option value="+6 meses">{{ __('contact.form.timeline_long_term') }}</option>
                            </select>
                        </div>
                    </div>

                    {{-- Campos Ocultos --}}
                    <input type="hidden" name="goal" value="Contacto Geral">
                    <input type="hidden" name="sell_to_buy" value="Não Aplicável">

                    <div class="group relative">
                        <textarea name="message" rows="4" required placeholder=" " 
                                  class="peer w-full bg-gray-50 border-0 border-b-2 border-gray-100 px-3 py-3 focus:ring-0 focus:border-brand-primary transition-colors resize-none placeholder-transparent text-brand-secondary"></textarea>
                        <label class="absolute left-3 top-3 text-xs text-gray-400 uppercase tracking-widest transition-all peer-placeholder-shown:top-3.5 peer-placeholder-shown:text-xs peer-placeholder-shown:text-gray-400 peer-focus:-top-2 peer-focus:text-[10px] peer-focus:text-brand-primary">{{ __('contact.form.message') }}</label>
                    </div>

                    <div class="flex items-start gap-3">
                        <input type="checkbox" name="privacy_check" required class="mt-1 text-brand-primary focus:ring-brand-primary border-gray-300 rounded-sm w-4 h-4">
                        <span class="text-[10px] text-gray-400 leading-tight">
                            {{ __('contact.form.privacy_consent') }} <a href="{{ route('terms') }}" class="underline hover:text-brand-primary">{{ __('home.form.privacy_policy') }}</a>.
                        </span>
                    </div>

                    <button type="submit" class="w-full bg-brand-primary text-white font-bold py-5 hover:bg-brand-secondary transition-all duration-300 uppercase tracking-[0.2em] text-xs shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        {{ __('contact.form.submit_btn') }}
                    </button>
                </form>
            </div>

        </div>
    </div>
</section>

@endsection