@extends('layouts.admin')

@section('content')

{{-- HEADER --}}
<div class="flex justify-between items-center mb-8">
    <div>
        <h2 class="text-3xl font-didot text-brand-primary">Editar Imóvel</h2>
        <p class="text-xs text-gray-500 mt-1">
            A editar referência: <span class="font-bold text-brand-premium">{{ $property->reference_code ?? 'N/D' }}</span>
        </p>
    </div>
    <div class="flex gap-3">
        <a href="{{ route('properties.show', $property->slug) }}" target="_blank" class="px-4 py-2 border border-brand-primary/30 text-brand-primary rounded text-[10px] font-bold uppercase tracking-widest hover:bg-brand-primary hover:text-white transition">
            Ver no Site
        </a>
        <a href="{{ route('admin.properties.index') }}" class="px-6 py-2 border border-gray-300 text-gray-600 rounded text-[10px] font-bold uppercase tracking-widest hover:bg-white hover:border-gray-400 transition">
            Cancelar
        </a>
    </div>
</div>

{{-- FORMULÁRIO --}}
<div class="max-w-5xl mx-auto pb-20">
    
    @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-8 rounded shadow-sm">
            <p class="font-bold text-xs uppercase tracking-wide mb-2">Por favor corrija os erros:</p>
            <ul class="list-disc list-inside text-xs space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.properties.update', $property) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- SEÇÃO 1: VISIBILIDADE & IDENTIFICAÇÃO --}}
        <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-100 relative overflow-hidden">
            <div class="absolute top-0 right-0 p-8 bg-gray-50/50 border-l border-b border-gray-100 rounded-bl-xl">
                {{-- SWITCHES DE ESTADO --}}
                <div class="flex flex-col items-end gap-3">
                    <label class="relative inline-flex items-center cursor-pointer group">
                        <input type="checkbox" name="is_visible" value="1" class="sr-only peer" {{ old('is_visible', $property->is_visible) ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-brand-premium/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-500"></div>
                        <span class="ml-3 text-xs font-bold uppercase tracking-widest text-gray-600 group-hover:text-green-600 transition-colors">Publicar Online</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_featured" value="1" class="rounded border-gray-300 text-brand-premium focus:ring-brand-premium h-4 w-4" {{ old('is_featured', $property->is_featured) ? 'checked' : '' }}>
                        <span class="text-[10px] text-gray-400 font-bold uppercase tracking-widest hover:text-brand-premium transition-colors">Destacar na Home</span>
                    </label>
                </div>
            </div>

            <div class="flex items-center gap-3 mb-6 border-b border-gray-100 pb-4">
                <span class="flex items-center justify-center w-8 h-8 rounded-full bg-brand-premium/10 text-brand-premium font-serif font-bold text-sm">1</span>
                <h3 class="text-lg font-serif text-brand-primary">Identificação</h3>
            </div>
            
            <div class="grid grid-cols-1 gap-6 pr-0 md:pr-40">
                <div>
                    <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-2 font-bold">Título Comercial</label>
                    <input type="text" name="title" value="{{ old('title', $property->title) }}" required 
                           class="w-full border-gray-200 rounded px-4 py-3 focus:border-brand-cta focus:ring-0 transition text-sm font-medium">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-2 font-bold">Ref. Interna</label>
                        <input type="text" name="reference_code" value="{{ old('reference_code', $property->reference_code) }}" 
                               class="w-full border-gray-200 rounded px-4 py-3 bg-gray-50 focus:bg-white focus:border-brand-cta focus:ring-0 transition text-sm">
                    </div>
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-2 font-bold">Tipo</label>
                        <select name="type" class="w-full border-gray-200 rounded px-4 py-3 bg-white focus:border-brand-cta focus:ring-0 text-sm cursor-pointer">
                            @foreach(['Apartamento', 'Moradia', 'Terreno', 'Comercial'] as $type)
                                <option value="{{ $type }}" {{ old('type', $property->type) == $type ? 'selected' : '' }}>{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-2 font-bold">Preço (€)</label>
                        <input type="number" name="price" value="{{ old('price', $property->price) }}" 
                               class="w-full border-gray-200 rounded px-4 py-3 focus:border-brand-cta focus:ring-0 transition text-sm font-medium">
                    </div>
                </div>
                
                <div>
                     <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-2 font-bold">Estado Comercial</label>
                     <div class="flex gap-6">
                         <label class="flex items-center gap-2 cursor-pointer">
                             <input type="radio" name="status" value="Venda" {{ old('status', $property->status) == 'Venda' ? 'checked' : '' }} class="text-brand-cta focus:ring-brand-cta">
                             <span class="text-sm text-gray-600">Para Venda</span>
                         </label>
                         <label class="flex items-center gap-2 cursor-pointer">
                             <input type="radio" name="status" value="Arrendamento" {{ old('status', $property->status) == 'Arrendamento' ? 'checked' : '' }} class="text-brand-cta focus:ring-brand-cta">
                             <span class="text-sm text-gray-600">Para Arrendamento</span>
                         </label>
                     </div>
                </div>
            </div>
        </div>

        {{-- SEÇÃO 2: DETALHES TÉCNICOS --}}
        <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-100">
            <div class="flex items-center gap-3 mb-6 border-b border-gray-100 pb-4">
                <span class="flex items-center justify-center w-8 h-8 rounded-full bg-brand-premium/10 text-brand-premium font-serif font-bold text-sm">2</span>
                <h3 class="text-lg font-serif text-brand-primary">Caraterísticas</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-2 font-bold">Localização (Exibição)</label>
                    <input type="text" name="location" value="{{ old('location', $property->location) }}" 
                           class="w-full border-gray-200 rounded px-4 py-3 focus:border-brand-cta focus:ring-0 text-sm">
                </div>
                <div>
                    <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-2 font-bold">Morada (Privada)</label>
                    <input type="text" name="address" value="{{ old('address', $property->address) }}" 
                           class="w-full border-gray-200 rounded px-4 py-3 focus:border-brand-cta focus:ring-0 text-sm">
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-5 gap-6">
                <div>
                    <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-2 font-bold">Área (m²)</label>
                    <input type="number" name="area_gross" value="{{ old('area_gross', $property->area_gross) }}" class="w-full border-gray-200 rounded px-4 py-3 focus:border-brand-cta focus:ring-0 text-sm">
                </div>
                <div>
                    <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-2 font-bold">Quartos</label>
                    <input type="number" name="bedrooms" value="{{ old('bedrooms', $property->bedrooms) }}" class="w-full border-gray-200 rounded px-4 py-3 focus:border-brand-cta focus:ring-0 text-sm">
                </div>
                <div>
                    <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-2 font-bold">WC's</label>
                    <input type="number" name="bathrooms" value="{{ old('bathrooms', $property->bathrooms) }}" class="w-full border-gray-200 rounded px-4 py-3 focus:border-brand-cta focus:ring-0 text-sm">
                </div>
                <div>
                    <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-2 font-bold">Garagem</label>
                    <input type="number" name="garages" value="{{ old('garages', $property->garages) }}" class="w-full border-gray-200 rounded px-4 py-3 focus:border-brand-cta focus:ring-0 text-sm">
                </div>
                <div>
                    <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-2 font-bold">Cert. Energ.</label>
                    <select name="energy_rating" class="w-full border-gray-200 rounded px-4 py-3 bg-white focus:border-brand-cta focus:ring-0 text-sm">
                        <option value="">-</option>
                        @foreach(['A+', 'A', 'B', 'B-', 'C', 'D', 'E', 'F'] as $rating)
                            <option value="{{ $rating }}" {{ old('energy_rating', $property->energy_rating) == $rating ? 'selected' : '' }}>{{ $rating }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        {{-- SEÇÃO 3: AMENITIES --}}
        <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-100">
            <div class="flex items-center gap-3 mb-6 border-b border-gray-100 pb-4">
                <span class="flex items-center justify-center w-8 h-8 rounded-full bg-brand-premium/10 text-brand-premium font-serif font-bold text-sm">3</span>
                <h3 class="text-lg font-serif text-brand-primary">Amenities</h3>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach([
                    'has_pool' => 'Piscina', 
                    'has_garden' => 'Jardim', 
                    'has_lift' => 'Elevador', 
                    'has_terrace' => 'Terraço',
                    'has_air_conditioning' => 'Ar Condicionado',
                    'is_furnished' => 'Mobilado',
                    'is_kitchen_equipped' => 'Cozinha Equipada'
                ] as $field => $label)
                    <label class="flex items-center gap-3 p-3 border border-gray-100 rounded cursor-pointer hover:bg-gray-50 hover:border-brand-premium/30 transition-all select-none group">
                        <input type="checkbox" name="{{ $field }}" class="accent-brand-premium w-4 h-4 rounded border-gray-300 focus:ring-brand-premium text-brand-premium" {{ old($field, $property->$field) ? 'checked' : '' }}> 
                        <span class="text-xs font-medium text-gray-600 group-hover:text-brand-primary">{{ $label }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        {{-- SEÇÃO 4: MULTIMÉDIA --}}
        <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-100">
            <div class="flex items-center gap-3 mb-6 border-b border-gray-100 pb-4">
                <span class="flex items-center justify-center w-8 h-8 rounded-full bg-brand-premium/10 text-brand-premium font-serif font-bold text-sm">4</span>
                <h3 class="text-lg font-serif text-brand-primary">Galeria & Media</h3>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-6">
                {{-- Capa Atual --}}
                <div class="p-6 border border-gray-200 rounded-lg bg-gray-50/30">
                    <label class="block text-[10px] uppercase tracking-widest text-gray-500 mb-4 font-bold">Foto de Capa Atual</label>
                    <div class="flex items-start gap-4">
                        <div class="w-24 h-24 bg-white rounded overflow-hidden shadow-sm flex-shrink-0 border border-gray-200">
                            @if($property->cover_image)
                                <img src="{{ asset('storage/'.$property->cover_image) }}" class="w-full h-full object-cover">
                            @else
                                <div class="flex items-center justify-center h-full text-gray-300 bg-gray-100 text-xs">N/D</div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <p class="text-xs text-gray-400 mb-2">Para alterar, carregue uma nova imagem:</p>
                            <input type="file" name="cover_image" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-brand-primary file:text-white hover:file:bg-brand-cta cursor-pointer">
                        </div>
                    </div>
                </div>

                {{-- Upload Galeria --}}
                <div class="p-6 border-2 border-dashed border-gray-200 rounded-lg hover:border-brand-premium transition-colors bg-gray-50/50 flex flex-col justify-center">
                    <label class="block text-[10px] uppercase tracking-widest text-gray-500 mb-2 font-bold text-center">Adicionar Fotos à Galeria</label>
                    <input type="file" id="gallery-input" name="gallery[]" multiple accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-gray-200 file:text-gray-700 hover:file:bg-gray-300 cursor-pointer mx-auto">
                </div>
            </div>

            {{-- Preview de Uploads --}}
            <div id="gallery-preview" class="grid grid-cols-4 md:grid-cols-6 gap-4 mb-8 empty:hidden"></div>

            {{-- Galeria Existente --}}
            @if($property->images && $property->images->count() > 0)
                <div class="border-t border-gray-100 pt-6">
                    <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-3 font-bold">Galeria Existente</label>
                    <div class="grid grid-cols-4 md:grid-cols-6 gap-4">
                        @foreach($property->images as $image)
                            <div class="relative h-24 rounded overflow-hidden border border-gray-200 group">
                                <img src="{{ asset('storage/'.$image->path) }}" class="w-full h-full object-cover opacity-90 group-hover:opacity-100 transition">
                                {{-- Botão Delete visual (funcionalidade requer rota específica) --}}
                                <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                                    <span class="text-white text-xs">Existente</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        {{-- SEÇÃO 5: DESCRIÇÃO --}}
        <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-100">
            <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-4 font-bold">Descrição Editorial</label>
            <textarea name="description" rows="8" class="w-full border-gray-200 rounded px-4 py-3 focus:border-brand-cta focus:ring-0 text-sm leading-relaxed" placeholder="Descreva o imóvel...">{{ old('description', $property->description) }}</textarea>
        </div>

        {{-- SUBMIT --}}
        <div class="flex justify-end pt-4">
            <button type="submit" class="bg-brand-cta text-white px-12 py-4 rounded shadow-lg hover:bg-opacity-90 transition transform hover:-translate-y-1 font-bold uppercase text-xs tracking-widest flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                Guardar Alterações
            </button>
        </div>
    </form>
</div>

{{-- SCRIPT DA GALERIA --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('gallery-input');
        const previewContainer = document.getElementById('gallery-preview');
        const dt = new DataTransfer(); 

        input.addEventListener('change', function() {
            for(let i = 0; i < this.files.length; i++) {
                const file = this.files[i];
                dt.items.add(file);

                const div = document.createElement('div');
                div.className = "relative h-24 w-full rounded overflow-hidden border border-gray-200 shadow-sm group bg-white";
                
                const img = document.createElement('img');
                img.className = "h-full w-full object-cover opacity-90 hover:opacity-100 transition";
                
                const btn = document.createElement('button');
                btn.innerHTML = '&times;';
                btn.className = "absolute top-1 right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs shadow-md hover:bg-red-600 focus:outline-none z-10 opacity-0 group-hover:opacity-100 transition";
                btn.title = "Não enviar esta";
                
                const reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = function(e) { img.src = e.target.result; };

                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    div.remove();
                    updateInputFiles(file);
                });

                div.appendChild(img);
                div.appendChild(btn);
                previewContainer.appendChild(div);
            }
            this.files = dt.files;
        });

        function updateInputFiles(fileToRemove) {
            const newDt = new DataTransfer();
            for (let i = 0; i < dt.files.length; i++) {
                const file = dt.files[i];
                if (file !== fileToRemove) newDt.items.add(file);
            }
            dt.items.clear();
            for (let i = 0; i < newDt.files.length; i++) dt.items.add(newDt.files[i]);
            input.files = dt.files;
        }
    });
</script>

@endsection