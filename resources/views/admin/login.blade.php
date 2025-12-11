<!DOCTYPE html>
<html lang="pt-pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Diogo Maia</title>
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
<body class="bg-neutral-900 font-sans antialiased text-white h-screen flex items-center justify-center relative overflow-hidden">

    <div class="absolute inset-0 z-0">
        <img src="{{ asset('img/porto.jpg') }}" class="w-full h-full object-cover opacity-40">
        <div class="absolute inset-0 bg-black/50"></div>
    </div>

    <div class="w-full max-w-md bg-black/60 border border-white/10 p-8 rounded-lg backdrop-blur-md shadow-2xl relative z-10">
        <div class="text-center mb-8">
            <h1 class="font-didot text-4xl mb-2 tracking-widest text-white">DIOGO MAIA</h1>
            <p class="text-xs uppercase tracking-[0.3em] text-[#c5a059]">Área Administrativa</p>
        </div>

        <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-6">
            @csrf
            
            <div>
                <label for="email" class="block text-xs uppercase tracking-widest text-gray-300 mb-2">Email</label>
                <input type="email" name="email" id="email" required autofocus
                       class="w-full bg-white/5 border border-white/20 rounded px-4 py-3 text-white focus:outline-none focus:border-[#c5a059] transition-colors placeholder-white/30">
                @error('email')
                    <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-xs uppercase tracking-widest text-gray-300 mb-2">Senha</label>
                <input type="password" name="password" id="password" required
                       class="w-full bg-white/5 border border-white/20 rounded px-4 py-3 text-white focus:outline-none focus:border-[#c5a059] transition-colors placeholder-white/30">
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="remember" class="accent-[#c5a059] w-4 h-4 bg-white/10 border-white/20 rounded">
                    <span class="text-xs text-gray-300">Lembrar-me</span>
                </label>
            </div>

            <button type="submit" class="w-full bg-[#c5a059] text-white font-bold py-4 uppercase tracking-widest text-xs hover:bg-[#b08d4b] transition-colors rounded shadow-lg">
                Entrar
            </button>
        </form>

        <div class="mt-8 text-center">
            <a href="{{ route('home') }}" class="text-xs text-gray-400 hover:text-white transition-colors uppercase tracking-widest">← Voltar ao Site</a>
        </div>
    </div>

</body>
</html>