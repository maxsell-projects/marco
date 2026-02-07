@extends('layouts.panel')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h2 class="font-serif text-3xl text-brand-dark">Imóveis</h2>
        <p class="text-sm text-gray-500">Gerencie seu portfólio e acessos exclusivos.</p>
    </div>
    <a href="{{ route('admin.properties.create') }}" class="px-6 py-2 bg-brand-dark text-white text-sm font-bold uppercase tracking-widest hover:bg-brand-gold transition-colors shadow-lg">
        + Novo Imóvel
    </a>
</div>

<div class="bg-white rounded-xl shadow-[0_2px_20px_rgba(0,0,0,0.04)] border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase tracking-widest text-gray-400 font-bold">
                    <th class="p-6">Imóvel</th>
                    <th class="p-6">Preço</th>
                    <th class="p-6">Status</th>
                    <th class="p-6">Visibilidade</th>
                    <th class="p-6 text-right">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($properties as $property)
                <tr class="hover:bg-gray-50 transition-colors group">
                    <td class="p-6">
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 bg-gray-200 rounded-lg overflow-hidden flex-shrink-0">
                                @if($property->images->count() > 0)
                                    <img src="{{ asset('storage/' . $property->images->first()->path) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs">Sem Foto</div>
                                @endif
                            </div>
                            <div>
                                <a href="{{ route('admin.properties.edit', $property->id) }}" class="font-serif text-lg text-brand-dark hover:text-brand-gold transition-colors font-medium">
                                    {{ $property->title }}
                                </a>
                                <p class="text-xs text-gray-400 flex items-center gap-1 mt-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    {{ $property->city ?? 'N/A' }}
                                </p>
                            </div>
                        </div>
                    </td>
                    <td class="p-6 font-mono text-sm text-gray-600">
                        € {{ number_format($property->price, 0, ',', '.') }}
                    </td>
                    <td class="p-6">
                        @php
                            $statusClasses = [
                                'published' => 'bg-green-50 text-green-700 border-green-200',
                                'draft' => 'bg-gray-100 text-gray-600 border-gray-200',
                                'pending' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                            ];
                            $class = $statusClasses[$property->status] ?? 'bg-gray-100 text-gray-600';
                        @endphp
                        <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest border {{ $class }}">
                            {{ $property->status }}
                        </span>
                    </td>
                    <td class="p-6">
                         @php
                            $visClasses = [
                                'public' => 'text-blue-600',
                                'off_market' => 'text-purple-600 font-bold',
                                'private' => 'text-red-600',
                            ];
                            $vClass = $visClasses[$property->visibility] ?? 'text-gray-500';
                        @endphp
                        <div class="flex items-center gap-2 {{ $vClass }} text-xs font-bold uppercase tracking-wider">
                            @if($property->visibility === 'off_market')
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            @else
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            @endif
                            {{ str_replace('_', '-', $property->visibility) }}
                        </div>
                    </td>
                    <td class="p-6 text-right">
                        <div class="flex items-center justify-end gap-3 opacity-0 group-hover:opacity-100 transition-opacity">
                            <a href="{{ route('admin.properties.edit', $property->id) }}" class="text-gray-400 hover:text-brand-gold transition-colors" title="Editar">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            <form action="{{ route('admin.properties.destroy', $property->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este imóvel?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-gray-400 hover:text-red-600 transition-colors" title="Excluir">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-12 text-center text-gray-400">
                        <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        <p>Nenhum imóvel encontrado.</p>
                        <a href="{{ route('admin.properties.create') }}" class="text-brand-gold font-bold text-sm mt-2 hover:underline">Criar o primeiro</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($properties->hasPages())
        <div class="p-6 border-t border-gray-100">
            {{ $properties->links() }}
        </div>
    @endif
</div>
@endsection