<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kayıt Ol | Akıllı Eğitim Takvimi</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 dark:bg-slate-900 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-md bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-slate-100 dark:border-slate-700 overflow-hidden transition-all p-8">
        
        <div class="text-center mb-6">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-indigo-600 text-white font-bold text-xl mb-3 shadow-md shadow-indigo-200 dark:shadow-none">
                ✍️
            </div>
            <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Yeni Öğretim Görevlisi Kaydı</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Sisteme dahil olmak için bilgilerinizi eksiksiz doldurun</p>
        </div>

        <form method="POST" action="{{ route('register') }}" onsubmit="this.querySelector('button[type=submit]').disabled = true; this.querySelector('button[type=submit]').innerText = 'Kaydediliyor...';">
            @csrf

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="name" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">İsim</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus placeholder="Ahmet"
                        class="w-full px-4 py-2 border border-slate-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-slate-700 dark:text-white placeholder-slate-400 transition-all outline-none text-sm">
                    @if($errors->get('name'))
                        <p class="text-red-500 text-[11px] mt-1 font-medium">{{ $errors->first('name') }}</p>
                    @endif
                </div>

                <div>
                    <label for="surname" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Soyisim</label>
                    <input id="surname" type="text" name="surname" value="{{ old('surname') }}" required placeholder="Yılmaz"
                        class="w-full px-4 py-2 border border-slate-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-slate-700 dark:text-white placeholder-slate-400 transition-all outline-none text-sm">
                    @if($errors->get('surname'))
                        <p class="text-red-500 text-[11px] mt-1 font-medium">{{ $errors->first('surname') }}</p>
                    @endif
                </div>
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">E-Posta Adresi</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required placeholder="ahmet.yilmaz@universite.edu.tr" 
                    class="w-full px-4 py-2 border border-slate-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-slate-700 dark:text-white placeholder-slate-400 transition-all outline-none text-sm">
                @if($errors->get('email'))
                    <p class="text-red-500 text-xs mt-1 font-medium">{{ $errors->first('email') }}</p>
                @endif
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Şifre</label>
                <input id="password" type="password" name="password" required placeholder="Minimum 8 karakter" 
                    class="w-full px-4 py-2 border border-slate-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-slate-700 dark:text-white placeholder-slate-400 transition-all outline-none text-sm">
                @if($errors->get('password'))
                    <p class="text-red-500 text-xs mt-1 font-medium">{{ $errors->first('password') }}</p>
                @endif
            </div>

            <div class="mb-6">
                <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Şifre Tekrar</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required placeholder="Şifrenizi tekrar yazın" 
                    class="w-full px-4 py-2 border border-slate-200 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-slate-700 dark:text-white placeholder-slate-400 transition-all outline-none text-sm">
            </div>

            <button type="submit" class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl shadow-md shadow-indigo-100 dark:shadow-none transition-all duration-150 text-sm">
                Hesabı Oluştur ve Devam Et
            </button>

            <div class="text-center mt-6 pt-4 border-t border-slate-100 dark:border-slate-700/60">
                <p class="text-sm text-slate-600 dark:text-slate-400">
                    Zaten bir hesabınız var mı? 
                    <a class="font-semibold text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 ml-1" href="{{ route('login') }}">
                        Giriş Yapın
                    </a>
                </p>
            </div>
        </form>
    </div>

</body>
</html>