<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Porthouse Private Office</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;1,400&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    
    <style>
        [x-cloak] { display: none !important; }
        .font-serif { family-font: 'Playfair Display', serif; }
        .font-sans { family-font: 'Lato', sans-serif; }
    </style>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            dark: '#1a1a1a', // Preto quase preto
                            gold: '#C5A059', // Dourado sutil
                            gray: '#f4f4f5',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="h-full font-sans text-slate-600 antialiased selection:bg-brand-gold selection:text-white">

<div x-data="{ sidebarOpen: false }" class="flex h-screen overflow-hidden">

    <div x-show="sidebarOpen" x-cloak class="fixed inset-0 z-20 transition-opacity bg-black/50 lg:hidden" @click="sidebarOpen = false"></div>

    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
           class="fixed inset-y-0 left-0 z-30 w-72 bg-brand-dark text-white transition-transform duration-300 lg:static lg:translate-x-0 lg:inset-0 shadow-2xl flex flex-col">
        
        <div class="flex items-center justify-center h-24 border-b border-white/10">
            <div class="text-center">
                <h1 class="font-serif text-2xl tracking-widest text-white">PORTHOUSE</h1>
                <p class="text-[10px] uppercase tracking-[0.4em] text-brand-gold">Private Office</p>
            </div>
        </div>

        <nav class="flex-1 overflow-y-auto py-8 px-4 space-y-2">
            @include('partials.sidebar')
        </nav>

        <div class="p-4 border-t border-white/10 bg-black/20">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-brand-gold flex items-center justify-center text-brand-dark font-bold text-lg font-serif">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-white truncate">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-400 truncate capitalize">{{ Auth::user()->role }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-gray-400 hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden bg-slate-50">
        
        <header class="flex items-center justify-between px-6 py-4 bg-white border-b border-slate-200 lg:hidden">
            <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" /></svg>
            </button>
            <span class="font-serif font-bold text-lg text-brand-dark">PORTHOUSE</span>
        </header>

        <main class="w-full flex-grow p-6 lg:p-10">
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 flex justify-between items-center rounded shadow-sm">
                    <span>{{ session('success') }}</span>
                    <button @click="show = false" class="text-green-500 hover:text-green-700">&times;</button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

</body>
</html>