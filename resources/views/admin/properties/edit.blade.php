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

                <form action="{{ route('admin.properties.update', $property) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    @method('PUT')

                    <div class="bg-white p-8 rounded shadow-sm border border-gray-100">
                        <h3 class="text-lg font-serif mb-6 text-[#c5a059]">1. Informações Básicas</h3>
                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Título do Anúncio</label>
                                <input type="text" name="title" value="{{ $property->title }}" required class="w-full border border-gray-200 rounded px-4 py-3 bg-gray-50 focus:bg-white transition-colors outline-none focus:border-[#c5a059]">
                            </div>
                            
                            <div class="grid grid-cols-3 gap-6">
                                <div>
                                    <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Tipo</label>
                                    <select name="type" class="w-full border border-gray-200 rounded px-4 py-3 bg-white">
                                        <option value="Apartamento" {{ $property->type == 'Apartamento' ? 'selected' : '' }}>Apartamento</option>
                                        <option value="Moradia" {{ $property->type == 'Moradia' ? 'selected' : '' }}>Moradia / Villa</option>
                                        <option value="Terreno" {{ $property->type == 'Terreno' ? 'selected' : '' }}>Terreno</option>
                                        <option value="Comercial" {{ $property->type == 'Comercial' ? 'selected' : '' }}>Comercial</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Status</label>
                                    <select name="status" class="w-full border border-gray-200 rounded px-4 py-3 bg-white">
                                        <option value="Venda" {{ $property->status == 'Venda' ? 'selected' : '' }}>Venda</option>
                                        <option value="Arrendamento" {{ $property->status == 'Arrendamento' ? 'selected' : '' }}>Arrendamento</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Preço (€)</label>
                                    <input type="number" name="price" value="{{ $property->price }}" class="w-full border border-gray-200 rounded px-4 py-3">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-8 rounded shadow-sm border border-gray-100">
                        <h3 class="text-lg font-serif mb-6 text-[#c5a059]">2. Localização e Dimensões</h3>
                        <div class="grid grid-cols-2 gap-6 mb-4">
                            <div>
                                <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Concelho / Zona</label>
                                <input type="text" name="location" value="{{ $property->location }}" class="w-full border border-gray-200 rounded px-4 py-3">
                            </div>
                            <div>
                                <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Morada (Opcional)</label>
                                <input type="text" name="address" value="{{ $property->address }}" class="w-full border border-gray-200 rounded px-4 py-3">
                            </div>
                        </div>
                        <div class="grid grid-cols-4 gap-6">
                            <div>
                                <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Área Bruta (m²)</label>
                                <input type="number" name="area_gross" value="{{ $property->area_gross }}" class="w-full border border-gray-200 rounded px-4 py-3">
                            </div>
                            <div>
                                <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Quartos</label>
                                <input type="number" name="bedrooms" value="{{ $property->bedrooms }}" class="w-full border border-gray-200 rounded px-4 py-3">
                            </div>
                            <div>
                                <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Casas de Banho</label>
                                <input type="number" name="bathrooms" value="{{ $property->bathrooms }}" class="w-full border border-gray-200 rounded px-4 py-3">
                            </div>
                            <div>
                                <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Cert. Energética</label>
                                <select name="energy_rating" class="w-full border border-gray-200 rounded px-4 py-3 bg-white">
                                    <option value="">Selecione</option>
                                    <option value="A+" {{ $property->energy_rating == 'A+' ? 'selected' : '' }}>A+</option>
                                    <option value="A" {{ $property->energy_rating == 'A' ? 'selected' : '' }}>A</option>
                                    <option value="B" {{ $property->energy_rating == 'B' ? 'selected' : '' }}>B</option>
                                    <option value="C" {{ $property->energy_rating == 'C' ? 'selected' : '' }}>C</option>
                                </select>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-6 mt-4">
                            <div>
                                <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Andar</label>
                                <input type="text" name="floor" value="{{ $property->floor }}" class="w-full border border-gray-200 rounded px-4 py-3">
                            </div>
                            <div>
                                <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Orientação Solar</label>
                                <select name="orientation" class="w-full border border-gray-200 rounded px-4 py-3 bg-white">
                                    <option value="">Selecione</option>
                                    <option value="Norte" {{ $property->orientation == 'Norte' ? 'selected' : '' }}>Norte</option>
                                    <option value="Sul" {{ $property->orientation == 'Sul' ? 'selected' : '' }}>Sul</option>
                                    <option value="Este" {{ $property->orientation == 'Este' ? 'selected' : '' }}>Este</option>
                                    <option value="Oeste" {{ $property->orientation == 'Oeste' ? 'selected' : '' }}>Oeste</option>
                                    <option value="Nascente/Poente" {{ $property->orientation == 'Nascente/Poente' ? 'selected' : '' }}>Nascente/Poente</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-8 rounded shadow-sm border border-gray-100">
                        <h3 class="text-lg font-serif mb-6 text-[#c5a059]">3. Comodidades</h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" name="has_pool" {{ $property->has_pool ? 'checked' : '' }} class="accent-[#c5a059] w-5 h-5"> <span class="text-sm">Piscina</span></label>
                            <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" name="has_garden" {{ $property->has_garden ? 'checked' : '' }} class="accent-[#c5a059] w-5 h-5"> <span class="text-sm">Jardim</span></label>
                            <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" name="has_lift" {{ $property->has_lift ? 'checked' : '' }} class="accent-[#c5a059] w-5 h-5"> <span class="text-sm">Elevador</span></label>
                            <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" name="has_terrace" {{ $property->has_terrace ? 'checked' : '' }} class="accent-[#c5a059] w-5 h-5"> <span class="text-sm">Terraço</span></label>
                            <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" name="has_air_conditioning" {{ $property->has_air_conditioning ? 'checked' : '' }} class="accent-[#c5a059] w-5 h-5"> <span class="text-sm">Ar Condicionado</span></label>
                            <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" name="is_furnished" {{ $property->is_furnished ? 'checked' : '' }} class="accent-[#c5a059] w-5 h-5"> <span class="text-sm">Mobilado</span></label>
                            <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" name="is_kitchen_equipped" {{ $property->is_kitchen_equipped ? 'checked' : '' }} class="accent-[#c5a059] w-5 h-5"> <span class="text-sm">Cozinha Equipada</span></label>
                        </div>
                    </div>

                    <div class="bg-white p-8 rounded shadow-sm border border-gray-100">
                        <h3 class="text-lg font-serif mb-6 text-[#c5a059]">4. Mídia e Links</h3>
                        
                        <div class="grid grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">WhatsApp</label>
                                <input type="text" name="whatsapp_number" value="{{ $property->whatsapp_number }}" class="w-full border border-gray-200 rounded px-4 py-3">
                            </div>
                            <div>
                                <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Tour YouTube</label>
                                <input type="url" name="video_url" value="{{ $property->video_url }}" class="w-full border border-gray-200 rounded px-4 py-3">
                            </div>
                        </div>

                        <div class="mb-6 flex gap-6 items-center">
                            <div class="w-24 h-24 bg-gray-100 rounded overflow-hidden">
                                @if($property->cover_image)
                                    <img src="{{ asset('storage/'.$property->cover_image) }}" class="w-full h-full object-cover">
                                @endif
                            </div>
                            <div class="flex-1">
                                <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Nova Foto de Capa (Substituir)</label>
                                <input type="file" name="cover_image" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-[#c5a059]/10 file:text-[#c5a059]">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Adicionar Mais Fotos à Galeria</label>
                            <input type="file" name="gallery[]" multiple class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-gray-100 file:text-gray-700">
                        </div>
                    </div>

                    <div class="bg-white p-8 rounded shadow-sm border border-gray-100">
                        <label class="block text-xs uppercase tracking-widest text-gray-500 mb-2">Descrição Completa</label>
                        <textarea name="description" rows="6" class="w-full border border-gray-200 rounded px-4 py-3 resize-y">{{ $property->description }}</textarea>
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
</body>
</html>