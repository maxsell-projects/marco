<header x-data="{ mobileMenuOpen: false, toolsOpen: false }" 
        x-init="$watch('mobileMenuOpen', value => { 
            if(value) { document.body.classList.add('overflow-hidden'); } 
            else { document.body.classList.remove('overflow-hidden'); } 
        })"
        :class="{ 
            'bg-white/95 backdrop-blur-md': true 
        }"
        class="fixed top-0 w-full z-50 transition-all duration-500 border-b border-brand-secondary py-4 shadow-sm">
    
    <div class="container mx-auto px-6">
        <div class="flex items-center justify-between">
            
            {{-- 1. LOGO --}}
            <a href="{{ route('home') }}" class="relative z-50 group block" @click="mobileMenuOpen = false">
                <img src="{{ asset('img/Ativo_5.png') }}" 
                     alt="Porthouse Private Real Estate" 
                     class="h-10 md:h-12 w-auto object-contain transition-all duration-500 group-hover:opacity-80"
                     :class="{ 'scale-90': mobileMenuOpen }">
            </a>

            {{-- 2. DESKTOP MENU --}}
            <nav class="hidden lg:flex items-center gap-12">
                <a href="{{ route('home') }}" class="text-[10px] font-bold uppercase tracking-[0.2em] text-brand-text hover:text-brand-primary transition-colors relative group">
                    {{ __('header.menu.home') }}
                    <span class="absolute -bottom-2 left-1/2 w-0 h-[1px] bg-brand-primary group-hover:w-full group-hover:left-0 transition-all duration-300"></span>
                </a>

                <a href="{{ route('portfolio') }}" class="text-[10px] font-bold uppercase tracking-[0.2em] text-brand-text hover:text-brand-primary transition-colors relative group">
                    {{ __('header.menu.collection') }}
                    <span class="absolute -bottom-2 left-1/2 w-0 h-[1px] bg-brand-primary group-hover:w-full group-hover:left-0 transition-all duration-300"></span>
                </a>

                {{-- NOVO LINK: OFF-MARKET / ACESSO --}}
                <a href="{{ route('access.request') }}" class="text-[10px] font-bold uppercase tracking-[0.2em] text-brand-gold hover:text-brand-primary transition-colors relative group flex items-center gap-1">
                    <svg class="w-3 h-3 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    PRIVATE
                    <span class="absolute -bottom-2 left-1/2 w-0 h-[1px] bg-brand-gold group-hover:w-full group-hover:left-0 transition-all duration-300"></span>
                </a>

                <a href="{{ route('blog.index') }}" class="text-[10px] font-bold uppercase tracking-[0.2em] text-brand-text hover:text-brand-primary transition-colors relative group">
                    JOURNAL
                    <span class="absolute -bottom-2 left-1/2 w-0 h-[1px] bg-brand-primary group-hover:w-full group-hover:left-0 transition-all duration-300"></span>
                </a>
                
                {{-- Dropdown Tools --}}
                <div class="relative group" @mouseenter="toolsOpen = true" @mouseleave="toolsOpen = false">
                    <button class="text-[10px] font-bold uppercase tracking-[0.2em] text-brand-text hover:text-brand-primary transition-colors flex items-center gap-2 focus:outline-none py-2">
                        {{ __('header.menu.market_intelligence') }}
                        <svg class="w-3 h-3 text-brand-secondary transition-transform duration-300" :class="{'rotate-180': toolsOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    
                    <div x-show="toolsOpen" 
                         x-cloak
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-200"
                         class="absolute top-full left-1/2 -translate-x-1/2 pt-4 w-64">
                        
                        <div class="bg-white border border-brand-secondary/20 shadow-2xl p-0">
                            <a href="{{ route('tools.credit') }}" class="block px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-brand-text hover:bg-brand-secondary hover:text-white transition-colors border-b border-gray-100">
                                {{ __('header.menu.credit_simulator') }}
                            </a>
                            <a href="{{ route('tools.imt') }}" class="block px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-brand-text hover:bg-brand-secondary hover:text-white transition-colors border-b border-gray-100">
                                {{ __('header.menu.imt_simulator') }}
                            </a>
                            <a href="{{ route('tools.gains') }}" class="block px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-brand-text hover:bg-brand-secondary hover:text-white transition-colors">
                                {{ __('header.menu.gains_simulator') }}
                            </a>
                        </div>
                    </div>
                </div>

                <a href="{{ route('about') }}" class="text-[10px] font-bold uppercase tracking-[0.2em] text-brand-text hover:text-brand-primary transition-colors relative group">
                    {{ __('header.menu.about') }}
                    <span class="absolute -bottom-2 left-1/2 w-0 h-[1px] bg-brand-primary group-hover:w-full group-hover:left-0 transition-all duration-300"></span>
                </a>
                
                <div class="h-4 w-px bg-brand-secondary/20"></div>

                <a href="{{ route('contact') }}" 
                   class="px-6 py-2 border border-brand-secondary text-brand-secondary text-[9px] font-bold uppercase tracking-[0.2em] hover:bg-brand-secondary hover:text-white transition-all duration-500">
                    {{ __('header.menu.schedule') }}
                </a>

                <div class="flex items-center gap-3 text-[10px] font-bold uppercase tracking-widest text-brand-text">
                    <a href="{{ route('locale', 'pt') }}" class="{{ app()->getLocale() == 'pt' ? 'text-brand-primary border-b border-brand-primary' : 'text-gray-400 hover:text-brand-secondary' }} transition-colors pb-0.5">PT</a>
                    <a href="{{ route('locale', 'en') }}" class="{{ app()->getLocale() == 'en' ? 'text-brand-primary border-b border-brand-primary' : 'text-gray-400 hover:text-brand-secondary' }} transition-colors pb-0.5">EN</a>
                </div>
            </nav>

            {{-- 3. MOBILE MENU BUTTON --}}
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden text-brand-secondary z-50 focus:outline-none p-2 group relative">
                <div class="w-6 flex flex-col items-end justify-center gap-[5px]">
                    <span class="block w-6 h-px bg-current transition-all duration-300" :class="{'rotate-45 translate-y-[6px]': mobileMenuOpen}"></span>
                    <span class="block w-4 h-px bg-current transition-all duration-300" :class="{'opacity-0': mobileMenuOpen, 'group-hover:w-6': !mobileMenuOpen}"></span>
                    <span class="block w-6 h-px bg-current transition-all duration-300" :class="{'-rotate-45 -translate-y-[6px]': mobileMenuOpen}"></span>
                </div>
            </button>
        </div>
    </div>

    {{-- 4. MOBILE MENU OVERLAY --}}
    <template x-teleport="body">
        <div x-show="mobileMenuOpen" 
             x-cloak
             @keydown.escape.window="mobileMenuOpen = false"
             x-transition:enter="transition ease-out duration-700"
             x-transition:enter-start="opacity-0 translate-y-full"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-500"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 translate-y-full"
             class="fixed inset-0 bg-white z-40 w-full h-full overflow-y-auto"> 
            
            {{-- Background Lines --}}
            <div class="fixed inset-0 flex justify-between px-10 opacity-5 pointer-events-none z-0">
                <div class="w-px h-full bg-brand-secondary"></div>
                <div class="w-px h-full bg-brand-secondary"></div>
            </div>

            {{-- Container do Menu --}}
            <div class="relative z-10 min-h-screen flex flex-col items-center pt-32 pb-12 px-6 text-center">
                
                <nav class="flex flex-col space-y-6 w-full max-w-md">
                    <a href="{{ route('home') }}" @click="mobileMenuOpen = false" class="text-4xl font-serif text-brand-secondary hover:text-brand-primary transition-colors duration-500 group">
                        <span class="text-brand-primary opacity-0 group-hover:opacity-100 transition-opacity duration-300 text-lg align-top mr-2">01.</span>
                        {{ __('header.menu.home') }}
                    </a>
                    <a href="{{ route('portfolio') }}" @click="mobileMenuOpen = false" class="text-4xl font-serif text-brand-secondary hover:text-brand-primary transition-colors duration-500 group">
                        <span class="text-brand-primary opacity-0 group-hover:opacity-100 transition-opacity duration-300 text-lg align-top mr-2">02.</span>
                        {{ __('header.menu.collection') }}
                    </a>
                    
                    {{-- NOVO LINK MOBILE --}}
                    <a href="{{ route('access.request') }}" @click="mobileMenuOpen = false" class="text-4xl font-serif text-brand-gold hover:text-brand-primary transition-colors duration-500 group flex items-center justify-center gap-3">
                         <span class="text-brand-primary opacity-0 group-hover:opacity-100 transition-opacity duration-300 text-lg align-top">03.</span>
                        <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        PRIVATE
                    </a>

                    <a href="{{ route('blog.index') }}" @click="mobileMenuOpen = false" class="text-4xl font-serif text-brand-secondary hover:text-brand-primary transition-colors duration-500 group">
                        <span class="text-brand-primary opacity-0 group-hover:opacity-100 transition-opacity duration-300 text-lg align-top mr-2">04.</span>
                        JOURNAL
                    </a>

                    <a href="{{ route('about') }}" @click="mobileMenuOpen = false" class="text-4xl font-serif text-brand-secondary hover:text-brand-primary transition-colors duration-500 group">
                        <span class="text-brand-primary opacity-0 group-hover:opacity-100 transition-opacity duration-300 text-lg align-top mr-2">05.</span>
                        {{ __('header.menu.about') }}
                    </a>
                    
                    {{-- Ferramentas --}}
                    <div class="py-8 border-t border-brand-secondary/10 border-b border-brand-secondary/10 w-full mt-6">
                        <p class="text-[10px] uppercase tracking-[0.3em] text-brand-primary mb-6">{{ __('header.menu.tools_label') }}</p>
                        <div class="flex flex-col gap-4">
                            <a href="{{ route('tools.credit') }}" class="text-sm font-light text-brand-text hover:text-brand-primary tracking-widest uppercase">{{ __('header.menu.credit_simulator') }}</a>
                            <a href="{{ route('tools.imt') }}" class="text-sm font-light text-brand-text hover:text-brand-primary tracking-widest uppercase">{{ __('header.menu.imt_simulator') }}</a>
                            <a href="{{ route('tools.gains') }}" class="text-sm font-light text-brand-text hover:text-brand-primary tracking-widest uppercase">{{ __('header.menu.gains_simulator') }}</a>
                        </div>
                    </div>

                    {{-- CTA --}}
                    <div class="mt-4">
                        <a href="{{ route('contact') }}" class="inline-block w-full py-4 border border-brand-secondary text-brand-secondary uppercase text-xs font-bold tracking-widest hover:bg-brand-secondary hover:text-white transition-all">
                            {{ __('header.menu.schedule') }}
                        </a>
                    </div>

                    {{-- Idiomas (Mobile) --}}
                    <div class="flex justify-center items-center gap-6 mt-6 text-xs font-bold uppercase tracking-widest text-brand-text">
                        <a href="{{ route('locale', 'pt') }}" class="{{ app()->getLocale() == 'pt' ? 'text-brand-primary border-b border-brand-primary' : 'text-gray-400 hover:text-brand-secondary' }} transition-colors pb-1 px-2">Português</a>
                        <span class="text-gray-300">|</span>
                        <a href="{{ route('locale', 'en') }}" class="{{ app()->getLocale() == 'en' ? 'text-brand-primary border-b border-brand-primary' : 'text-gray-400 hover:text-brand-secondary' }} transition-colors pb-1 px-2">English</a>
                    </div>
                </nav>
            </div>
        </div>
    </template>
</header>