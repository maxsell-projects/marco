<header x-data="{ mobileMenuOpen: false, toolsOpen: false, scrolled: false }" 
        @scroll.window="scrolled = (window.pageYOffset > 20)"
        :class="{ 
            'bg-brand-secondary shadow-none py-6': mobileMenuOpen, 
            'bg-brand-secondary/95 backdrop-blur-md shadow-lg py-4': scrolled && !mobileMenuOpen, 
            'bg-transparent py-6': !scrolled && !mobileMenuOpen 
        }"
        class="fixed top-0 w-full z-50 transition-all duration-500 border-b border-white/5">
    
    <div class="container mx-auto px-6">
        <div class="flex items-center justify-between">
            
            {{-- 1. LOGO (IMAGEM PORTHOUSE) --}}
            <a href="{{ route('home') }}" class="relative z-50 group block" @click="mobileMenuOpen = false">
                <img src="{{ asset('img/Ativo_5.png') }}" 
                     alt="Porthouse Private Real Estate" 
                     :class="{ 'scale-90': mobileMenuOpen }"
                     class="h-10 md:h-12 w-auto object-contain transition-all duration-500 group-hover:scale-105">
            </a>

            {{-- 2. DESKTOP MENU --}}
            <nav class="hidden lg:flex items-center gap-10">
                <a href="{{ route('home') }}" class="text-[10px] font-bold uppercase tracking-[0.2em] text-white hover:text-brand-sand transition-colors relative group">
                    {{ __('header.menu.home') }}
                    <span class="absolute -bottom-2 left-0 w-0 h-[1px] bg-brand-sand group-hover:w-full transition-all duration-300"></span>
                </a>
                <a href="{{ route('portfolio') }}" class="text-[10px] font-bold uppercase tracking-[0.2em] text-white hover:text-brand-sand transition-colors relative group">
                    {{ __('header.menu.collection') }}
                    <span class="absolute -bottom-2 left-0 w-0 h-[1px] bg-brand-sand group-hover:w-full transition-all duration-300"></span>
                </a>
                
                <div class="relative group" @mouseenter="toolsOpen = true" @mouseleave="toolsOpen = false">
                    <button class="text-[10px] font-bold uppercase tracking-[0.2em] text-white hover:text-brand-sand transition-colors flex items-center gap-2 focus:outline-none py-2">
                        {{ __('header.menu.market_intelligence') }}
                        <svg class="w-3 h-3 text-brand-sand/70 transition-transform duration-300" :class="{'rotate-180': toolsOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    
                    <div x-show="toolsOpen" 
                         x-cloak
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 translate-y-2"
                         class="absolute top-full left-1/2 -translate-x-1/2 pt-6 w-64">
                        
                        <div class="bg-brand-secondary border-t-2 border-brand-primary shadow-2xl p-0">
                            <a href="{{ route('tools.credit') }}" class="block px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-white hover:bg-white/5 hover:text-brand-sand transition-colors border-b border-white/5">
                                {{ __('header.menu.credit_simulator') }}
                            </a>
                            <a href="{{ route('tools.imt') }}" class="block px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-white hover:bg-white/5 hover:text-brand-sand transition-colors border-b border-white/5">
                                {{ __('header.menu.imt_simulator') }}
                            </a>
                            <a href="{{ route('tools.gains') }}" class="block px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-white hover:bg-white/5 hover:text-brand-sand transition-colors">
                                {{ __('header.menu.gains_simulator') }}
                            </a>
                        </div>
                    </div>
                </div>

                <a href="{{ route('about') }}" class="text-[10px] font-bold uppercase tracking-[0.2em] text-white hover:text-brand-sand transition-colors relative group">
                    {{ __('header.menu.about') }}
                    <span class="absolute -bottom-2 left-0 w-0 h-[1px] bg-brand-sand group-hover:w-full transition-all duration-300"></span>
                </a>
                
                <a href="{{ route('contact') }}" 
                   class="bg-brand-primary text-white px-8 py-3 uppercase text-[9px] font-bold tracking-[0.2em] border border-transparent hover:bg-transparent hover:border-brand-sand hover:text-brand-sand transition-all duration-500 shadow-lg">
                    {{ __('header.menu.schedule') }}
                </a>

                <div class="flex items-center gap-3 text-[10px] font-bold uppercase tracking-widest text-white pl-6 border-l border-white/20 h-6">
                    <a href="{{ route('locale', 'pt') }}" class="{{ app()->getLocale() == 'pt' ? 'text-brand-sand' : 'text-white/40 hover:text-white' }} transition-colors">PT</a>
                    <a href="{{ route('locale', 'en') }}" class="{{ app()->getLocale() == 'en' ? 'text-brand-sand' : 'text-white/40 hover:text-white' }} transition-colors">EN</a>
                </div>
            </nav>

            {{-- 3. MOBILE MENU BUTTON --}}
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden text-brand-sand z-50 focus:outline-none p-2">
                <div class="w-6 flex items-center justify-center relative">
                    <span x-show="!mobileMenuOpen" class="transform transition w-full h-px bg-current absolute -translate-y-2"></span>
                    <span x-show="!mobileMenuOpen" class="transform transition w-full h-px bg-current absolute translate-y-2"></span>
                    <span x-show="!mobileMenuOpen" class="transform transition w-full h-px bg-current absolute"></span>
                    
                    <svg x-show="mobileMenuOpen" x-cloak class="w-6 h-6 transform rotate-90 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12" /></svg>
                </div>
            </button>
        </div>
    </div>

    {{-- 4. MOBILE MENU OVERLAY --}}
    <div x-show="mobileMenuOpen" 
         x-cloak
         x-transition:enter="transition ease-out duration-500"
         x-transition:enter-start="opacity-0 translate-y-full"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-full"
         class="fixed inset-0 bg-brand-secondary z-40 flex flex-col pt-32 overflow-y-auto">
        
        <div class="absolute inset-0 opacity-5 pointer-events-none bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>

        <div class="container mx-auto px-6 relative z-10 py-12">
            <nav class="flex flex-col items-center space-y-6 text-center">
                <a href="{{ route('home') }}" @click="mobileMenuOpen = false" class="text-3xl font-serif text-white hover:text-brand-sand transition-colors">{{ __('header.menu.home') }}</a>
                <a href="{{ route('portfolio') }}" @click="mobileMenuOpen = false" class="text-3xl font-serif text-white hover:text-brand-sand transition-colors">{{ __('header.menu.collection') }}</a>
                <a href="{{ route('about') }}" @click="mobileMenuOpen = false" class="text-3xl font-serif text-white hover:text-brand-sand transition-colors">{{ __('header.menu.about') }}</a>
                
                <div class="w-12 h-[1px] bg-white/10 my-4"></div>
                
                <p class="text-[10px] uppercase tracking-widest text-brand-sand mb-2">{{ __('header.menu.tools_label') }}</p>
                <a href="{{ route('tools.credit') }}" @click="mobileMenuOpen = false" class="text-lg font-light text-white/70 hover:text-white transition-colors">{{ __('header.menu.credit_simulator') }}</a>
                <a href="{{ route('tools.imt') }}" @click="mobileMenuOpen = false" class="text-lg font-light text-white/70 hover:text-white transition-colors">{{ __('header.menu.imt_simulator') }}</a>
                <a href="{{ route('tools.gains') }}" @click="mobileMenuOpen = false" class="text-lg font-light text-white/70 hover:text-white transition-colors">{{ __('header.menu.gains_simulator') }}</a>

                <div class="w-12 h-[1px] bg-white/10 my-4"></div>

                <a href="{{ route('contact') }}" @click="mobileMenuOpen = false" class="px-10 py-4 bg-brand-primary text-white uppercase text-xs font-bold tracking-widest hover:bg-white hover:text-brand-primary transition-colors shadow-xl">
                    {{ __('header.menu.schedule') }}
                </a>

                <div class="flex items-center gap-6 mt-8">
                    <a href="{{ route('locale', 'pt') }}" class="text-xs font-bold uppercase tracking-widest {{ app()->getLocale() == 'pt' ? 'text-brand-sand border-b border-brand-sand' : 'text-white/40' }} pb-1">PT</a>
                    <a href="{{ route('locale', 'en') }}" class="text-xs font-bold uppercase tracking-widest {{ app()->getLocale() == 'en' ? 'text-brand-sand border-b border-brand-sand' : 'text-white/40' }} pb-1">EN</a>
                </div>
            </nav>
        </div>

        <div class="mt-auto pb-8 w-full text-center">
            <p class="text-[9px] text-white/20 uppercase tracking-widest">Porthouse Private Office &copy; {{ date('Y') }}</p>
        </div>
    </div>
</header>