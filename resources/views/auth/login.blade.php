<!DOCTYPE html>
<html lang="pt-pt" class="h-full bg-white">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Porthouse Private Office</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;500;600;700&family=Playfair+Display:wght@400;600&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            primary: '#8D182B',    // Bordeaux
                            secondary: '#1D4C42',  // Verde Inglês
                            sand: '#E5C2A4',       // Areia
                            text: '#1a1a1a',
                        }
                    },
                    fontFamily: {
                        sans: ['Manrope', 'sans-serif'],
                        serif: ['Playfair Display', 'serif'],
                    }
                }
            }
        }
    </script>
    <style>
        .bg-login {
            background-image: url('https://images.unsplash.com/photo-1600607687940-47a04f6e3773?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
<body class="h-full font-sans antialiased text-brand-text">

    <div class="flex min-h-full">
        <div class="relative hidden w-0 flex-1 lg:block">
            <div class="absolute inset-0 bg-login"></div>
            <div class="absolute inset-0 bg-brand-secondary/40 mix-blend-multiply"></div>
            
            <div class="absolute inset-0 flex items-center justify-center p-12">
                <div class="max-w-md text-center">
                    <img src="{{ asset('img/Ativo_5.png') }}" alt="Porthouse" class="mx-auto w-48 mb-8 brightness-0 invert">
                    <h1 class="font-serif text-4xl text-white italic tracking-wide">Exclusividade em cada detalhe.</h1>
                </div>
            </div>
        </div>

        <div class="flex flex-1 flex-col justify-center px-6 py-12 sm:px-12 lg:flex-none lg:px-24 xl:px-32 bg-white">
            <div class="mx-auto w-full max-w-sm lg:w-96">
                <div class="lg:hidden mb-10 text-center">
                    <img src="{{ asset('img/Ativo_5.png') }}" alt="Porthouse" class="mx-auto w-32">
                </div>

                <div class="text-left">
                    <h2 class="font-serif text-3xl font-semibold tracking-tight text-brand-text">Bem-vindo</h2>
                    <p class="mt-2 text-sm text-gray-500">Aceda ao seu Private Office para gerir os seus imóveis.</p>
                </div>

                <div class="mt-10">
                    <form action="{{ route('login.submit') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <div>
                            <label for="email" class="block text-xs font-bold uppercase tracking-widest text-brand-secondary">Endereço de Email</label>
                            <div class="mt-2">
                                <input id="email" name="email" type="email" autocomplete="email" required 
                                    class="block w-full border-0 border-b-2 border-gray-200 py-2 text-brand-text focus:border-brand-primary focus:ring-0 sm:text-sm transition-colors placeholder:text-gray-300"
                                    placeholder="exemplo@porthouse.pt">
                            </div>
                        </div>

                        <div>
                            <div class="flex items-center justify-between">
                                <label for="password" class="block text-xs font-bold uppercase tracking-widest text-brand-secondary">Senha</label>
                                <div class="text-xs">
                                    <a href="#" class="font-semibold text-brand-primary hover:text-brand-secondary transition-colors">Esqueceu-se?</a>
                                </div>
                            </div>
                            <div class="mt-2">
                                <input id="password" name="password" type="password" autocomplete="current-password" required 
                                    class="block w-full border-0 border-b-2 border-gray-200 py-2 text-brand-text focus:border-brand-primary focus:ring-0 sm:text-sm transition-colors">
                            </div>
                        </div>

                        @if($errors->any())
                            <div class="rounded-sm bg-red-50 p-4">
                                <div class="flex">
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-red-800">{{ $errors->first() }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="flex items-center">
                            <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-brand-primary focus:ring-brand-primary">
                            <label for="remember-me" class="ml-3 block text-sm text-gray-500">Lembrar-me neste dispositivo</label>
                        </div>

                        <div>
                            <button type="submit" 
                                class="flex w-full justify-center bg-brand-primary px-3 py-3 text-xs font-bold uppercase tracking-[0.2em] text-white shadow-lg hover:bg-brand-secondary focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-primary transition-all duration-300">
                                Entrar no Painel
                            </button>
                        </div>
                    </form>

                    <p class="mt-10 text-center text-xs text-gray-400 uppercase tracking-widest">
                        Porthouse Private Office &copy; {{ date('Y') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

</body>
</html>