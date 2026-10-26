@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-400 text-sm font-semibold mb-3 border border-indigo-200 dark:border-indigo-800/50">
                <span class="w-2 h-2 rounded-full bg-indigo-600 animate-pulse"></span> Sistem Yönetimi
            </div>
            <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                Program & Veri Planlama
            </h1>
            <p class="text-slate-500 dark:text-slate-400 mt-2 text-lg">Dersleri ve derslikleri sisteme tanıtın, çakışmasız takvim oluşturun.</p>
        </div>
    </div>

    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-transition.opacity class="mb-8 p-4 bg-emerald-50 dark:bg-emerald-900/30 border-l-4 border-emerald-500 text-emerald-800 dark:text-emerald-300 rounded-r-xl shadow-sm flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="text-xl">✅</span>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
            <button @click="show = false" class="text-emerald-600 hover:text-emerald-800">&times;</button>
        </div>
    @endif
    
    @if(session('error'))
        <div x-data="{ show: true }" x-show="show" x-transition.opacity class="mb-8 p-4 bg-red-50 dark:bg-red-900/30 border-l-4 border-red-500 text-red-800 dark:text-red-300 rounded-r-xl shadow-sm flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="text-xl">⚠️</span>
                <span class="font-bold">{{ session('error') }}</span>
            </div>
            <button @click="show = false" class="text-red-600 hover:text-red-800">&times;</button>
        </div>
    @endif

    <div class="grid grid-cols-1 xl:grid-cols-12 gap-8">
        
        <!-- SOL KOLON -->
        <div class="col-span-1 xl:col-span-4 space-y-6">
            
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden transition-all hover:shadow-md">
                <div class="bg-slate-50 dark:bg-slate-900/50 p-4 border-b border-slate-200 dark:border-slate-700">
                    <h3 class="text-lg font-bold text-slate-800 dark:text-white flex items-center gap-2">📚 Yeni Ders Ekle</h3>
                </div>
                <div class="p-5">
                    <form action="{{ route('planlama.course.store') }}" method="POST">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1">Ders Kodu <span class="text-slate-400 font-normal">(Örn: BIL101)</span></label>
                                <input type="text" name="course_code" required class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-slate-700 dark:text-white transition-shadow outline-none">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1">Dersin Adı</label>
                                <input type="text" name="name" required class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-slate-700 dark:text-white transition-shadow outline-none">
                            </div>
                            <button type="submit" class="w-full py-2.5 bg-slate-800 hover:bg-slate-900 dark:bg-slate-700 dark:hover:bg-slate-600 text-white rounded-xl font-medium transition-colors shadow-sm">Dersi Sisteme Kaydet</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden transition-all hover:shadow-md">
                <div class="bg-slate-50 dark:bg-slate-900/50 p-4 border-b border-slate-200 dark:border-slate-700">
                    <h3 class="text-lg font-bold text-slate-800 dark:text-white flex items-center gap-2">🚪 Yeni Derslik / Sınıf</h3>
                </div>
                <div class="p-5">
                    <form action="{{ route('planlama.classroom.store') }}" method="POST">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1">Derslik Adı <span class="text-slate-400 font-normal">(Örn: Amfi 1)</span></label>
                                <input type="text" name="name" required class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-slate-700 dark:text-white transition-shadow outline-none">
                            </div>
                            <button type="submit" class="w-full py-2.5 bg-slate-800 hover:bg-slate-900 dark:bg-slate-700 dark:hover:bg-slate-600 text-white rounded-xl font-medium transition-colors shadow-sm">Sınıfı Sisteme Kaydet</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- PDF YÜKLEME FORMU -->
            <div class="bg-gradient-to-br from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20 p-6 rounded-2xl shadow-sm border border-indigo-100 dark:border-indigo-800/50 relative overflow-hidden">
                <div class="absolute top-0 right-0 p-4 opacity-10">📄</div>
                <h3 class="text-lg font-bold text-indigo-900 dark:text-indigo-300 mb-2">PDF Program Yükle</h3>
                <p class="text-sm text-indigo-700 dark:text-indigo-400 mb-5 leading-relaxed">Otomatik ayrıştırma motoru ile okulun yayınladığı listeyi tek tıkla çekin.</p>
                
                <form action="{{ route('planlama.pdf.upload') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    
                    <div class="bg-white dark:bg-slate-800 p-3 rounded-xl border border-indigo-100 dark:border-indigo-800/50 shadow-sm">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Yüklenen Belge Türü</label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-2 text-sm text-slate-700 dark:text-slate-300 cursor-pointer">
                                <input type="radio" name="schedule_type" value="lesson" checked class="text-indigo-600 focus:ring-indigo-500">
                                📚 Ders
                            </label>
                            <label class="flex items-center gap-2 text-sm text-slate-700 dark:text-slate-300 cursor-pointer">
                                <input type="radio" name="schedule_type" value="exam" class="text-indigo-600 focus:ring-indigo-500">
                                📝 Sınav
                            </label>
                        </div>
                    </div>

                    <label class="flex items-start gap-3 p-3 bg-white dark:bg-slate-800 rounded-xl border border-indigo-100 dark:border-indigo-800/50 shadow-sm cursor-pointer hover:bg-indigo-50 transition-colors">
                        <div class="flex items-center h-5">
                            <input type="checkbox" name="import_all" value="1" class="w-4 h-4 text-indigo-600 bg-slate-100 border-slate-300 rounded focus:ring-indigo-500 dark:bg-slate-700 dark:border-slate-600">
                        </div>
                        <div class="text-sm">
                            <span class="font-bold text-slate-800 dark:text-white">İsme Bakma (Tümünü Aktar)</span>
                            <p class="text-xs text-slate-500 mt-0.5">Belgedeki tüm ders/sınavlar sisteme yüklenir.</p>
                        </div>
                    </label>

                    <input type="file" name="pdf_file" accept=".pdf" required class="w-full text-sm text-slate-600 dark:text-slate-300 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 transition-colors bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700">
                    <button type="submit" class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold transition-transform hover:-translate-y-0.5 shadow-md shadow-indigo-200 dark:shadow-none">Sisteme Aktar (PDF Oku)</button>
                </form>
            </div>
            
        </div>

        <!-- SAĞ KOLON -->
        <div class="col-span-1 xl:col-span-8 space-y-6">
            
            <div class="bg-white dark:bg-slate-800 p-8 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-700 relative overflow-hidden">
                <div class="absolute -right-10 -top-10 w-40 h-40 bg-emerald-50 dark:bg-emerald-900/10 rounded-full blur-3xl pointer-events-none"></div>

                <h3 class="text-2xl font-extrabold text-slate-800 dark:text-white mb-6 flex items-center gap-3">
                    <span class="flex items-center justify-center w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400">➕</span>
                    Yeni Kayıt Ekle
                </h3>
                
                <form action="{{ route('planlama.schedule.store') }}" method="POST">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                        <div class="space-y-1">
                            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300">Kayıt Türü</label>
                            <select name="type" class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:bg-slate-700 dark:text-white transition-shadow cursor-pointer outline-none">
                                <option value="lesson">📚 Normal Ders Programı</option>
                                <option value="exam">📝 Sınav (Vize / Final)</option>
                            </select>
                        </div>

                        <div class="space-y-1">
                            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300">Öğretim Görevlisi</label>
                            <select name="user_id" class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:bg-slate-700 dark:text-white transition-shadow cursor-pointer outline-none" {{ !Auth::user()->is_admin ? 'disabled' : '' }}>
                                @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}" {{ Auth::id() == $teacher->id ? 'selected' : '' }}>
                                        {{ $teacher->name }} {{ $teacher->surname }}
                                    </option>
                                @endforeach
                            </select>
                            @if(!Auth::user()->is_admin) <input type="hidden" name="user_id" value="{{ Auth::id() }}"> @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                        <div class="space-y-1">
                            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300">Ders Seçimi</label>
                            <select name="course_id" required class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:bg-slate-700 dark:text-white transition-shadow cursor-pointer outline-none">
                                @forelse($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->course_code }} - {{ $course->name }}</option>
                                @empty
                                    <option value="" disabled selected>Sol taraftan ders ekleyin</option>
                                @endforelse
                            </select>
                        </div>
                        <div class="space-y-1">
                            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300">Derslik / Sınıf</label>
                            <select name="classroom_id" required class="w-full px-4 py-3 border border-slate-300 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:bg-slate-700 dark:text-white transition-shadow cursor-pointer outline-none">
                                @forelse($classrooms as $room)
                                    <option value="{{ $room->id }}">{{ $room->name }}</option>
                                @empty
                                    <option value="" disabled selected>Sol taraftan sınıf ekleyin</option>
                                @endforelse
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8 bg-slate-50 dark:bg-slate-900/30 p-5 rounded-2xl border border-slate-100 dark:border-slate-700/50">
                        <div class="space-y-1">
                            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300">Gün</label>
                            <select name="day" class="w-full px-4 py-2.5 border border-slate-300 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:bg-slate-700 dark:text-white cursor-pointer outline-none">
                                @foreach(['Pazartesi', 'Salı', 'Çarşamba', 'Perşembe', 'Cuma', 'Cumartesi', 'Pazar'] as $gun)
                                    <option value="{{ $gun }}">{{ $gun }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="space-y-1">
                            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300">Başlangıç Saati</label>
                            <input type="time" name="start_time" value="09:00" required class="w-full px-4 py-2.5 border border-slate-300 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:bg-slate-700 dark:text-white outline-none">
                        </div>
                        <div class="space-y-1">
                            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300">Bitiş Saati</label>
                            <input type="time" name="end_time" value="10:00" required class="w-full px-4 py-2.5 border border-slate-300 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 dark:bg-slate-700 dark:text-white outline-none">
                        </div>
                    </div>

                    <button type="submit" class="w-full py-4 bg-emerald-600 hover:bg-emerald-700 text-white rounded-2xl font-bold text-lg shadow-lg shadow-emerald-200 dark:shadow-none transition-all hover:scale-[1.01] active:scale-95 flex items-center justify-center gap-2">
                        <span>Çakışmayı Denetle ve Kaydet</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </button>
                </form>
            </div>

            <!-- Kayıtlı Programlar Tablosu -->
            <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
                <div class="p-6 border-b border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900/20 flex items-center justify-between">
                    <h3 class="text-xl font-bold text-slate-800 dark:text-white flex items-center gap-2">
                        🗂️ Mevcut Program Kayıtları
                    </h3>
                    <form action="{{ route('planlama.schedule.truncate') }}" method="POST" onsubmit="return confirm('DİKKAT! Size ait TÜM program kayıtları silinecek. Bu işlem geri alınamaz. Emin misiniz?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-bold rounded-xl flex items-center gap-2 shadow-sm transition-colors">
                            <span>🗑️ Toplu Sil</span>
                        </button>
                    </form>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-600 dark:text-slate-400">
                        <thead class="bg-slate-50 dark:bg-slate-900 text-slate-700 dark:text-slate-300 font-bold border-b border-slate-200 dark:border-slate-700">
                            <tr>
                                <th class="px-6 py-5">Zaman</th>
                                <th class="px-6 py-5">Ders & İşlem Türü</th>
                                <th class="px-6 py-5">Derslik</th>
                                @if(Auth::user()->is_admin) <th class="px-6 py-5">Hoca</th> @endif
                                <th class="px-6 py-5 text-right">Düzenle / Sil</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-700/50">
                            @forelse($mySchedules as $schedule)
                                <tr class="group hover:bg-indigo-50/30 dark:hover:bg-slate-700/30 transition-colors" x-data="{ editOpen: false }">
                                    
                                    <td x-show="!editOpen" class="px-6 py-5 whitespace-nowrap">
                                        <div class="font-bold text-slate-800 dark:text-white text-base">{{ $schedule->day }}</div>
                                        <div class="text-indigo-600 dark:text-indigo-400 font-medium">{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}</div>
                                    </td>
                                    
                                    <td x-show="!editOpen" class="px-6 py-5">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $schedule->type == 'exam' ? 'bg-amber-100 text-amber-600 dark:bg-amber-900/30 dark:text-amber-400' : 'bg-indigo-100 text-indigo-600 dark:bg-indigo-900/30 dark:text-indigo-400' }} text-lg shadow-sm">
                                                {{ $schedule->type == 'exam' ? '📝' : '📚' }}
                                            </div>
                                            <div>
                                                <div class="font-bold text-slate-800 dark:text-white">{{ $schedule->course->name }}</div>
                                                <div class="text-xs font-semibold uppercase tracking-wider text-slate-400">{{ $schedule->course->course_code }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <td x-show="!editOpen" class="px-6 py-5 font-semibold text-slate-700 dark:text-slate-300">
                                        {{ $schedule->classroom->name }}
                                    </td>
                                    
                                    @if(Auth::user()->is_admin) 
                                        <td x-show="!editOpen" class="px-6 py-5">
                                            <span class="px-3 py-1 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 rounded-full text-xs font-bold">{{ $schedule->user->name }} {{ $schedule->user->surname }}</span>
                                        </td> 
                                    @endif
                                    
                                    <td x-show="!editOpen" class="px-6 py-5 text-right">
                                        <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <button @click="editOpen = true" class="p-2 text-indigo-600 hover:bg-indigo-100 dark:text-indigo-400 dark:hover:bg-indigo-900/50 rounded-lg transition-colors" title="Düzenle">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                            </button>
                                       <!-- Silme Butonu -->
<form action="{{ route('planlama.schedule.destroy', $schedule->id) }}" method="POST" class="inline">
    @csrf @method('DELETE')
    <button type="submit" class="text-red-500 font-bold hover:underline">🗑️ SİL</button>
</form>
                                        </div>
                                    </td>

                                    <td x-show="editOpen" x-transition.duration.300ms colspan="{{ Auth::user()->is_admin ? '5' : '4' }}" class="px-6 py-6 bg-indigo-50/50 dark:bg-indigo-900/10 border-x-4 border-indigo-500 shadow-inner">
                                        <form action="{{ route('planlama.schedule.update', $schedule->id) }}" method="POST">
                                            @csrf @method('PUT')
                                            
                                            <div class="flex items-center gap-2 mb-4 text-indigo-700 dark:text-indigo-400 font-bold">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                Kaydı Düzenle
                                            </div>
                                            

                                            <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 items-end">
                                                <div class="col-span-1">
                                                    <label class="block text-xs font-semibold text-slate-500 mb-1">Gün</label>
                                                    <select name="day" class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-indigo-500 text-sm dark:bg-slate-700 dark:text-white outline-none">
                                                        @foreach(['Pazartesi', 'Salı', 'Çarşamba', 'Perşembe', 'Cuma', 'Cumartesi', 'Pazar'] as $gun)
                                                            <option value="{{ $gun }}" {{ $schedule->day == $gun ? 'selected' : '' }}>{{ $gun }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-span-1">
                                                    <label class="block text-xs font-semibold text-slate-500 mb-1">Başlama</label>
                                                    <input type="time" name="start_time" value="{{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }}" class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-indigo-500 text-sm dark:bg-slate-700 dark:text-white outline-none">
                                                </div>
                                                <div class="col-span-1">
                                                    <label class="block text-xs font-semibold text-slate-500 mb-1">Bitiş</label>
                                                    <input type="time" name="end_time" value="{{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}" class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-indigo-500 text-sm dark:bg-slate-700 dark:text-white outline-none">
                                                </div>
                                                <div class="col-span-2 lg:col-span-1">
                                                    <label class="block text-xs font-semibold text-slate-500 mb-1">Ders Seçimi</label>
                                                    <select name="course_id" class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-indigo-500 text-sm dark:bg-slate-700 dark:text-white outline-none">
                                                        @foreach($courses as $course)
                                                            <option value="{{ $course->id }}" {{ $schedule->course_id == $course->id ? 'selected' : '' }}>{{ $course->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-span-2 lg:col-span-1">
                                                    <label class="block text-xs font-semibold text-slate-500 mb-1">Derslik</label>
                                                    <select name="classroom_id" class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-indigo-500 text-sm dark:bg-slate-700 dark:text-white outline-none">
                                                        @foreach($classrooms as $room)
                                                            <option value="{{ $room->id }}" {{ $schedule->classroom_id == $room->id ? 'selected' : '' }}>{{ $room->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="flex justify-end gap-3 mt-5 pt-4 border-t border-indigo-100 dark:border-indigo-800">
                                                <button type="button" @click="editOpen = false" class="px-5 py-2 bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700 rounded-xl font-semibold text-sm transition-colors shadow-sm">Vazgeç</button>
                                                <button type="submit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold text-sm shadow-md transition-colors">Değişiklikleri Kaydet</button>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-100 dark:bg-slate-800 text-3xl mb-4">📭</div>
                                        <h4 class="text-lg font-bold text-slate-800 dark:text-white mb-1">Henüz Kayıt Yok</h4>
                                        <p class="text-slate-500 dark:text-slate-400">Üstteki formu kullanarak ilk programınızı planlayın.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection