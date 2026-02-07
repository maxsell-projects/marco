@extends('layouts.panel')

@section('content')
<div class="max-w-6xl mx-auto">
    
    <div class="mb-8 flex items-center justify-between">
        <div>
            <a href="{{ route('admin.properties.index') }}" class="text-xs font-bold text-gray-400 hover:text-brand-dark uppercase tracking-widest flex items-center gap-2 mb-2">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Voltar
            </a>
            <h2 class="font-serif text-3xl text-brand-dark">Editar Imóvel</h2>
        </div>
        <div class="flex gap-3">
             <a href="{{ route('properties.show', $property->slug ?? $property->id) }}" target="_blank" class="px-6 py-3 border border-brand-dark text-brand-dark text-sm font-bold uppercase tracking-widest hover:bg-brand-dark hover:text-white transition-colors rounded-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                Ver no Site
            </a>
            <button type="submit" form="editPropertyForm" class="px-8 py-3 bg-brand-dark text-white text-sm font-bold uppercase tracking-widest hover:bg-brand-gold transition-colors shadow-lg rounded-sm">
                Atualizar
            </button>
        </div>
    </div>

    @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-red-700 font-bold">Encontramos erros no formulário:</p>
                    <ul class="list-disc list-inside text-sm text-red-600 mt-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <form id="editPropertyForm" action="{{ route('admin.properties.update', $property->id) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')

        <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100">
            <h3 class="font-serif text-xl text-brand-dark mb-6 border-b border-gray-100 pb-2">Mídia & Galeria</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="col-span-1">
                    <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Imagem de Capa</label>
                    <div class="relative w-full h-48 border-2 border-dashed border-gray-300 rounded-lg flex flex-col justify-center items-center bg-gray-50 hover:bg-gray-100 transition cursor-pointer group overflow-hidden">
                        <input type="file" name="cover_image" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" onchange="previewCover(this)">
                        
                        <img id="cover-preview" 
                             src="{{ $property->cover_image ? Storage::url($property->cover_image) : '' }}" 
                             class="absolute inset-0 w-full h-full object-cover {{ $property->cover_image ? '' : 'hidden' }}" />
                        
                        <div id="cover-placeholder" class="text-center {{ $property->cover_image ? 'hidden' : '' }}">
                            <svg class="mx-auto h-10 w-10 text-gray-400 group-hover:text-brand-gold transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <p class="mt-2 text-xs text-gray-500">Alterar Capa</p>
                        </div>
                    </div>
                </div>

                <div class="col-span-2">
                    <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Adicionar Fotos à Galeria</label>
                    
                    @if($property->images->count() > 0)
                        <div class="mb-3 flex gap-2 overflow-x-auto pb-2">
                            @foreach($property->images as $img)
                                <div class="relative flex-shrink-0 w-20 h-20 rounded overflow-hidden border border-gray-200 group">
                                    <img src="{{ Storage::url($img->path) }}" class="w-full h-full object-cover">
                                    </div>
                            @endforeach
                        </div>
                    @endif

                    <div class="relative w-full h-24 border-2 border-dashed border-gray-300 rounded-lg flex flex-col justify-center items-center bg-gray-50 hover:bg-gray-100 transition cursor-pointer group">
                        <input type="file" name="gallery[]" multiple class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" id="gallery-input">
                        <div class="text-center pointer-events-none">
                            <p class="text-xs text-gray-500 group-hover:text-brand-gold">
                                + Adicionar novas fotos
                            </p>
                            <p class="text-[10px] text-gray-400 mt-1" id="gallery-count">Nenhuma nova foto selecionada</p>
                        </div>
                    </div>
                </div>

                <div class="col-span-3">
                    <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">URL do Vídeo</label>
                    <input type="url" name="video_url" value="{{ old('video_url', $property->video_url) }}" class="w-full bg-gray-50 border border-gray-200 p-3 rounded text-gray-700 text-sm focus:outline-none focus:border-brand-gold">
                </div>
            </div>
        </div>

        <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100">
            <h3 class="font-serif text-xl text-brand-dark mb-6 border-b border-gray-100 pb-2">Informações Principais</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Título do Imóvel *</label>
                    <input type="text" name="title" required value="{{ old('title', $property->title) }}" class="w-full bg-gray-50 border border-gray-200 p-3 rounded text-gray-700 focus:outline-none focus:border-brand-gold font-bold">
                </div>
                
                <div>
                    <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Tipo de Imóvel *</label>
                    <select name="type" required class="w-full bg-gray-50 border border-gray-200 p-3 rounded text-gray-700 focus:outline-none focus:border-brand-gold">
                        @foreach(['Apartamento', 'Moradia', 'Terreno', 'Comercial'] as $type)
                            <option value="{{ $type }}" {{ old('type', $property->type) == $type ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Preço (€) *</label>
                    <input type="number" name="price" required step="0.01" value="{{ old('price', $property->price) }}" class="w-full bg-gray-50 border border-gray-200 p-3 rounded text-gray-700 focus:outline-none focus:border-brand-gold">
                </div>

                <div class="grid grid-cols-3 gap-4 md:col-span-2">
                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-500 mb-2">Área Bruta (m²)</label>
                        <input type="number" name="area_gross" step="0.01" value="{{ old('area_gross', $property->area_gross) }}" class="w-full bg-gray-50 border border-gray-200 p-3 rounded text-gray-700 text-sm focus:outline-none focus:border-brand-gold">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-500 mb-2">Área Útil (m²)</label>
                        <input type="number" name="area_useful" step="0.01" value="{{ old('area_useful', $property->area_useful) }}" class="w-full bg-gray-50 border border-gray-200 p-3 rounded text-gray-700 text-sm focus:outline-none focus:border-brand-gold">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-widest text-gray-500 mb-2">Área Terreno (m²)</label>
                        <input type="number" name="area_land" step="0.01" value="{{ old('area_land', $property->area_land) }}" class="w-full bg-gray-50 border border-gray-200 p-3 rounded text-gray-700 text-sm focus:outline-none focus:border-brand-gold">
                    </div>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Descrição Detalhada</label>
                    <textarea name="description" rows="5" class="w-full bg-gray-50 border border-gray-200 p-3 rounded text-gray-700 focus:outline-none focus:border-brand-gold">{{ old('description', $property->description) }}</textarea>
                </div>
            </div>
        </div>

        <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100">
            <h3 class="font-serif text-xl text-brand-dark mb-6 border-b border-gray-100 pb-2">Detalhes & Características</h3>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Quartos</label>
                    <input type="number" name="bedrooms" value="{{ old('bedrooms', $property->bedrooms) }}" class="w-full bg-gray-50 border border-gray-200 p-3 rounded text-gray-700 text-sm focus:outline-none focus:border-brand-gold">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Banheiros</label>
                    <input type="number" name="bathrooms" value="{{ old('bathrooms', $property->bathrooms) }}" class="w-full bg-gray-50 border border-gray-200 p-3 rounded text-gray-700 text-sm focus:outline-none focus:border-brand-gold">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Garagens</label>
                    <input type="number" name="garages" value="{{ old('garages', $property->garages) }}" class="w-full bg-gray-50 border border-gray-200 p-3 rounded text-gray-700 text-sm focus:outline-none focus:border-brand-gold">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Ano Construção</label>
                    <input type="number" name="built_year" value="{{ old('built_year', $property->built_year) }}" class="w-full bg-gray-50 border border-gray-200 p-3 rounded text-gray-700 text-sm focus:outline-none focus:border-brand-gold">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Cert. Energético</label>
                    <input type="text" name="energy_rating" value="{{ old('energy_rating', $property->energy_rating) }}" class="w-full bg-gray-50 border border-gray-200 p-3 rounded text-gray-700 text-sm focus:outline-none focus:border-brand-gold">
                </div>
                 <div>
                    <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Condição</label>
                    <select name="condition" class="w-full bg-gray-50 border border-gray-200 p-3 rounded text-gray-700 text-sm focus:outline-none focus:border-brand-gold">
                        @foreach(['used'=>'Usado', 'new'=>'Novo', 'renovated'=>'Renovado', 'construction'=>'Em Construção'] as $val => $label)
                            <option value="{{ $val }}" {{ old('condition', $property->condition) == $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-4">Comodidades</label>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach(['has_lift'=>'Elevador', 'has_garden'=>'Jardim', 'has_pool'=>'Piscina', 'has_terrace'=>'Terraço', 'has_balcony'=>'Varanda', 'has_air_conditioning'=>'Ar Condicionado', 'has_heating'=>'Aquecimento', 'is_accessible'=>'Acessível', 'is_furnished'=>'Mobiliado', 'is_kitchen_equipped'=>'Cozinha Equip.'] as $field => $label)
                <label class="flex items-center space-x-3 p-3 border border-gray-100 rounded hover:bg-gray-50 cursor-pointer">
                    <input type="checkbox" name="{{ $field }}" value="1" 
                           {{ old($field, $property->$field) ? 'checked' : '' }} 
                           class="form-checkbox h-4 w-4 text-brand-dark border-gray-300 rounded focus:ring-brand-gold">
                    <span class="text-sm text-gray-700">{{ $label }}</span>
                </label>
                @endforeach
            </div>
        </div>

        <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100">
            <h3 class="font-serif text-xl text-brand-dark mb-6 border-b border-gray-100 pb-2">Localização</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Endereço Completo</label>
                    <input type="text" name="address" value="{{ old('address', $property->address) }}" class="w-full bg-gray-50 border border-gray-200 p-3 rounded text-gray-700 focus:outline-none focus:border-brand-gold">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Cidade</label>
                    <input type="text" name="city" value="{{ old('city', $property->city) }}" class="w-full bg-gray-50 border border-gray-200 p-3 rounded text-gray-700 focus:outline-none focus:border-brand-gold">
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Código Postal</label>
                    <input type="text" name="postal_code" value="{{ old('postal_code', $property->postal_code) }}" class="w-full bg-gray-50 border border-gray-200 p-3 rounded text-gray-700 focus:outline-none focus:border-brand-gold">
                </div>
            </div>
        </div>

        <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 border-l-4 border-l-brand-gold">
            <h3 class="font-serif text-xl text-brand-dark mb-6 border-b border-gray-100 pb-2">Publicação</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Visibilidade</label>
                    <select name="visibility" class="w-full bg-gray-50 border border-gray-200 p-3 rounded text-gray-700 focus:outline-none focus:border-brand-gold">
                        <option value="public" {{ old('visibility', $property->visibility) == 'public' ? 'selected' : '' }}>Público (Site)</option>
                        <option value="off_market" {{ old('visibility', $property->visibility) == 'off_market' ? 'selected' : '' }}>Off-Market (Exclusivo)</option>
                        <option value="private" {{ old('visibility', $property->visibility) == 'private' ? 'selected' : '' }}>Privado</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-widest text-gray-500 mb-2">Status</label>
                    <select name="status" class="w-full bg-gray-50 border border-gray-200 p-3 rounded text-gray-700 focus:outline-none focus:border-brand-gold">
                        <option value="published" {{ old('status', $property->status) == 'published' ? 'selected' : '' }}>Publicado</option>
                        <option value="draft" {{ old('status', $property->status) == 'draft' ? 'selected' : '' }}>Rascunho</option>
                        <option value="pending" {{ old('status', $property->status) == 'pending' ? 'selected' : '' }}>Pendente</option>
                    </select>
                </div>
            </div>
            
            <div class="mt-6 flex gap-6">
                <label class="flex items-center space-x-3">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $property->is_featured) ? 'checked' : '' }} class="form-checkbox h-4 w-4 text-brand-gold border-gray-300 rounded">
                    <span class="text-sm font-bold text-gray-700">Destacar na Home?</span>
                </label>
            </div>
        </div>

    </form>
</div>

<script>
    // Preview simples para Capa
    function previewCover(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('cover-preview').src = e.target.result;
                document.getElementById('cover-preview').classList.remove('hidden');
                document.getElementById('cover-placeholder').classList.add('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Contador simples para Galeria
    const galleryInput = document.getElementById('gallery-input');
    const galleryCount = document.getElementById('gallery-count');
    
    galleryInput.addEventListener('change', function() {
        if(this.files.length > 0) {
            galleryCount.textContent = this.files.length + " novo(s) arquivo(s) selecionado(s)";
            galleryCount.classList.remove('text-gray-400');
            galleryCount.classList.add('text-brand-dark', 'font-bold');
        } else {
            galleryCount.textContent = "Nenhuma nova foto selecionada";
        }
    });
</script>
@endsection