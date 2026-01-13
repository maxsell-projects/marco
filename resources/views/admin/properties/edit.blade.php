<!DOCTYPE html>
<html lang="pt-pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Imóvel | José Carvalho Admin</title>
    
    {{-- FAVICON --}}
    <link rel="icon" href="{{ asset('img/favicon.png') }}" type="image/png">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link href="https://fonts.googleapis.com/css2?family=GFS+Didot&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <style>
        .remove-btn {
            opacity: 0;
            transition: all 0.3s;
        }
        .photo-container:hover .remove-btn {
            opacity: 1;
        }
    </style>
</head>
<body class="bg-[#F5F7FA] font-sans text-brand-text h-screen overflow-hidden">

    <div class="flex h-full">
        
        {{-- SIDEBAR --}}
        <aside class="w-72 bg-brand-primary text-white flex flex-col shadow-2xl z-20 relative">
            <div class="p-8 text-center border-b border-white/5 bg-black/10">
                <h1 class="font-didot text-2xl tracking-widest text-white">JOSÉ CARVALHO</h1>
                <p class="text-[10px] uppercase tracking-[0.3em] text-brand-premium mt-2">Private Office</p>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center gap-3 px-4 py-3 text-gray-400 hover:bg-white/5 hover:text-white rounded transition-colors text-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    Painel Geral
                </a>
                
                <a href="{{ route('admin.properties.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 bg-brand-premium/10 text-brand-premium border-l-2 border-brand-premium rounded-r text-sm font-medium transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    Gerir Imóveis
                </a>
            </nav>
        </aside>

        {{-- MAIN CONTENT --}}
        <main class="flex-1 overflow-y-auto">
            <header class="bg-white border-b border-gray-200 sticky top-0 z-30 px-8 py-4 flex justify-between items-center shadow-sm">
                <div>
                    <h2 class="text-xl font-serif text-brand-primary">Editar Imóvel</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Editando: <span class="font-bold text-brand-premium">{{ $property->reference_code ?? 'Sem Ref' }}</span></p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('admin.properties.index') }}" class="px-6 py-2.5 border border-gray-300 text-gray-600 rounded text-[10px] font-bold uppercase tracking-widest hover:bg-gray-50 transition">
                        Cancelar
                    </a>
                </div>
            </header>

            <div class="p-8 max-w-5xl mx-auto pb-20">
                
                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-8 rounded shadow-sm">
                        <div class="flex items-center gap-2 mb-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <p class="font-bold text-sm uppercase tracking-wide">Atenção Necessária</p>
                        </div>
                        <ul class="list-disc list-inside text-xs space-y-1 ml-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.properties.update', $property) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    @method('PUT')

                    {{-- SEÇÃO 1: DADOS PRINCIPAIS --}}
                    <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-100">
                        <div class="flex items-center gap-3 mb-6 border-b border-gray-100 pb-4">
                            <span class="flex items-center justify-center w-8 h-8 rounded-full bg-brand-premium/10 text-brand-premium font-serif font-bold text-sm">1</span>
                            <h3 class="text-lg font-serif text-brand-primary">Identificação do Ativo</h3>
                        </div>
                        
                        <div class="grid grid-cols-1 gap-6">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                                <div class="md:col-span-1">
                                    <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-2 font-bold">Ref. Interna</label>
                                    <input type="text" name="reference_code" value="{{ old('reference_code', $property->reference_code) }}" 
                                           class="w-full border-gray-200 rounded px-4 py-3 bg-gray-50 focus:bg-white focus:border-brand-cta focus:ring-0 transition text-sm" 
                                           placeholder="Ex: #JC-2024">
                                </div>
                                <div class="md:col-span-3">
                                    <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-2 font-bold">Título Comercial</label>
                                    <input type="text" name="title" value="{{ old('title', $property->title) }}" required 
                                           class="w-full border-gray-200 rounded px-4 py-3 focus:border-brand-cta focus:ring-0 transition text-sm font-medium">
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-2 font-bold">Tipo de Imóvel</label>
                                    <select name="type" class="w-full border-gray-200 rounded px-4 py-3 bg-white focus:border-brand-cta focus:ring-0 text-sm cursor-pointer">
                                        <option value="Apartamento" {{ old('type', $property->type) == 'Apartamento' ? 'selected' : '' }}>Apartamento</option>
                                        <option value="Moradia" {{ old('type', $property->type) == 'Moradia' ? 'selected' : '' }}>Moradia / Villa</option>
                                        <option value="Terreno" {{ old('type', $property->type) == 'Terreno' ? 'selected' : '' }}>Terreno</option>
                                        <option value="Comercial" {{ old('type', $property->type) == 'Comercial' ? 'selected' : '' }}>Comercial / Escritório</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-2 font-bold">Estado Comercial</label>
                                    <select name="status" class="w-full border-gray-200 rounded px-4 py-3 bg-white focus:border-brand-cta focus:ring-0 text-sm cursor-pointer">
                                        <option value="Venda" {{ old('status', $property->status) == 'Venda' ? 'selected' : '' }}>Para Venda</option>
                                        <option value="Arrendamento" {{ old('status', $property->status) == 'Arrendamento' ? 'selected' : '' }}>Para Arrendamento</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-2 font-bold">Preço (€)</label>
                                    <div class="relative">
                                        <span class="absolute left-4 top-3 text-gray-400 text-sm">€</span>
                                        <input type="number" name="price" value="{{ old('price', $property->price) }}" 
                                               class="w-full border-gray-200 rounded pl-8 pr-4 py-3 focus:border-brand-cta focus:ring-0 transition text-sm font-medium">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- SEÇÃO 2: DETALHES TÉCNICOS --}}
                    <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-100">
                        <div class="flex items-center gap-3 mb-6 border-b border-gray-100 pb-4">
                            <span class="flex items-center justify-center w-8 h-8 rounded-full bg-brand-premium/10 text-brand-premium font-serif font-bold text-sm">2</span>
                            <h3 class="text-lg font-serif text-brand-primary">Caraterísticas Técnicas</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-2 font-bold">Localização (Exibição)</label>
                                <input type="text" name="location" value="{{ old('location', $property->location) }}" 
                                       class="w-full border-gray-200 rounded px-4 py-3 focus:border-brand-cta focus:ring-0 text-sm">
                            </div>
                            <div>
                                <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-2 font-bold">Morada (Interna)</label>
                                <input type="text" name="address" value="{{ old('address', $property->address) }}" 
                                       class="w-full border-gray-200 rounded px-4 py-3 focus:border-brand-cta focus:ring-0 text-sm">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-5 gap-6">
                            <div>
                                <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-2 font-bold">Área Útil (m²)</label>
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
                                <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-2 font-bold">Estacionamento</label>
                                <input type="number" name="garages" value="{{ old('garages', $property->garages) }}" class="w-full border-gray-200 rounded px-4 py-3 focus:border-brand-cta focus:ring-0 text-sm" placeholder="Lugares">
                            </div>
                            <div>
                                <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-2 font-bold">Cert. Energética</label>
                                <select name="energy_rating" class="w-full border-gray-200 rounded px-4 py-3 bg-white focus:border-brand-cta focus:ring-0 text-sm cursor-pointer">
                                    <option value="">-</option>
                                    @foreach(['A+', 'A', 'B', 'B-', 'C', 'D', 'E', 'F'] as $rating)
                                        <option value="{{ $rating }}" {{ old('energy_rating', $property->energy_rating) == $rating ? 'selected' : '' }}>{{ $rating }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6 pt-6 border-t border-gray-50">
                            <div>
                                <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-2 font-bold">Piso / Andar</label>
                                <input type="text" name="floor" value="{{ old('floor', $property->floor) }}" class="w-full border-gray-200 rounded px-4 py-3 focus:border-brand-cta focus:ring-0 text-sm">
                            </div>
                            <div>
                                <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-2 font-bold">Exposição Solar</label>
                                <select name="orientation" class="w-full border-gray-200 rounded px-4 py-3 bg-white focus:border-brand-cta focus:ring-0 text-sm cursor-pointer">
                                    <option value="">Não especificado</option>
                                    <option value="Norte" {{ old('orientation', $property->orientation) == 'Norte' ? 'selected' : '' }}>Norte</option>
                                    <option value="Sul" {{ old('orientation', $property->orientation) == 'Sul' ? 'selected' : '' }}>Sul</option>
                                    <option value="Nascente" {{ old('orientation', $property->orientation) == 'Nascente' ? 'selected' : '' }}>Nascente (Este)</option>
                                    <option value="Poente" {{ old('orientation', $property->orientation) == 'Poente' ? 'selected' : '' }}>Poente (Oeste)</option>
                                    <option value="Nascente/Poente" {{ old('orientation', $property->orientation) == 'Nascente/Poente' ? 'selected' : '' }}>Nascente / Poente</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- SEÇÃO 3: COMODIDADES --}}
                    <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-100">
                        <div class="flex items-center gap-3 mb-6 border-b border-gray-100 pb-4">
                            <span class="flex items-center justify-center w-8 h-8 rounded-full bg-brand-premium/10 text-brand-premium font-serif font-bold text-sm">3</span>
                            <h3 class="text-lg font-serif text-brand-primary">Detalhes & Amenities</h3>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            @foreach([
                                'has_pool' => 'Piscina', 
                                'has_garden' => 'Jardim', 
                                'has_lift' => 'Elevador', 
                                'has_terrace' => 'Terraço / Varanda',
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
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <div>
                                <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-2 font-bold">WhatsApp</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-3 text-gray-400 text-sm">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                                    </span>
                                    <input type="text" name="whatsapp_number" value="{{ old('whatsapp_number', $property->whatsapp_number) }}" 
                                           class="w-full border-gray-200 rounded pl-10 pr-4 py-3 focus:border-brand-cta focus:ring-0 text-sm" 
                                           placeholder="351910000000">
                                </div>
                            </div>
                            <div>
                                <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-2 font-bold">Link Vídeo (YouTube)</label>
                                <input type="url" name="video_url" value="{{ old('video_url', $property->video_url) }}" 
                                       class="w-full border-gray-200 rounded px-4 py-3 focus:border-brand-cta focus:ring-0 text-sm" 
                                       placeholder="https://youtube.com/watch?v=...">
                            </div>
                        </div>

                        {{-- Capa Atual --}}
                        <div class="mb-8 flex gap-6 items-center bg-gray-50/50 p-6 rounded-lg border border-dashed border-gray-200">
                            <div class="w-24 h-24 bg-white rounded overflow-hidden shadow-sm flex-shrink-0">
                                @if($property->cover_image)
                                    <img src="{{ asset('storage/'.$property->cover_image) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="flex items-center justify-center h-full text-gray-300 text-xs bg-gray-50">N/D</div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <label class="block text-[10px] uppercase tracking-widest text-gray-500 mb-2 font-bold">Alterar Capa Principal</label>
                                <input type="file" name="cover_image" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-brand-primary file:text-white hover:file:bg-brand-cta cursor-pointer">
                            </div>
                        </div>

                        {{-- Galeria Existente --}}
                        @if($property->images && $property->images->count() > 0)
                            <div class="mb-8">
                                <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-3 font-bold">Galeria Atual</label>
                                <div class="grid grid-cols-4 md:grid-cols-6 gap-4">
                                    @foreach($property->images as $image)
                                        <div class="relative h-24 rounded overflow-hidden border border-gray-200 group">
                                            <img src="{{ asset('storage/'.$image->path) }}" class="w-full h-full object-cover opacity-90 group-hover:opacity-100 transition">
                                            {{-- Backend delete logic not implemented in view, purely visual for now --}}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Adicionar Novas Fotos --}}
                        <div class="p-6 border-2 border-dashed border-gray-200 rounded-lg hover:border-brand-premium transition-colors bg-white">
                            <label class="block text-[10px] uppercase tracking-widest text-gray-500 mb-4 font-bold text-center">Adicionar Novas Fotos</label>
                            <input type="file" id="gallery-input" name="gallery[]" multiple accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-300 cursor-pointer text-center mx-auto">
                            <p class="text-[10px] text-gray-400 mt-2 text-center">As novas fotos serão adicionadas à galeria existente.</p>
                            
                            <div id="gallery-preview" class="grid grid-cols-4 md:grid-cols-6 gap-4 mt-6"></div>
                        </div>
                    </div>

                    {{-- SEÇÃO 5: DESCRIÇÃO --}}
                    <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-100">
                        <label class="block text-[10px] uppercase tracking-widest text-gray-400 mb-4 font-bold">Descrição Editorial</label>
                        <textarea name="description" rows="8" 
                                  class="w-full border-gray-200 rounded px-4 py-3 focus:border-brand-cta focus:ring-0 text-sm leading-relaxed" 
                                  placeholder="Descreva o imóvel com pormenores envolventes...">{{ old('description', $property->description) }}</textarea>
                    </div>

                    {{-- SUBMIT --}}
                    <div class="flex justify-end pt-4">
                        <button type="submit" class="bg-brand-cta text-white px-12 py-4 rounded shadow-lg hover:bg-opacity-90 transition transform hover:-translate-y-1 font-bold uppercase text-xs tracking-widest flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                            Atualizar Imóvel
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>

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
                    div.className = "photo-container relative h-24 w-full rounded overflow-hidden border border-gray-200 shadow-sm group bg-white";
                    
                    const img = document.createElement('img');
                    img.className = "h-full w-full object-cover opacity-90 hover:opacity-100 transition";
                    
                    const btn = document.createElement('button');
                    btn.innerHTML = '&times;';
                    btn.className = "remove-btn absolute top-1 right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs shadow-md hover:bg-red-600 focus:outline-none z-10";
                    btn.title = "Remover (Não enviar esta)";

                    const reader = new FileReader();
                    reader.readAsDataURL(file);
                    reader.onload = function(e) {
                        img.src = e.target.result;
                    };

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
                    if (file !== fileToRemove) {
                        newDt.items.add(file);
                    }
                }
                dt.items.clear();
                for (let i = 0; i < newDt.files.length; i++) {
                    dt.items.add(newDt.files[i]);
                }
                input.files = dt.files;
            }
        });
    </script>
</body>
</html>