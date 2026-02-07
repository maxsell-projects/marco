@extends('layouts.panel')

@section('content')
<div class="max-w-4xl mx-auto">
    
    <div class="mb-8 flex items-center justify-between">
        <div>
            <a href="{{ route('admin.properties.index') }}" class="text-xs font-bold text-gray-400 hover:text-brand-dark uppercase tracking-widest flex items-center gap-2 mb-2">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Voltar
            </a>
            <h2 class="font-serif text-3xl text-brand-dark">Editar Imóvel</h2>
        </div>
        <div class="flex gap-3">
             <a href="{{ route('properties.show', $property->slug ?? $property->id) }}" target="_blank" class="px-6 py-3 border border-brand-dark text-brand-dark text-sm font-bold uppercase tracking-widest hover:bg-brand-dark hover:text-white transition-colors rounded-sm">
                Ver no Site
            </a>
            <button type="submit" form="editPropertyForm" class="px-8 py-3 bg-brand-dark text-white text-sm font-bold uppercase tracking-widest hover:bg-brand-gold transition-colors shadow-lg rounded-sm">
                Atualizar
            </button>
        </div>
    </div>

    <form id="editPropertyForm" action="{{ route('admin.properties.update', $property->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')

        <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100">
            <h3 class="font-serif text-xl text-brand-dark mb-6 border-b border-gray-100 pb-2">Informações Básicas</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Título do Imóvel</label>
                    <input type="text" name="title" value="{{ old('title', $property->title) }}" class="w-full bg-gray-50 border border-gray-200 p-3 rounded text-gray-700 focus:outline-none focus:border-brand-gold focus:bg-white transition-all">
                </div>
                
                <div>
                    <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Preço (€)</label>
                    <input type="number" name="price" value="{{ old('price', $property->price) }}" class="w-full bg-gray-50 border border-gray-200 p-3 rounded text-gray-700 focus:outline-none focus:border-brand-gold focus:bg-white transition-all">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Área (m²)</label>
                    <input type="number" name="area" value="{{ old('area', $property->area) }}" class="w-full bg-gray-50 border border-gray-200 p-3 rounded text-gray-700 focus:outline-none focus:border-brand-gold focus:bg-white transition-all">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Descrição</label>
                    <textarea name="description" rows="4" class="w-full bg-gray-50 border border-gray-200 p-3 rounded text-gray-700 focus:outline-none focus:border-brand-gold focus:bg-white transition-all">{{ old('description', $property->description) }}</textarea>
                </div>
            </div>
        </div>

        <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100">
            <h3 class="font-serif text-xl text-brand-dark mb-6 border-b border-gray-100 pb-2">Detalhes & Localização</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Quartos</label>
                    <input type="number" name="bedrooms" value="{{ old('bedrooms', $property->bedrooms) }}" class="w-full bg-gray-50 border border-gray-200 p-3 rounded text-gray-700 focus:outline-none focus:border-brand-gold focus:bg-white transition-all">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Banheiros</label>
                    <input type="number" name="bathrooms" value="{{ old('bathrooms', $property->bathrooms) }}" class="w-full bg-gray-50 border border-gray-200 p-3 rounded text-gray-700 focus:outline-none focus:border-brand-gold focus:bg-white transition-all">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Garagem</label>
                    <input type="number" name="garage" value="{{ old('garage', $property->garage) }}" class="w-full bg-gray-50 border border-gray-200 p-3 rounded text-gray-700 focus:outline-none focus:border-brand-gold focus:bg-white transition-all">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Endereço</label>
                    <input type="text" name="address" value="{{ old('address', $property->address) }}" class="w-full bg-gray-50 border border-gray-200 p-3 rounded text-gray-700 focus:outline-none focus:border-brand-gold focus:bg-white transition-all">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Cidade</label>
                    <input type="text" name="city" value="{{ old('city', $property->city) }}" class="w-full bg-gray-50 border border-gray-200 p-3 rounded text-gray-700 focus:outline-none focus:border-brand-gold focus:bg-white transition-all">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Código Postal</label>
                    <input type="text" name="zip_code" value="{{ old('zip_code', $property->zip_code) }}" class="w-full bg-gray-50 border border-gray-200 p-3 rounded text-gray-700 focus:outline-none focus:border-brand-gold focus:bg-white transition-all">
                </div>
            </div>
        </div>

        <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 border-l-4 border-l-brand-gold">
            <h3 class="font-serif text-xl text-brand-dark mb-6 border-b border-gray-100 pb-2">Privacidade & Publicação</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Visibilidade</label>
                    <div class="relative">
                        <select name="visibility" class="w-full bg-gray-50 border border-gray-200 p-3 rounded text-gray-700 focus:outline-none focus:border-brand-gold focus:bg-white transition-all appearance-none">
                            <option value="public" {{ old('visibility', $property->visibility) == 'public' ? 'selected' : '' }}>Público (Visível no Site)</option>
                            <option value="off_market" {{ old('visibility', $property->visibility) == 'off_market' ? 'selected' : '' }}>Off-Market (Exclusivo)</option>
                            <option value="private" {{ old('visibility', $property->visibility) == 'private' ? 'selected' : '' }}>Privado (Apenas Link)</option>
                        </select>
                         <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Status</label>
                    <div class="relative">
                        <select name="status" class="w-full bg-gray-50 border border-gray-200 p-3 rounded text-gray-700 focus:outline-none focus:border-brand-gold focus:bg-white transition-all appearance-none">
                            <option value="draft" {{ old('status', $property->status) == 'draft' ? 'selected' : '' }}>Rascunho</option>
                            <option value="published" {{ old('status', $property->status) == 'published' ? 'selected' : '' }}>Publicado</option>
                        </select>
                         <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>
</div>
@endsection