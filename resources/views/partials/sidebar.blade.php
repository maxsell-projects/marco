@php
    $itemClass = "flex items-center gap-3 px-4 py-3 text-sm font-medium transition-all duration-200 rounded-md group";
    $activeClass = "bg-brand-gold text-white shadow-lg shadow-brand-gold/20";
    $inactiveClass = "text-gray-400 hover:bg-white/10 hover:text-white";
@endphp

<p class="px-4 text-[10px] font-bold uppercase tracking-widest text-gray-500 mb-2 mt-2">Principal</p>

<a href="{{ route('dashboard') }}" 
   class="{{ $itemClass }} {{ request()->routeIs('dashboard') ? $activeClass : $inactiveClass }}">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
    Visão Geral
</a>

@if(!Auth::user()->isClient())
    <p class="px-4 text-[10px] font-bold uppercase tracking-widest text-gray-500 mb-2 mt-6">Gestão</p>

    <a href="{{ route('admin.properties.index') }}" 
       class="{{ $itemClass }} {{ request()->routeIs('admin.properties.*') ? $activeClass : $inactiveClass }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
        Imóveis
    </a>

    <a href="{{ route('admin.requests.index') }}" 
       class="{{ $itemClass }} {{ request()->routeIs('admin.requests.*') ? $activeClass : $inactiveClass }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
        Solicitações
        
        @php
            $pendingCount = \App\Models\User::where('is_active', false)->where('role', '!=', 'admin')->count();
        @endphp
        
        @if($pendingCount > 0)
            <span class="ml-auto bg-brand-gold text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow-sm">{{ $pendingCount }}</span>
        @endif
    </a>

    <div x-data="{ open: {{ request()->routeIs('admin.users.*') ? 'true' : 'false' }} }" class="space-y-1">
        <button @click="open = !open" 
                class="{{ $itemClass }} w-full justify-between {{ request()->routeIs('admin.users.*') ? 'text-white bg-white/10' : 'text-gray-400 hover:bg-white/10 hover:text-white' }}">
            <div class="flex items-center gap-3">
                 <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                Usuários
            </div>
            <svg :class="open ? 'rotate-180' : ''" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
        </button>
        
        <div x-show="open" x-cloak class="pl-11 space-y-1">
            <a href="{{ route('admin.users.index') }}" 
               class="block py-2 px-2 rounded-md text-xs transition-colors {{ request()->routeIs('admin.users.index') ? 'text-white bg-white/10 font-bold' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
               Todos
            </a>
            <a href="{{ route('admin.users.devs') }}" 
               class="block py-2 px-2 rounded-md text-xs transition-colors {{ request()->routeIs('admin.users.devs') ? 'text-white bg-white/10 font-bold' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
               Equipe & Clientes
            </a>
        </div>
    </div>

    <a href="{{ route('admin.blog.index') }}" 
       class="{{ $itemClass }} {{ request()->routeIs('admin.blog.*') ? $activeClass : $inactiveClass }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
        Blog & News
    </a>
@endif

@if(Auth::user()->isClient())
    <p class="px-4 text-[10px] font-bold uppercase tracking-widest text-gray-500 mb-2 mt-6">Minha Carteira</p>

    <a href="{{ route('client.favorites.index') }}" 
       class="{{ $itemClass }} {{ request()->routeIs('client.favorites.*') ? $activeClass : $inactiveClass }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
        Favoritos
    </a>
    
    <a href="{{ route('client.properties.exclusive') }}" 
       class="{{ $itemClass }} {{ request()->routeIs('client.properties.exclusive') ? $activeClass : $inactiveClass }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
        Off-Market
    </a>
@endif