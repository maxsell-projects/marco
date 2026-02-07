@extends('layouts.panel')

@section('content')

<div class="max-w-7xl mx-auto">
    
    {{-- HEADER DE BOAS-VINDAS --}}
    <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <h2 class="font-serif text-3xl text-brand-dark">Olá, {{ explode(' ', $user->name)[0] }}</h2>
            <p class="text-sm text-gray-500 mt-1 uppercase tracking-widest text-[10px]">
                @if($user->isAdmin()) Painel Administrativo Global
                @elseif($user->isDev()) Painel do Parceiro
                @else Área do Cliente Private
                @endif
            </p>
        </div>
        <div class="text-sm text-gray-400 font-mono flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            {{ now()->format('d M, Y') }}
        </div>
    </div>

    {{-- GRID DE ESTATÍSTICAS --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        
        @if($user->isClient())
            {{-- CLIENTE --}}
            <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-md transition-shadow">
                <div>
                    <p class="text-[10px] uppercase tracking-widest text-gray-400 font-bold mb-2">Meus Favoritos</p>
                    <p class="text-4xl font-serif text-brand-dark">{{ $clientData['favorites_count'] }}</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-brand-gold/10 flex items-center justify-center text-brand-gold">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                </div>
            </div>

            <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-md transition-shadow">
                <div>
                    <p class="text-[10px] uppercase tracking-widest text-gray-400 font-bold mb-2">Acessos Off-Market</p>
                    <p class="text-4xl font-serif text-brand-dark">{{ $clientData['exclusive_access'] }}</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-purple-50 flex items-center justify-center text-purple-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
            </div>

        @else
            {{-- ADMIN & DEV --}}
            <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-md transition-shadow">
                <div>
                    <p class="text-[10px] uppercase tracking-widest text-gray-400 font-bold mb-2">Total Imóveis</p>
                    <p class="text-4xl font-serif text-brand-dark">{{ $stats['total_properties'] }}</p>
                </div>
                <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center text-blue-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
            </div>

            @if($user->isAdmin())
                {{-- Card de Pendências (Só Admin) --}}
                <a href="{{ route('admin.properties.index', ['filter' => 'pending']) }}" class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-md transition-shadow group cursor-pointer relative overflow-hidden">
                    @if($stats['pending_reviews'] > 0)
                        <div class="absolute top-0 right-0 w-3 h-3 bg-red-500 rounded-bl-full"></div>
                    @endif
                    <div>
                        <p class="text-[10px] uppercase tracking-widest text-gray-400 font-bold mb-2 group-hover:text-red-500 transition-colors">Aprovação Pendente</p>
                        <p class="text-4xl font-serif text-brand-dark group-hover:text-red-600 transition-colors">{{ $stats['pending_reviews'] }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-red-50 flex items-center justify-center text-red-500 group-hover:bg-red-100 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                    </div>
                </a>

                {{-- Card de Solicitações de Acesso (Só Admin) --}}
                <a href="{{ route('admin.requests.index') }}" class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between hover:shadow-md transition-shadow group cursor-pointer">
                    <div>
                        <p class="text-[10px] uppercase tracking-widest text-gray-400 font-bold mb-2">Novos Pedidos</p>
                        <p class="text-4xl font-serif text-brand-dark">{{ $stats['access_requests'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-yellow-50 flex items-center justify-center text-yellow-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                    </div>
                </a>
            @else
                {{-- Card DEV --}}
                <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
                    <div>
                        <p class="text-[10px] uppercase tracking-widest text-gray-400 font-bold mb-2">Meus Pendentes</p>
                        <p class="text-4xl font-serif text-brand-dark">{{ $stats['pending_reviews'] }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-yellow-50 flex items-center justify-center text-yellow-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                </div>
            @endif

        @endif
    </div>

    {{-- FEED DE ATIVIDADE (PLACEHOLDER) --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 min-h-[300px] flex flex-col items-center justify-center text-center">
        @if($user->isAdmin() && ($stats['access_requests'] ?? 0) > 0)
            <div class="w-16 h-16 bg-yellow-50 text-yellow-500 rounded-full flex items-center justify-center mb-4 animate-pulse">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
            </div>
            <h3 class="font-serif text-xl text-brand-dark mb-2">Atenção Necessária</h3>
            <p class="text-gray-400 max-w-sm mb-6">Existem {{ $stats['access_requests'] }} novas solicitações de acesso aguardando sua aprovação.</p>
            <a href="{{ route('admin.requests.index') }}" class="px-6 py-3 bg-brand-dark text-white text-xs font-bold uppercase tracking-widest hover:bg-brand-gold transition-colors rounded-sm">
                Gerir Solicitações
            </a>
        @else
            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
            </div>
            <h3 class="font-serif text-xl text-brand-dark mb-2">Tudo em Dia</h3>
            <p class="text-gray-400 max-w-sm">Nenhuma atividade urgente no momento.</p>
        @endif
    </div>

</div>

@endsection