<!DOCTYPE html>
<html lang="pt-pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Imóvel | Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=GFS+Didot&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        serif: ['Playfair Display', 'serif'],
                        didot: ['GFS Didot', 'serif'],
                    }
                }
            }
        }
    </script>
    <style>
        /* Estilo para o botão de remover nas novas fotos */
        .remove-btn { opacity: 0; transition: opacity 0.2s; }
        .photo-container:hover .remove-btn { opacity: 1; }
    </style>
</head>
<body class="bg-gray-50 font-sans text-gray-900">
    <div class="flex h-screen">
        <aside class="w-64 bg-neutral-900 text-white p-6 shadow-xl z-20">
            <h1 class="font-didot text-2xl mb-8 tracking-widest text-center">DIOGO MAIA</h1>
            <nav class="space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-3 text-gray-400 hover:text-white rounded text-sm font-medium">Dashboard</a>
                <a href="{{ route('admin.properties.index') }}" class="block px-4 py-3 bg-[#c5a059] text-white rounded text-sm font-medium">Imóveis</a>
            </nav>
        </aside>

        <main class="flex-1 p-10 overflow-y-auto">
            <div class="max-w-5xl mx-auto">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-3xl font-serif text-gray-800">Editar Imóvel</h2>
                    <a href="{{ route('admin.properties.index') }}" class="text-gray-500 hover:text-gray-900 text-sm">← Voltar</a>
                </div>

                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                        <p class="font-bold">Atenção:</p>
                        <ul class="list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.properties.update', $property) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    @method('PUT')

                    <div class="bg-white p-8 rounded shadow-sm border border-gray-100">
                        <h3 class="text-lg font-serif mb-6 text-[#c5a059]">1. Informações Básicas</h3>
                        <div class="grid grid-cols-1 gap-6">
                            
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                                <div class="md:col-span-1">
                                    <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Ref. Interna</label>
                                    <input type="text" name="reference_code" value="{{ old('reference_code', $property->reference_code) }}" class="w-full border border-gray-200 rounded px-4 py-3 bg-gray-50 focus:bg-white transition" placeholder="Ex: IMO-2024">
                                </div>
                                <div class="md:col-span-3">
                                    <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Título do Anúncio</label>
                                    <input type="text" name="title" value="{{ old('title', $property->title) }}" required class="w-full border border-gray-200 rounded px-4 py-3 bg-gray-50 focus:bg-white transition-colors outline-none focus:border-[#c5a059]">
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Tipo</label>
                                    <select name="type" class="w-full border border-gray-200 rounded px-4 py-3 bg-white">
                                        <option value="Apartamento" {{ old('type', $property->type) == 'Apartamento' ? 'selected' : '' }}>Apartamento</option>
                                        <option value="Moradia" {{ old('type', $property->type) == 'Moradia' ? 'selected' : '' }}>Moradia / Villa</option>
                                        <option value="Terreno" {{ old('type', $property->type) == 'Terreno' ? 'selected' : '' }}>Terreno</option>
                                        <option value="Comercial" {{ old('type', $property->type) == 'Comercial' ? 'selected' : '' }}>Comercial</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Status</label>
                                    <select name="status" class="w-full border border-gray-200 rounded px-4 py-3 bg-white">
                                        <option value="Venda" {{ old('status', $property->status) == 'Venda' ? 'selected' : '' }}>Venda</option>
                                        <option value="Arrendamento" {{ old('status', $property->status) == 'Arrendamento' ? 'selected' : '' }}>Arrendamento</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Preço (€)</label>
                                    <input type="number" name="price" value="{{ old('price', $property->price) }}" class="w-full border border-gray-200 rounded px-4 py-3">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-8 rounded shadow-sm border border-gray-100">
                        <h3 class="text-lg font-serif mb-6 text-[#c5a059]">2. Localização e Dimensões</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                            <div>
                                <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Concelho / Zona</label>
                                <input type="text" name="location" value="{{ old('location', $property->location) }}" class="w-full border border-gray-200 rounded px-4 py-3">
                            </div>
                            <div>
                                <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Morada (Opcional)</label>
                                <input type="text" name="address" value="{{ old('address', $property->address) }}" class="w-full border border-gray-200 rounded px-4 py-3">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-5 gap-6">
                            <div>
                                <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Área Bruta (m²)</label>
                                <input type="number" name="area_gross" value="{{ old('area_gross', $property->area_gross) }}" class="w-full border border-gray-200 rounded px-4 py-3">
                            </div>
                            <div>
                                <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Quartos</label>
                                <input type="number" name="bedrooms" value="{{ old('bedrooms', $property->bedrooms) }}" class="w-full border border-gray-200 rounded px-4 py-3">
                            </div>
                            <div>
                                <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Casas de Banho</label>
                                <input type="number" name="bathrooms" value="{{ old('bathrooms', $property->bathrooms) }}" class="w-full border border-gray-200 rounded px-4 py-3">
                            </div>
                            <div>
                                <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Garagem (Lugares)</label>
                                <input type="number" name="garages" value="{{ old('garages', $property->garages) }}" class="w-full border border-gray-200 rounded px-4 py-3" placeholder="Ex: 2">
                            </div>
                            <div>
                                <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Cert. Energética</label>
                                <select name="energy_rating" class="w-full border border-gray-200 rounded px-4 py-3 bg-white">
                                    <option value="">Selecione</option>
                                    <option value="A+" {{ old('energy_rating', $property->energy_rating) == 'A+' ? 'selected' : '' }}>A+</option>
                                    <option value="A" {{ old('energy_rating', $property->energy_rating) == 'A' ? 'selected' : '' }}>A</option>
                                    <option value="B" {{ old('energy_rating', $property->energy_rating) == 'B' ? 'selected' : '' }}>B</option>
                                    <option value="C" {{ old('energy_rating', $property->energy_rating) == 'C' ? 'selected' : '' }}>C</option>
                                    <option value="D" {{ old('energy_rating', $property->energy_rating) == 'D' ? 'selected' : '' }}>D</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                            <div>
                                <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Andar</label>
                                <input type="text" name="floor" value="{{ old('floor', $property->floor) }}" class="w-full border border-gray-200 rounded px-4 py-3">
                            </div>
                            <div>
                                <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Orientação Solar</label>
                                <select name="orientation" class="w-full border border-gray-200 rounded px-4 py-3 bg-white">
                                    <option value="">Selecione</option>
                                    <option value="Norte" {{ old('orientation', $property->orientation) == 'Norte' ? 'selected' : '' }}>Norte</option>
                                    <option value="Sul" {{ old('orientation', $property->orientation) == 'Sul' ? 'selected' : '' }}>Sul</option>
                                    <option value="Este" {{ old('orientation', $property->orientation) == 'Este' ? 'selected' : '' }}>Este</option>
                                    <option value="Oeste" {{ old('orientation', $property->orientation) == 'Oeste' ? 'selected' : '' }}>Oeste</option>
                                    <option value="Nascente/Poente" {{ old('orientation', $property->orientation) == 'Nascente/Poente' ? 'selected' : '' }}>Nascente/Poente</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-8 rounded shadow-sm border border-gray-100">
                        <h3 class="text-lg font-serif mb-6 text-[#c5a059]">3. Comodidades</h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" name="has_pool" {{ old('has_pool', $property->has_pool) ? 'checked' : '' }} class="accent-[#c5a059] w-5 h-5"> <span class="text-sm">Piscina</span></label>
                            <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" name="has_garden" {{ old('has_garden', $property->has_garden) ? 'checked' : '' }} class="accent-[#c5a059] w-5 h-5"> <span class="text-sm">Jardim</span></label>
                            <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" name="has_lift" {{ old('has_lift', $property->has_lift) ? 'checked' : '' }} class="accent-[#c5a059] w-5 h-5"> <span class="text-sm">Elevador</span></label>
                            <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" name="has_terrace" {{ old('has_terrace', $property->has_terrace) ? 'checked' : '' }} class="accent-[#c5a059] w-5 h-5"> <span class="text-sm">Terraço</span></label>
                            <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" name="has_air_conditioning" {{ old('has_air_conditioning', $property->has_air_conditioning) ? 'checked' : '' }} class="accent-[#c5a059] w-5 h-5"> <span class="text-sm">Ar Condicionado</span></label>
                            <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" name="is_furnished" {{ old('is_furnished', $property->is_furnished) ? 'checked' : '' }} class="accent-[#c5a059] w-5 h-5"> <span class="text-sm">Mobilado</span></label>
                            <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" name="is_kitchen_equipped" {{ old('is_kitchen_equipped', $property->is_kitchen_equipped) ? 'checked' : '' }} class="accent-[#c5a059] w-5 h-5"> <span class="text-sm">Cozinha Equipada</span></label>
                        </div>
                    </div>

                    <div class="bg-white p-8 rounded shadow-sm border border-gray-100">
                        <h3 class="text-lg font-serif mb-6 text-[#c5a059]">4. Mídia e Links</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">WhatsApp</label>
                                <input type="text" name="whatsapp_number" value="{{ old('whatsapp_number', $property->whatsapp_number) }}" class="w-full border border-gray-200 rounded px-4 py-3">
                            </div>
                            <div>
                                <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Tour YouTube</label>
                                <input type="url" name="video_url" value="{{ old('video_url', $property->video_url) }}" class="w-full border border-gray-200 rounded px-4 py-3">
                            </div>
                        </div>

                        <div class="mb-6 flex gap-6 items-center">
                            <div class="w-24 h-24 bg-gray-100 rounded overflow-hidden border border-gray-200">
                                @if($property->cover_image)
                                    <img src="{{ asset('storage/'.$property->cover_image) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="flex items-center justify-center h-full text-gray-300 text-xs">Sem capa</div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Alterar Foto de Capa</label>
                                <input type="file" name="cover_image" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-[#c5a059]/10 file:text-[#c5a059]">
                            </div>
                        </div>

                        <hr class="my-6 border-gray-100">

                        @if($property->images && $property->images->count() > 0)
                            <div class="mb-6">
                                <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Galeria Atual (Já salvas)</label>
                                <div class="grid grid-cols-4 md:grid-cols-6 gap-4">
                                    @foreach($property->images as $image)
                                        <div class="relative h-20 rounded overflow-hidden border border-gray-200">
                                            <img src="{{ asset('storage/'.$image->path) }}" class="w-full h-full object-cover">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div>
                            <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Adicionar Novas Fotos (Acumulativo)</label>
                            
                            <input type="file" 
                                   id="gallery-input" 
                                   name="gallery[]" 
                                   multiple 
                                   accept="image/*" 
                                   class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 cursor-pointer">
                            
                            <p class="text-[10px] text-gray-400 mt-1">
                                Selecione as fotos que deseja <strong>adicionar</strong>. Pode selecionar várias vezes.
                            </p>

                            <div id="gallery-preview" class="grid grid-cols-3 md:grid-cols-5 gap-4 mt-4">
                                </div>
                        </div>
                    </div>

                    <div class="bg-white p-8 rounded shadow-sm border border-gray-100">
                        <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Descrição Completa</label>
                        <textarea name="description" rows="6" class="w-full border border-gray-200 rounded px-4 py-3 resize-y">{{ old('description', $property->description) }}</textarea>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-[#c5a059] text-white px-10 py-4 rounded text-xs uppercase tracking-widest font-bold hover:bg-[#b08d4b] transition shadow-lg transform hover:-translate-y-1">
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
                    div.className = "photo-container relative h-24 w-full rounded-lg overflow-hidden border border-gray-200 shadow-sm group";
                    
                    const img = document.createElement('img');
                    img.className = "h-full w-full object-cover";
                    
                    const btn = document.createElement('button');
                    btn.innerHTML = '&times;';
                    btn.className = "remove-btn absolute top-1 right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs shadow-md hover:bg-red-600 focus:outline-none";
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