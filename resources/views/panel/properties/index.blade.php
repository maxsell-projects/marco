@extends('layouts.panel')

@section('content')
<div class="max-w-7xl mx-auto">
    
    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
        <div>
            <h2 class="font-serif text-3xl text-brand-dark">Gestão de Imóveis</h2>
            <p class="text-xs text-gray-500 uppercase tracking-widest mt-1">
                @if(Auth::user()->isAdmin())
                    Administração Global
                @else
                    Meu Portfólio
                @endif
            </p>
        </div>
        <a href="{{ route('admin.properties.create') }}" class="px-6 py-3 bg-brand-dark text-white text-sm font-bold uppercase tracking-widest hover:bg-brand-gold transition-colors shadow-lg rounded-sm flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Novo Imóvel
        </a>
    </div>

    {{-- ALERTA DE SUCESSO --}}
    @if (session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 flex items-center justify-between shadow-sm animate-fade-in-down">
            <div class="flex items-center">
                <svg class="h-5 w-5 text-green-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    {{-- ABAS DE FILTRO --}}
    <div class="bg-white rounded-t-xl border-b border-gray-200 px-6 pt-4 flex gap-6 overflow-x-auto">
        <a href="{{ route('admin.properties.index') }}" 
           class="pb-4 text-xs font-bold uppercase tracking-widest border-b-2 transition-all {{ $filter === 'all' ? 'border-brand-gold text-brand-dark' : 'border-transparent text-gray-400 hover:text-gray-600 hover:border-gray-200' }}">
            Todos 
            <span class="ml-1 px-2 py-0.5 bg-gray-100 text-gray-600 rounded-full text-[9px]">{{ $counts['all'] }}</span>
        </a>
        
        <a href="{{ route('admin.properties.index', ['filter' => 'published']) }}" 
           class="pb-4 text-xs font-bold uppercase tracking-widest border-b-2 transition-all {{ $filter === 'published' ? 'border-brand-gold text-brand-dark' : 'border-transparent text-gray-400 hover:text-gray-600 hover:border-gray-200' }}">
            Publicados
            <span class="ml-1 px-2 py-0.5 bg-green-100 text-green-700 rounded-full text-[9px]">{{ $counts['published'] }}</span>
        </a>

        <a href="{{ route('admin.properties.index', ['filter' => 'pending']) }}" 
           class="pb-4 text-xs font-bold uppercase tracking-widest border-b-2 transition-all {{ $filter === 'pending' ? 'border-brand-gold text-brand-dark' : 'border-transparent text-gray-400 hover:text-gray-600 hover:border-gray-200' }}">
            Pendentes
            @if($counts['pending'] > 0)
                <span class="ml-1 px-2 py-0.5 bg-red-100 text-red-700 rounded-full text-[9px] font-bold animate-pulse">{{ $counts['pending'] }}</span>
            @else
                <span class="ml-1 px-2 py-0.5 bg-gray-100 text-gray-600 rounded-full text-[9px]">{{ $counts['pending'] }}</span>
            @endif
        </a>
    </div>

    {{-- TABELA --}}
    <div class="bg-white shadow-sm border border-gray-100 border-t-0 rounded-b-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100 text-[10px] uppercase tracking-widest text-gray-500">
                        <th class="p-6 font-bold w-1/3">Imóvel</th>
                        <th class="p-6 font-bold">Valor</th>
                        <th class="p-6 font-bold">Status</th>
                        <th class="p-6 font-bold">Responsável</th>
                        <th class="p-6 font-bold text-right">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($properties as $property)
                        <tr class="hover:bg-gray-50 transition-colors group">
                            
                            {{-- COLUNA 1: IMÓVEL --}}
                            <td class="p-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-16 h-16 rounded-md overflow-hidden bg-gray-100 flex-shrink-0 border border-gray-200 relative">
                                        @if($property->cover_image)
                                            <img src="{{ Storage::url($property->cover_image) }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-300">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            </div>
                                        @endif
                                        
                                        @if($property->is_featured)
                                            <div class="absolute top-0 right-0 bg-brand-gold w-3 h-3 rounded-bl-md" title="Destaque na Home"></div>
                                        @endif
                                    </div>
                                    <div>
                                        <a href="{{ route('admin.properties.edit', $property->id) }}" class="font-bold text-brand-dark text-sm hover:text-brand-gold transition-colors line-clamp-1">
                                            {{ $property->title }}
                                        </a>
                                        <p class="text-xs text-gray-400 mt-0.5 flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                            {{ $property->city ?? 'Sem Localização' }}
                                        </span>
                                        <div class="flex gap-2 mt-2">
                                            <span class="text-[9px] uppercase tracking-wider px-2 py-0.5 rounded bg-gray-100 text-gray-500 border border-gray-200">
                                                {{ $property->type }}
                                            </span>
                                            @if($property->visibility === 'off_market')
                                                <span class="text-[9px] uppercase tracking-wider px-2 py-0.5 rounded bg-purple-50 text-purple-700 border border-purple-100 font-bold flex items-center gap-1">
                                                    <svg class="w-2 h-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" /></svg>
                                                    Private
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- COLUNA 2: PREÇO --}}
                            <td class="p-6 text-sm text-gray-700 font-mono font-medium">
                                {{ number_format($property->price, 2, ',', '.') }} €
                            </td>

                            {{-- COLUNA 3: STATUS --}}
                            <td class="p-6">
                                @if($property->status === 'published')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide bg-green-50 text-green-700 border border-green-100">
                                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-2"></span>
                                        Publicado
                                    </span>
                                @elseif($property->status === 'pending')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide bg-yellow-50 text-yellow-700 border border-yellow-100 animate-pulse">
                                        <span class="w-1.5 h-1.5 bg-yellow-500 rounded-full mr-2"></span>
                                        Pendente
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide bg-gray-100 text-gray-600 border border-gray-200">
                                        Rascunho
                                    </span>
                                @endif
                            </td>

                            {{-- COLUNA 4: AUTOR --}}
                            <td class="p-6">
                                <div class="flex flex-col">
                                    <span class="text-sm font-medium text-gray-700">{{ $property->owner->name ?? 'Admin' }}</span>
                                    @if($property->owner && $property->owner->isDev())
                                        <span class="text-[9px] uppercase tracking-widest text-brand-gold">Parceiro / Dev</span>
                                    @elseif($property->owner && $property->owner->isAdmin())
                                        <span class="text-[9px] uppercase tracking-widest text-gray-400">Admin</span>
                                    @endif
                                </div>
                            </td>

                            {{-- COLUNA 5: AÇÕES --}}
                            <td class="p-6 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    
                                    {{-- LÓGICA DE APROVAÇÃO (SÓ ADMIN) --}}
                                    @if(Auth::user()->isAdmin() && $property->status === 'pending')
                                        <div class="flex bg-gray-100 rounded-md p-1 mr-2 border border-gray-200">
                                            <form action="{{ route('admin.properties.approve', $property->id) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="p-1.5 text-green-600 hover:bg-white hover:shadow-sm rounded transition-all" title="Aprovar Publicação">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                </button>
                                            </form>
                                            <div class="w-px bg-gray-300 mx-1"></div>
                                            <form action="{{ route('admin.properties.reject', $property->id) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="p-1.5 text-red-600 hover:bg-white hover:shadow-sm rounded transition-all" title="Rejeitar (Voltar para Rascunho)">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                                </button>
                                            </form>
                                        </div>
                                    @endif

                                    {{-- Botões Padrão --}}
                                    <a href="{{ route('admin.properties.edit', $property->id) }}" class="p-2 text-gray-400 hover:text-brand-dark hover:bg-gray-100 rounded transition-colors" title="Editar">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                    </a>
                                    
                                    @if($property->status === 'published' || Auth::user()->isAdmin())
                                        <a href="{{ route('properties.show', $property->slug ?? $property->id) }}" target="_blank" class="p-2 text-gray-400 hover:text-brand-dark hover:bg-gray-100 rounded transition-colors" title="Ver no Site">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                        </a>
                                    @endif

                                    {{-- Delete (Somente Admin ou Dono se for Draft) --}}
                                    <form action="{{ route('admin.properties.destroy', $property->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja apagar este imóvel permanentemente?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded transition-colors" title="Excluir">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-12 text-center text-gray-400">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                    <p class="text-sm font-medium">Nenhum imóvel encontrado nesta categoria.</p>
                                    @if($filter === 'pending')
                                        <p class="text-xs mt-1 text-gray-400">Não há imóveis aguardando aprovação no momento.</p>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($properties->hasPages())
            <div class="p-6 border-t border-gray-100 bg-gray-50">
                {{ $properties->appends(['filter' => $filter])->links() }}
            </div>
        @endif
    </div>
</div>
@endsection