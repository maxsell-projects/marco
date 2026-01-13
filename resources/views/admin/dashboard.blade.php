<!DOCTYPE html>
<html lang="pt-pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | José Carvalho</title>
    
    {{-- FAVICON --}}
    <link rel="icon" href="{{ asset('img/favicon.png') }}" type="image/png">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link href="https://fonts.googleapis.com/css2?family=GFS+Didot&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-100 font-sans text-brand-text h-screen overflow-hidden">

    <div class="flex h-full">
        
        {{-- SIDEBAR --}}
        <aside class="w-72 bg-brand-primary text-white flex flex-col shadow-2xl z-20 relative">
            {{-- Logo Area --}}
            <div class="p-8 text-center border-b border-white/5 bg-black/10">
                <h1 class="font-didot text-2xl tracking-widest text-white">JOSÉ CARVALHO</h1>
                <p class="text-[10px] uppercase tracking-[0.3em] text-brand-premium mt-2">Private Office</p>
            </div>

            {{-- Nav Links --}}
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                <p class="px-4 text-[10px] uppercase tracking-widest text-gray-500 mb-2">Gestão</p>
                
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center gap-3 px-4 py-3 bg-brand-premium/10 text-brand-premium border-l-2 border-brand-premium rounded-r text-sm font-medium transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    Painel Geral
                </a>
                
                <a href="{{ route('admin.properties.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 text-gray-400 hover:bg-white/5 hover:text-white rounded transition-colors text-sm group">
                    <svg class="w-5 h-5 group-hover:text-brand-premium transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    Imóveis
                </a>

                <p class="px-4 text-[10px] uppercase tracking-widest text-gray-500 mt-6 mb-2">Atalhos</p>
                
                <a href="{{ route('home') }}" target="_blank" 
                   class="flex items-center gap-3 px-4 py-3 text-gray-400 hover:bg-white/5 hover:text-white rounded transition-colors text-sm group">
                    <svg class="w-5 h-5 group-hover:text-brand-premium transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    Ver Site (Ao Vivo)
                </a>
            </nav>

            {{-- Logout --}}
            <div class="p-4 border-t border-white/5 bg-black/10">
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-3 text-xs uppercase tracking-widest text-gray-400 hover:text-white hover:bg-red-500/10 hover:border-red-500/50 border border-transparent rounded transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Terminar Sessão
                    </button>
                </form>
            </div>
        </aside>

        {{-- MAIN CONTENT --}}
        <main class="flex-1 overflow-y-auto bg-[#F5F7FA]">
            {{-- Top Bar --}}
            <header class="bg-white border-b border-gray-200 sticky top-0 z-10 px-8 py-4 flex justify-between items-center shadow-sm">
                <div>
                    <h2 class="text-xl font-serif text-brand-primary">Visão Geral</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Bem-vindo, {{ Auth::user()->name ?? 'Administrador' }}.</p>
                </div>
                
                <div class="flex items-center gap-4">
                    <a href="{{ route('admin.properties.create') }}" class="flex items-center gap-2 bg-brand-cta text-white px-5 py-2.5 rounded shadow hover:bg-opacity-90 transition font-bold uppercase text-[10px] tracking-widest">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Adicionar Imóvel
                    </a>
                </div>
            </header>

            <div class="p-8 max-w-7xl mx-auto space-y-8">
                
                {{-- Stats Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    {{-- Card 1 --}}
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 flex items-center justify-between group hover:border-brand-premium/30 transition-all">
                        <div>
                            <p class="text-[10px] uppercase tracking-widest text-gray-400 mb-1">Total em Carteira</p>
                            <p class="text-3xl font-didot text-brand-primary group-hover:text-brand-premium transition-colors">
                                {{ \App\Models\Property::count() }}
                            </p>
                        </div>
                        <div class="p-3 bg-brand-primary/5 rounded-full text-brand-primary group-hover:bg-brand-premium/10 group-hover:text-brand-premium transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        </div>
                    </div>

                    {{-- Card 2 --}}
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 flex items-center justify-between group hover:border-brand-premium/30 transition-all">
                        <div>
                            <p class="text-[10px] uppercase tracking-widest text-gray-400 mb-1">Venda</p>
                            <p class="text-3xl font-didot text-brand-cta">
                                {{ \App\Models\Property::where('status', 'available')->orWhere('status', 'Venda')->count() }}
                            </p>
                        </div>
                        <div class="p-3 bg-brand-cta/5 rounded-full text-brand-cta">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>

                    {{-- Card 3 --}}
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100 flex items-center justify-between group hover:border-brand-premium/30 transition-all">
                        <div>
                            <p class="text-[10px] uppercase tracking-widest text-gray-400 mb-1">Arrendamento</p>
                            <p class="text-3xl font-didot text-brand-secondary">
                                {{ \App\Models\Property::where('status', 'Arrendamento')->count() }}
                            </p>
                        </div>
                        <div class="p-3 bg-brand-secondary/5 rounded-full text-brand-secondary">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                    </div>
                </div>

                {{-- Recent Table --}}
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                        <h3 class="font-serif text-lg text-brand-primary">Últimas Adições</h3>
                        <a href="{{ route('admin.properties.index') }}" class="text-xs text-brand-cta hover:underline">Ver todos</a>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left whitespace-nowrap">
                            <thead class="bg-gray-50 text-[10px] uppercase text-gray-400 font-bold tracking-wider">
                                <tr>
                                    <th class="px-6 py-4">Imóvel</th>
                                    <th class="px-6 py-4">Preço</th>
                                    <th class="px-6 py-4">Localização</th>
                                    <th class="px-6 py-4">Estado</th>
                                    <th class="px-6 py-4 text-right">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 text-sm">
                                @foreach(\App\Models\Property::latest()->take(5)->get() as $property)
                                <tr class="hover:bg-gray-50/80 transition-colors group">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-4">
                                            <div class="w-10 h-10 rounded bg-gray-200 overflow-hidden flex-shrink-0 border border-gray-200">
                                                @if($property->cover_image)
                                                    <img src="{{ asset('storage/'.$property->cover_image) }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs">IMG</div>
                                                @endif
                                            </div>
                                            <div>
                                                <p class="font-medium text-brand-primary group-hover:text-brand-cta transition-colors">{{ Str::limit($property->title, 25) }}</p>
                                                <p class="text-[10px] text-gray-400 uppercase tracking-wide">{{ $property->reference_code ?? 'SEM REF' }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 font-mono text-gray-600">
                                        {{ $property->price ? '€ ' . number_format($property->price, 0, ',', '.') : '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-500">{{ $property->location }}</td>
                                    <td class="px-6 py-4">
                                        @if($property->status == 'available' || $property->status == 'Venda')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Disponível
                                            </span>
                                        @elseif($property->status == 'Arrendamento')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                Arrendar
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                {{ $property->status }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('admin.properties.edit', $property) }}" class="text-gray-400 hover:text-brand-primary transition-colors font-medium text-xs uppercase tracking-wider">
                                            Editar
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

</body>
</html>