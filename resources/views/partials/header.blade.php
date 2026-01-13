<header x-data="{ mobileMenuOpen: false, toolsOpen: false, scrolled: false }" 
        @scroll.window="scrolled = (window.pageYOffset > 50)"
        :class="{ 'bg-brand-primary shadow-lg py-4': scrolled, 'bg-transparent py-6': !scrolled }"
        class="fixed top-0 w-full z-50 transition-all duration-300">
    
    <div class="container mx-auto px-6">
        <div class="flex items-center justify-between">
            
            {{-- LOGO --}}
            <a href="{{ route('home') }}" class="relative z-50 group">
                <span class="font-didot text-2xl md:text-3xl text-white tracking-wide group-hover:opacity-90 transition-opacity">
                    JOSÉ CARVALHO
                </span>
            </a>

            {{-- DESKTOP MENU --}}
            <nav class="hidden md:flex items-center gap-8">
                <a href="{{ route('home') }}" class="text-xs font-bold uppercase tracking-widest text-white hover:text-brand-premium transition-colors">Início</a>
                <a href="{{ route('portfolio') }}" class="text-xs font-bold uppercase tracking-widest text-white hover:text-brand-premium transition-colors">Imóveis</a>
                
                {{-- Dropdown Ferramentas --}}
                <div class="relative" @mouseenter="toolsOpen = true" @mouseleave="toolsOpen = false">
                    <button class="text-xs font-bold uppercase tracking-widest text-white hover:text-brand-premium transition-colors flex items-center gap-1 focus:outline-none">
                        Ferramentas
                        <svg class="w-3 h-3 transition-transform duration-300" :class="{'rotate-180': toolsOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    
                    {{-- Dropdown Content --}}
                    <div x-show="toolsOpen" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 translate-y-2"
                         class="absolute top-full left-1/2 -translate-x-1/2 mt-4 w-56 bg-white shadow-xl border-t-2 border-brand-premium py-2 rounded-sm">
                        
                        <a href="{{ route('tools.credit') }}" class="block px-6 py-3 text-[10px] font-bold uppercase tracking-widest text-brand-primary hover:bg-gray-50 hover:text-brand-cta transition-colors">
                            Simulador Crédito
                        </a>
                        <a href="{{ route('tools.imt') }}" class="block px-6 py-3 text-[10px] font-bold uppercase tracking-widest text-brand-primary hover:bg-gray-50 hover:text-brand-cta transition-colors">
                            Simulador IMT
                        </a>
                        <a href="{{ route('tools.gains') }}" class="block px-6 py-3 text-[10px] font-bold uppercase tracking-widest text-brand-primary hover:bg-gray-50 hover:text-brand-cta transition-colors">
                            Mais-Valias
                        </a>
                    </div>
                </div>

                <a href="{{ route('about') }}" class="text-xs font-bold uppercase tracking-widest text-white hover:text-brand-premium transition-colors">Sobre</a>
                
                <a href="{{ route('contact') }}" 
                   class="bg-brand-cta text-white px-6 py-3 rounded-sm uppercase text-[10px] font-bold tracking-widest hover:bg-white hover:text-brand-cta transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                    Agendar Reunião
                </a>
            </nav>

            {{-- MOBILE MENU BUTTON --}}
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden text-white z-50 focus:outline-none">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path x-show="mobileMenuOpen" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    {{-- MOBILE MENU OVERLAY --}}
    <div x-show="mobileMenuOpen" 
         x-cloak
         style="display: none;"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 -translate-y-full"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-full"
         class="fixed inset-0 bg-brand-primary z-40 flex flex-col items-center justify-center space-y-6 md:hidden">
        
        <a href="{{ route('home') }}" class="text-2xl font-didot text-white hover:text-brand-premium transition-colors">Início</a>
        <a href="{{ route('portfolio') }}" class="text-2xl font-didot text-white hover:text-brand-premium transition-colors">Imóveis</a>
        
        <div class="h-px w-12 bg-white/20 my-2"></div>
        
        {{-- Links Ferramentas Mobile --}}
        <a href="{{ route('tools.credit') }}" class="text-sm font-bold uppercase tracking-widest text-brand-premium hover:text-white">Simulador Crédito</a>
        <a href="{{ route('tools.imt') }}" class="text-sm font-bold uppercase tracking-widest text-brand-premium hover:text-white">IMT & Selo</a>
        <a href="{{ route('tools.gains') }}" class="text-sm font-bold uppercase tracking-widest text-brand-premium hover:text-white">Mais-Valias</a>
        
        <div class="h-px w-12 bg-white/20 my-2"></div>

        <a href="{{ route('about') }}" class="text-2xl font-didot text-white hover:text-brand-premium transition-colors">Sobre</a>
        <a href="{{ route('contact') }}" class="text-2xl font-didot text-white hover:text-brand-premium transition-colors">Contactos</a>
    </div>
</header>