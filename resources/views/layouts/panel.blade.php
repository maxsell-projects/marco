<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-white">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Porthouse Private Office</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    
    <style>
        [x-cloak] { display: none !important; }
        .font-serif { font-family: 'Playfair Display', serif; }
        .font-sans { font-family: 'Manrope', sans-serif; }
        
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(141, 24, 43, 0.2); border-radius: 10px; }
    </style>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            primary: '#8D182B',    // Bordeaux
                            secondary: '#1D4C42',  // Verde Inglês
                            sand: '#E5C2A4',       // Areia
                            text: '#1a1a1a',       // Preto Neutro
                            bg: '#FFFFFF',         // Branco Puro
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="h-full font-sans text-brand-text antialiased selection:bg-brand-primary selection:text-white">

<div x-data="{ sidebarOpen: false }" class="flex h-screen overflow-hidden bg-white">

    {{-- Mobile Overlay --}}
    <div x-show="sidebarOpen" 
         x-cloak 
         class="fixed inset-0 z-20 transition-opacity bg-brand-text/60 lg:hidden" 
         @click="sidebarOpen = false"></div>

    {{-- Sidebar --}}
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
           class="fixed inset-y-0 left-0 z-30 w-72 bg-brand-text text-white transition-transform duration-300 lg:static lg:translate-x-0 lg:inset-0 shadow-2xl flex flex-col border-r border-white/5">
        
        {{-- Logo Section - Ativo_5.png --}}
        <div class="flex items-center justify-center h-32 border-b border-white/5 px-8">
            <a href="{{ route('dashboard') }}" class="block">
                <img src="{{ asset('img/Ativo_5.png') }}" alt="Porthouse Logo" class="h-20 w-auto object-contain">
            </a>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 overflow-y-auto py-8 px-6 space-y-1 custom-scrollbar">
            @include('partials.sidebar')
        </nav>

        {{-- Footer Sidebar --}}
        <div class="p-6 border-t border-white/5 bg-black/20">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-full border border-brand-secondary p-0.5">
                    <div class="w-full h-full rounded-full bg-brand-secondary flex items-center justify-center text-white font-bold text-sm font-serif">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-white truncate">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] text-brand-sand uppercase tracking-widest font-bold">{{ Auth::user()->role }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-slate-500 hover:text-brand-primary transition-colors p-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    {{-- Main Content --}}
    <div class="relative flex flex-col flex-1 overflow-hidden">
        
        {{-- Header Mobile --}}
        <header class="flex items-center justify-between px-6 py-4 bg-white border-b border-slate-100 lg:hidden">
            <button @click="sidebarOpen = true" class="text-brand-text focus:outline-none">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
            </button>
            <img src="{{ asset('img/Ativo_5.png') }}" alt="Logo" class="h-10 w-auto">
            <div class="w-6"></div>
        </header>

        {{-- Scrollable Area --}}
        <main class="flex-1 overflow-y-auto bg-white relative custom-scrollbar">
            <div class="max-w-7xl mx-auto p-6 lg:p-12">
                @if(session('success'))
                    <div x-data="{ show: true }" 
                         x-show="show" 
                         x-transition.duration.300ms
                         class="mb-8 p-4 bg-white border-l-4 border-brand-secondary text-brand-text flex justify-between items-center rounded-sm shadow-sm border border-slate-100">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-brand-secondary" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            <span class="text-sm font-bold uppercase tracking-tight">{{ session('success') }}</span>
                        </div>
                        <button @click="show = false" class="text-slate-400 hover:text-brand-primary">&times;</button>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
</div>

</body>
</html>