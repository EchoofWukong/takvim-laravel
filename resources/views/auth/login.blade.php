<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş Yap | Akıllı Eğitim Takvimi</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 dark:bg-slate-900 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-slate-100 dark:border-slate-700 overflow-hidden transition-all p-8">
        
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-indigo-600 text-white font-bold text-xl mb-3 shadow-md shadow-indigo-200 dark:shadow-none">
                🎓
            </div>
            <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Tekrar Hoş Geldiniz</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Lütfen hesabınıza giriş yapın</p>
        </div>

        @if (session('success'))
            <div class="mb-5 p-4 bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-400 rounded-xl text-sm font-medium shadow-sm flex items-center gap-2">
                <span>✅</span> {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" onsubmit="this.querySelector('button[type=submit]').disabled = true; this.querySelector('button[type=submit]').innerText = 'Giriş Yapılıyor...';">
            @csrf

            <div class="mb-5">
                <label for="email" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">E-Posta Adresi</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="ornek@universite.edu.tr" 
                    class="w-full px-4 py-2.5 border border-slate-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-slate-700 dark:text-white placeholder-slate-400 transition-all outline-none">
                @if($errors->get('email'))
                    <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $errors->first('email') }}</p>
                @endif
            </div>

            <div class="mb-5">
                <div class="flex items-center justify-between mb-1.5">
                    <label for="password" class="block text-sm font-semibold text-slate-700 dark:text-slate-300">Şifre</label>
                    @if (Route::has('password.request'))
                        <a class="text-xs font-medium text-indigo-600 hover:text-indigo-700 dark:text-indigo-400" href="{{ route('password.request') }}">
                            Şifremi Unuttum
                        </a>
                    @endif
                </div>
                <input id="password" type="password" name="password" required placeholder="••••••••" 
                    class="w-full px-4 py-2.5 border border-slate-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-slate-700 dark:text-white placeholder-slate-400 transition-all outline-none">
                @if($errors->get('password'))
                    <p class="text-red-500 text-xs mt-1.5 font-medium">{{ $errors->first('password') }}</p>
                @endif
            </div>

            <div class="flex items-center mb-6">
                <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500 dark:bg-slate-700 dark:border-slate-600">
                <label for="remember_me" class="ml-2 text-sm text-slate-600 dark:text-slate-400 cursor-pointer select-none">Beni Hatırla</label>
            </div>

            <button type="submit" class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl shadow-md shadow-indigo-100 dark:shadow-none transition-all duration-150 text-sm">
                Giriş Yap
            </button>

            <div class="text-center mt-6 pt-5 border-t border-slate-100 dark:border-slate-700/60">
                <p class="text-sm text-slate-600 dark:text-slate-400">
                    Henüz hesabınız yok mu? 
                    <a class="font-semibold text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 ml-1" href="{{ route('register') }}">
                        Yeni Hesap Oluştur
                    </a>
                </p>
            </div>
        </form>
    </div>

</body>
</html>