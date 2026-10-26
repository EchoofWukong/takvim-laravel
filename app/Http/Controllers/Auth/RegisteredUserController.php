<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
{
    // 1. Validasyon (Girdilerin kontrolü)
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'surname' => ['required', 'string', 'max:255'], // Soyisim zorunlu yapıldı
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.\App::make(\App\Models\User::class)::class],
        'password' => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
    ]);

    // 2. Kullanıcıyı Veritabanına Kaydetme
    $user = \App\Models\User::create([
        'name' => $request->name,
        'surname' => $request->surname,
        'email' => $request->email,
        'password' => \Illuminate\Support\Facades\Hash::make($request->password),
    ]);

    event(new \Illuminate\Auth\Events\Registered($user));

    // DİKKAT: Auth::login($user); satırını sildik! Böylece otomatik giriş yapmayacak.

    // 3. Giriş sayfasına yönlendir ve yeşil bir bildirim mesajı (Flash Session) gönder
    return redirect()->route('login')->with('success', 'Kayıt işleminiz başarıyla tamamlandı! Lütfen giriş yapın.');
}
}
