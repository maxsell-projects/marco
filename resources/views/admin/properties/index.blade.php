<!DOCTYPE html>
<html lang="pt-pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imóveis | Admin</title>
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
    <div class="flex h-screen overflow-hidden">
        <aside class="w-64 bg-neutral-900 text-white flex flex-col shadow-xl z-20">
            <div class="p-8 text-center border-b border-white/10">
                <h1 class="font-didot text-2xl tracking-widest">DIOGO MAIA</h1>
                <p class="text-[10px] uppercase tracking-widest text-[#c5a059] mt-2">Admin Panel</p>
            </div>
            <nav class="flex-1 p-4 space-y-2 mt-4">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-gray-400 hover:bg-white/5 hover:text-white rounded text-sm font-medium transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    Dashboard
                </a>
                <a href="{{ route('admin.properties.index') }}" class="flex items-center gap-3 px-4 py-3 bg-[#c5a059] text-white rounded text-sm font-medium shadow-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    Gerir Imóveis
                </a>
                <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-3 px-4 py-3 text-gray-400 hover:bg-white/5 hover:text-white rounded text-sm font-medium transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    Ver Site
                </a>
            </nav>
            <div class="p-4 border-t border-white/10">
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-2 text-xs uppercase tracking-widest text-gray-500 hover:text-red-400 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Sair
                    </button>
                </form>
            </div>
        </aside>

        <main class="flex-1 p-10 overflow-y-auto">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-serif text-gray-800">Todos os Imóveis</h2>
                <a href="{{ route('admin.properties.create') }}" class="flex items-center gap-2 bg-[#c5a059] text-white px-6 py-3 rounded shadow hover:bg-[#b08d4b] transition font-bold uppercase text-xs tracking-widest">
                    <span>+</span> Novo Imóvel
                </a>
            </div>

            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b border-gray-200 text-xs uppercase text-gray-500 font-medium">
                        <tr>
                            <th class="px-6 py-4">Capa</th>
                            <th class="px-6 py-4">Título</th>
                            <th class="px-6 py-4">Preço</th>
                            <th class="px-6 py-4">Localização</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($properties as $property)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 w-24">
                                <div class="w-16 h-12 bg-gray-200 rounded overflow-hidden">
                                    @if($property->cover_image)
                                        <img src="{{ asset('storage/'.$property->cover_image) }}" class="w-full h-full object-cover">
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-800">{{ Str::limit($property->title, 40) }}</td>
                            <td class="px-6 py-4 text-gray-600">€ {{ number_format($property->price, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-gray-500">{{ $property->location }}</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider {{ $property->status == 'Venda' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                                    {{ $property->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right flex justify-end gap-3 items-center h-full">
                                <a href="{{ route('admin.properties.edit', $property) }}" class="text-[#c5a059] hover:text-[#b08d4b] text-xs font-bold uppercase tracking-widest border border-[#c5a059] px-3 py-1 rounded hover:bg-[#c5a059] hover:text-white transition">Editar</a>
                                
                                <form action="{{ route('admin.properties.destroy', $property) }}" method="POST" onsubmit="return confirm('Tem certeza?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-400 hover:text-red-600 text-xs font-bold uppercase tracking-widest px-3 py-1">Excluir</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-6">
                {{ $properties->links() }}
            </div>
        </main>
    </div>
</body>
</html>