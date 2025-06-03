<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="icon" type="image/svg+xml" href="https://www.svgrepo.com/show/452091/login.svg"/>
</head>
<body class="bg-gradient-to-br from-blue-200 via-blue-100 to-blue-400 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md bg-white/90 rounded-3xl shadow-2xl p-10 border border-blue-200 animate-fade-in flex flex-col items-center justify-center">
        <div class="flex flex-col items-center mb-8 w-full">
            <h1 class="text-4xl font-extrabold text-blue-700 mb-2 tracking-tight text-center">Entrar</h1>
        </div>
        
        @if ($errors->any())
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded text-sm w-full">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            
        <form method="POST" action="{{ route('login') }}" class="space-y-6 w-full flex flex-col items-center">
            @csrf
            <p class="text-gray-500 text-base text-center">Bem-vindo de volta! Faça login para continuar.</p>
            <div class="w-full">
                <label for="email" class="block text-gray-700 font-semibold mb-1">E-mail</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 transition shadow-sm">
            </div>
            <div class="w-full">
                <label for="password" class="block text-gray-700 font-semibold mb-1">Senha</label>
                <input type="password" name="password" id="password" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 transition shadow-sm">
            </div>
            <div class="flex items-center justify-between w-full">
                <div>
                    <input type="checkbox" name="remember" id="remember" class="mr-2 accent-blue-600">
                    <label for="remember" class="text-gray-600 text-sm">Lembrar-me</label>
                </div>
                <a href="#" class="text-blue-600 text-sm hover:underline">Esqueceu a senha?</a>
            </div>
            <button type="submit"
                class="w-full bg-gradient-to-r from-blue-600 to-blue-400 hover:from-blue-700 hover:to-blue-500 text-white font-bold py-2 px-4 rounded-xl shadow-lg transition-all duration-200 transform hover:scale-105">
                Entrar
            </button>
            <p class="mt-8 text-center text-gray-600 text-sm w-full">
                Não tem uma conta?
                <a href="{{ route('register') }}" class="text-blue-600 font-semibold hover:underline">Cadastre-se</a>
            </p>
        </form>

    </div>
    <style>
        .animate-fade-in {
            animation: fadeIn 1s ease;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px);}
            to { opacity: 1; transform: translateY(0);}
        }
    </style>
</body>
</html>