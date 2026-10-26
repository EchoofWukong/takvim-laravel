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
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-slate-50 dark:bg-slate-900 text-slate-800 dark:text-slate-200 flex min-h-screen">

    <aside class="w-72 bg-white dark:bg-slate-800 border-r border-slate-200 dark:border-slate-700 flex flex-col shadow-lg">
        <div class="p-6 border-b border-slate-200 dark:border-slate-700">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold text-xl">
                    {{ substr(Auth::user()->name, 0, 1) }}{{ substr(Auth::user()->surname, 0, 1) }}
                </div>
                <div>
                    <h3 class="font-bold text-lg">{{ Auth::user()->name }} {{ Auth::user()->surname }}</h3>
                    @if(Auth::user()->is_admin)
                        <span class="text-xs bg-emerald-100 text-emerald-700 px-2 py-1 rounded-md font-bold">👑 Yönetici</span>
                    @else
                        <span class="text-xs bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 px-2 py-1 rounded-md">Öğretim Görevlisi</span>
                    @endif
                </div>
            </div>
        </div>

       <nav class="flex-1 p-4 space-y-2">
    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('dashboard') ? 'bg-indigo-50 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-400' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700/50' }} rounded-xl font-medium transition-colors">
        🏠 Görüntüleme (Canlı/Haftalık)
    </a>
    
    <a href="{{ route('planlama.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('planlama.*') ? 'bg-indigo-50 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-400' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700/50' }} rounded-xl font-medium transition-colors">
        ⚙️ Program & Veri Planlama
    </a>
    
    @if(Auth::user()->is_admin)
    <div class="mt-6 pt-4 border-t border-slate-200 dark:border-slate-700">
        <a href="#" class="flex items-center gap-3 px-4 py-3 hover:bg-slate-50 dark:hover:bg-slate-700/50 text-slate-600 dark:text-slate-300 rounded-xl font-medium transition-colors">
            👑 Genel Sistem Yönetimi
        </a>
    </div>
    @endif
</nav>

        <div class="mt-auto p-4 border-t border-slate-700/50">
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="flex items-center justify-center gap-3 w-full px-4 py-3 text-red-400 bg-red-500/10 hover:bg-red-500/20 hover:text-red-300 rounded-xl transition-all font-bold group shadow-sm border border-red-500/10">
            <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
            </svg>
            <span>Çıkış Yap</span>
        </button>
    </form>
</div>
    </aside>

    <main class="flex-1 p-8 overflow-y-auto">
        @yield('content')
    </main>

</body>
</html>