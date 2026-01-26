<header x-data="{ mobileMenuOpen: false, toolsOpen: false }" 
        :class="{ 
            'bg-brand-secondary shadow-lg': true
        }"
        class="fixed top-0 w-full z-50 transition-all duration-500 border-b border-brand-sand/10 py-4">
    
    <div class="container mx-auto px-6">
        <div class="flex items-center justify-between">
            
            {{-- 1. LOGO --}}
            <a href="{{ route('home') }}" class="relative z-50 group block" @click="mobileMenuOpen = false">
                <img src="{{ asset('img/Ativo_5.png') }}" 
                     alt="Porthouse Private Real Estate" 
                     :class="{ 'scale-90': mobileMenuOpen }"
                     class="h-10 md:h-12 w-auto object-contain transition-all duration-500 group-hover:opacity-80 brightness-0 invert">
            </a>

            {{-- 2. DESKTOP MENU --}}
            <nav class="hidden lg:flex items-center gap-12">
                <a href="{{ route('home') }}" class="text-[10px] font-bold uppercase tracking-[0.2em] text-white hover:text-brand-sand transition-colors relative group">
                    {{ __('header.menu.home') }}
                    <span class="absolute -bottom-2 left-1/2 w-0 h-[1px] bg-brand-sand group-hover:w-full group-hover:left-0 transition-all duration-300"></span>
                </a>

                <a href="{{ route('portfolio') }}" class="text-[10px] font-bold uppercase tracking-[0.2em] text-white hover:text-brand-sand transition-colors relative group">
                    {{ __('header.menu.collection') }}
                    <span class="absolute -bottom-2 left-1/2 w-0 h-[1px] bg-brand-sand group-hover:w-full group-hover:left-0 transition-all duration-300"></span>
                </a>
                
                {{-- Dropdown Tools --}}
                <div class="relative group" @mouseenter="toolsOpen = true" @mouseleave="toolsOpen = false">
                    <button class="text-[10px] font-bold uppercase tracking-[0.2em] text-white hover:text-brand-sand transition-colors flex items-center gap-2 focus:outline-none py-2">
                        {{ __('header.menu.market_intelligence') }}
                        <svg class="w-3 h-3 text-brand-sand/50 transition-transform duration-300" :class="{'rotate-180': toolsOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    
                    <div x-show="toolsOpen" 
                         x-cloak
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-200"
                         class="absolute top-full left-1/2 -translate-x-1/2 pt-4 w-64">
                        
                        <div class="bg-brand-secondary border border-brand-sand/20 shadow-2xl p-0 backdrop-blur-xl">
                            <a href="{{ route('tools.credit') }}" class="block px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-white hover:bg-brand-sand hover:text-brand-secondary transition-colors border-b border-brand-sand/10">
                                {{ __('header.menu.credit_simulator') }}
                            </a>
                            <a href="{{ route('tools.imt') }}" class="block px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-white hover:bg-brand-sand hover:text-brand-secondary transition-colors border-b border-brand-sand/10">
                                {{ __('header.menu.imt_simulator') }}
                            </a>
                            <a href="{{ route('tools.gains') }}" class="block px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-white hover:bg-brand-sand hover:text-brand-secondary transition-colors">
                                {{ __('header.menu.gains_simulator') }}
                            </a>
                        </div>
                    </div>
                </div>

                <a href="{{ route('about') }}" class="text-[10px] font-bold uppercase tracking-[0.2em] text-white hover:text-brand-sand transition-colors relative group">
                    {{ __('header.menu.about') }}
                    <span class="absolute -bottom-2 left-1/2 w-0 h-[1px] bg-brand-sand group-hover:w-full group-hover:left-0 transition-all duration-300"></span>
                </a>
                
                {{-- Separador Fino --}}
                <div class="h-4 w-px bg-white/20"></div>

                {{-- CTA Outline --}}
                <a href="{{ route('contact') }}" 
                   class="px-6 py-2 border border-brand-sand text-brand-sand text-[9px] font-bold uppercase tracking-[0.2em] hover:bg-brand-sand hover:text-brand-secondary transition-all duration-500">
                    {{ __('header.menu.schedule') }}
                </a>

                {{-- Idiomas --}}
                <div class="flex items-center gap-3 text-[10px] font-bold uppercase tracking-widest text-white">
                    <a href="{{ route('locale', 'pt') }}" class="{{ app()->getLocale() == 'pt' ? 'text-brand-sand border-b border-brand-sand' : 'text-white/30 hover:text-white' }} transition-colors pb-0.5">PT</a>
                    <a href="{{ route('locale', 'en') }}" class="{{ app()->getLocale() == 'en' ? 'text-brand-sand border-b border-brand-sand' : 'text-white/30 hover:text-white' }} transition-colors pb-0.5">EN</a>
                </div>
            </nav>

            {{-- 3. MOBILE MENU BUTTON --}}
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden text-brand-sand z-50 focus:outline-none p-2 group">
                <div class="w-6 flex flex-col items-end justify-center gap-[5px]">
                    <span class="block w-6 h-px bg-current transition-all duration-300" :class="{'rotate-45 translate-y-[6px]': mobileMenuOpen}"></span>
                    <span class="block w-4 h-px bg-current transition-all duration-300" :class="{'opacity-0': mobileMenuOpen, 'group-hover:w-6': !mobileMenuOpen}"></span>
                    <span class="block w-6 h-px bg-current transition-all duration-300" :class="{'-rotate-45 -translate-y-[6px]': mobileMenuOpen}"></span>
                </div>
            </button>
        </div>
    </div>

    {{-- 4. MOBILE MENU OVERLAY --}}
    <div x-show="mobileMenuOpen" 
         x-cloak
         x-transition:enter="transition ease-out duration-700"
         x-transition:enter-start="opacity-0 translate-y-full"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-500"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-full"
         class="fixed inset-0 bg-brand-secondary z-40 flex flex-col justify-center overflow-hidden">
        
        <div class="absolute inset-0 flex justify-between px-10 opacity-10 pointer-events-none">
            <div class="w-px h-full bg-brand-sand"></div>
            <div class="w-px h-full bg-brand-sand"></div>
        </div>

        <div class="container mx-auto px-6 relative z-10 text-center">
            <nav class="flex flex-col space-y-8">
                <a href="{{ route('home') }}" @click="mobileMenuOpen = false" class="text-4xl md:text-5xl font-serif text-brand-sand hover:text-white transition-colors duration-500 group">
                    <span class="text-brand-primary opacity-0 group-hover:opacity-100 transition-opacity duration-300 text-2xl align-top mr-2">01.</span>
                    {{ __('header.menu.home') }}
                </a>
                <a href="{{ route('portfolio') }}" @click="mobileMenuOpen = false" class="text-4xl md:text-5xl font-serif text-brand-sand hover:text-white transition-colors duration-500 group">
                    <span class="text-brand-primary opacity-0 group-hover:opacity-100 transition-opacity duration-300 text-2xl align-top mr-2">02.</span>
                    {{ __('header.menu.collection') }}
                </a>
                <a href="{{ route('about') }}" @click="mobileMenuOpen = false" class="text-4xl md:text-5xl font-serif text-brand-sand hover:text-white transition-colors duration-500 group">
                    <span class="text-brand-primary opacity-0 group-hover:opacity-100 transition-opacity duration-300 text-2xl align-top mr-2">03.</span>
                    {{ __('header.menu.about') }}
                </a>
                
                <div class="py-8 border-t border-brand-sand/10 border-b border-brand-sand/10 w-full max-w-xs mx-auto mt-8">
                    <p class="text-[9px] uppercase tracking-[0.3em] text-brand-primary mb-4">{{ __('header.menu.tools_label') }}</p>
                    <div class="flex flex-col gap-3">
                        <a href="{{ route('tools.credit') }}" class="text-sm font-light text-white hover:text-brand-sand tracking-widest uppercase">{{ __('header.menu.credit_simulator') }}</a>
                        <a href="{{ route('tools.imt') }}" class="text-sm font-light text-white hover:text-brand-sand tracking-widest uppercase">{{ __('header.menu.imt_simulator') }}</a>
                    </div>
                </div>

                <div class="mt-8">
                    <a href="{{ route('contact') }}" class="inline-block px-12 py-4 border border-brand-sand text-brand-sand uppercase text-xs font-bold tracking-widest hover:bg-brand-sand hover:text-brand-secondary transition-all">
                        {{ __('header.menu.schedule') }}
                    </a>
                </div>
            </nav>
        </div>
    </div>
</header>