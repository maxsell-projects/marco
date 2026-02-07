@extends('layouts.panel')

@section('content')
<div class="max-w-7xl mx-auto">
    
    {{-- HEADER DA ÁREA EXCLUSIVA --}}
    <div class="mb-10 text-center">
        <span class="text-xs font-bold tracking-widest text-brand-gold uppercase">Private Collection</span>
        <h2 class="font-serif text-3xl md:text-4xl text-brand-dark mt-2">Seus Imóveis Exclusivos</h2>
        <p class="text-gray-500 mt-4 max-w-2xl mx-auto">
            Esta é uma área reservada. Aqui estão listadas as oportunidades Off-Market que selecionamos especificamente para o seu perfil de investimento.
        </p>
    </div>

    {{-- LISTAGEM --}}
    @if($properties->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($properties as $property)
                <div class="group bg-white rounded-xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 overflow-hidden flex flex-col">
                    
                    {{-- IMAGEM COM BADGE --}}
                    <div class="relative aspect-[4/3] overflow-hidden">
                        <a href="{{ route('properties.show', $property->slug) }}">
                            @if($property->cover_image)
                                <img src="{{ Storage::url($property->cover_image) }}" alt="{{ $property->title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            @else
                                <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-400">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                            @endif
                        </a>
                        
                        <div class="absolute top-4 left-4">
                            <span class="bg-brand-dark text-white text-[10px] font-bold px-3 py-1 uppercase tracking-widest rounded-sm shadow-lg flex items-center gap-1">
                                <svg class="w-3 h-3 text-brand-gold" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" /></svg>
                                Private Access
                            </span>
                        </div>
                        
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4 pt-12">
                            <p class="text-white font-bold text-lg">{{ number_format($property->price, 0, ',', '.') }} €</p>
                        </div>
                    </div>

                    {{-- DETALHES --}}
                    <div class="p-6 flex-1 flex flex-col">
                        <div class="mb-4">
                            <p class="text-xs text-brand-gold uppercase tracking-wider font-bold mb-1">{{ $property->type }}</p>
                            <a href="{{ route('properties.show', $property->slug) }}" class="block font-serif text-xl text-brand-dark hover:text-brand-gold transition-colors line-clamp-2">
                                {{ $property->title }}
                            </a>
                            <p class="text-sm text-gray-500 mt-2 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                {{ $property->city }}
                            </p>
                        </div>

                        <div class="grid grid-cols-3 gap-2 border-t border-gray-100 pt-4 mt-auto mb-6">
                            <div class="text-center">
                                <span class="block text-lg font-bold text-brand-dark">{{ $property->bedrooms }}</span>
                                <span class="text-[10px] text-gray-400 uppercase">Quartos</span>
                            </div>
                            <div class="text-center border-l border-gray-100">
                                <span class="block text-lg font-bold text-brand-dark">{{ $property->bathrooms }}</span>
                                <span class="text-[10px] text-gray-400 uppercase">Banhos</span>
                            </div>
                            <div class="text-center border-l border-gray-100">
                                <span class="block text-lg font-bold text-brand-dark">{{ $property->area }}</span>
                                <span class="text-[10px] text-gray-400 uppercase">m²</span>
                            </div>
                        </div>

                        <a href="{{ route('properties.show', $property->slug) }}" class="w-full py-3 text-center border border-brand-dark text-brand-dark hover:bg-brand-dark hover:text-white transition-all text-xs font-bold uppercase tracking-widest rounded-sm">
                            Ver Detalhes Confidenciais
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-12">
            {{ $properties->links() }}
        </div>
    @else
        <div class="text-center py-20 bg-gray-50 rounded-xl border border-dashed border-gray-200">
            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            <h3 class="text-lg font-medium text-gray-900">Nenhum acesso exclusivo ativo</h3>
            <p class="text-gray-500 mt-2 max-w-md mx-auto">Você ainda não possui acesso a imóveis Off-Market. Entre em contato com seu consultor para solicitar acesso a oportunidades privadas.</p>
            <a href="{{ route('contact') }}" class="inline-block mt-6 px-6 py-2 bg-brand-dark text-white text-xs font-bold uppercase tracking-widest rounded-sm hover:bg-brand-gold transition-colors">
                Falar com Consultor
            </a>
        </div>
    @endif
</div>
@endsection