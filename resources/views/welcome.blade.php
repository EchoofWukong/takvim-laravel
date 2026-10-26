<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akıllı Takvim & Asistan</title>
    <link rel="icon" href="{{ asset('favicon.ico?v=9999') }}" type="image/x-icon">
<link rel="shortcut icon" href="{{ asset('favicon.ico?v=9999') }}" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 dark:bg-slate-900 min-h-screen flex flex-col relative overflow-hidden">

    <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-indigo-500/20 blur-3xl rounded-full"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-96 h-96 bg-purple-500/20 blur-3xl rounded-full"></div>

    <header class="w-full p-6 flex justify-between items-center relative z-10">
        <div class="flex items-center gap-2">
            <div class="w-10 h-10 bg-indigo-600 text-white rounded-lg flex items-center justify-center font-bold text-xl shadow-md">
                🎓
            </div>
            <span class="font-bold text-xl text-slate-800 dark:text-white tracking-tight">Akıllı Takvim</span>
        </div>
        
        <div>
            @auth
                <a href="{{ url('/dashboard') }}" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl shadow-md transition-all">Sisteme Dön</a>
            @else
                <a href="{{ route('login') }}" class="px-5 py-2.5 text-slate-600 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400 font-medium transition-all mr-2">Giriş Yap</a>
                <a href="{{ route('register') }}" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl shadow-md transition-all">Kayıt Ol</a>
            @endauth
        </div>
    </header>

    <main class="flex-1 flex items-center justify-center relative z-10 px-4">
        <div class="max-w-3xl text-center">
            <div class="inline-block px-4 py-1.5 mb-6 rounded-full bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 text-sm font-semibold border border-indigo-200 dark:border-indigo-800/50">
                🚀 Kurumsal Bilişim Altyapısı
            </div>
            
            <h1 class="text-5xl md:text-6xl font-extrabold text-slate-900 dark:text-white leading-tight mb-6">
                Eğitim Planlamasında <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600">Akıllı Dönem</span>
            </h1>
            
            <p class="text-lg text-slate-600 dark:text-slate-400 mb-10 max-w-2xl mx-auto leading-relaxed">
                Öğretim görevlileri için geliştirilmiş, çakışmaları otomatik denetleyen, PDF destekli akıllı ders ve sınav yönetim asistanı.
            </p>

            @guest
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('register') }}" class="w-full sm:w-auto px-8 py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-2xl shadow-lg shadow-indigo-200 dark:shadow-none transition-transform hover:-translate-y-1">
                    Hemen Başlayın
                </a>
                <a href="{{ route('login') }}" class="w-full sm:w-auto px-8 py-4 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-white hover:bg-slate-50 dark:hover:bg-slate-700 font-semibold rounded-2xl shadow-sm transition-transform hover:-translate-y-1 flex items-center justify-center gap-2">
                    Mevcut Hesaba Giriş
                </a>
            </div>
            @endguest
        </div>
    </main>

    <footer class="p-6 text-center text-sm text-slate-500 dark:text-slate-500 relative z-10">
        &copy; {{ date('Y') }} Akıllı Eğitim Takvimi. Tüm hakları saklıdır.
    </footer>

</body>
</html>