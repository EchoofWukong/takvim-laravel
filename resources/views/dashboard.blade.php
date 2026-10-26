@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="{ tab: 'bugun' }">

    <div class="flex gap-2 mb-8 bg-slate-100 dark:bg-slate-800 p-1.5 rounded-xl w-fit shadow-inner border border-slate-200 dark:border-slate-700">
        <button @click="tab = 'bugun'" :class="tab == 'bugun' ? 'bg-white dark:bg-slate-700 shadow text-indigo-600 dark:text-indigo-400' : 'text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-white'" class="px-6 py-2.5 rounded-lg font-bold transition-all">🏠 Bugün</button>
        <button @click="tab = 'haftalik'" :class="tab == 'haftalik' ? 'bg-white dark:bg-slate-700 shadow text-indigo-600 dark:text-indigo-400' : 'text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-white'" class="px-6 py-2.5 rounded-lg font-bold transition-all">📆 Ders Programım</button>
        <button @click="tab = 'sinav'" :class="tab == 'sinav' ? 'bg-white dark:bg-slate-700 shadow text-amber-600 dark:text-amber-400' : 'text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-white'" class="px-6 py-2.5 rounded-lg font-bold transition-all">📝 Sınav Takvimi</button>
        <a href="{{ route('dashboard.ortak') }}" class="px-6 py-2.5 rounded-lg font-bold text-emerald-600 dark:text-emerald-400 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-all flex items-center gap-2">🌐 Ortak Havuz</a>
    </div>

    <div x-show="tab === 'bugun'" x-transition>
        <h2 class="text-2xl font-bold mb-6 text-slate-800 dark:text-white">{{ $todayName }} - Canlı Durum</h2>
        @forelse($todaySchedules as $c)
            <div class="p-6 mb-4 bg-white dark:bg-slate-800 rounded-2xl shadow-sm border-l-4 {{ $c->type == 'exam' ? 'border-amber-500' : 'border-indigo-500' }} relative group">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <span class="text-2xl">{{ $c->type == 'exam' ? '📝' : '📚' }}</span>
                        <h3 class="font-bold text-xl text-slate-800 dark:text-white">{{ $c->course->name }}</h3>
                    </div>
                    <p class="text-slate-600 dark:text-slate-400 font-medium">📍 {{ $c->classroom->name }} | 🕒 {{ \Carbon\Carbon::parse($c->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($c->end_time)->format('H:i') }}</p>
                </div>
                <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity flex gap-2">
                    <form action="{{ route('planlama.schedule.destroy', $c->id) }}" method="POST" onsubmit="return confirm('Bu kaydı anında silmek istediğinize emin misiniz?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 font-bold text-xs">🗑️ Sil</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="p-8 text-center bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 shadow-sm"><p class="text-slate-500">Bugün dersiniz bulunmuyor.</p></div>
        @endforelse
    </div>

    <div x-show="tab === 'haftalik'" style="display:none;" x-transition>
        @if(count($weeklyLessons) == 0)
            <div class="p-8 text-center bg-white dark:bg-slate-800 rounded-2xl border shadow-sm text-slate-500">Kayıtlı dersiniz bulunmuyor.</div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($weeklyLessons->groupBy('day') as $day => $lessons)
                    <div class="bg-white dark:bg-slate-800 p-6 rounded-3xl border shadow-sm">
                        <h3 class="font-bold text-lg mb-4 text-indigo-600 border-b pb-3">{{ $day }}</h3>
                        <div class="space-y-3">
                            @foreach($lessons as $l)
                                <div class="relative p-4 bg-slate-50 dark:bg-slate-900/50 rounded-xl border group">
                                    <p class="font-bold text-slate-800 dark:text-white">{{ \Carbon\Carbon::parse($l->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($l->end_time)->format('H:i') }}</p>
                                    <p class="text-sm font-medium text-slate-700">📚 {{ $l->course->name }}</p>
                                    <p class="text-xs text-slate-500 mt-2 font-semibold">📍 {{ $l->classroom->name }}</p>
                                    
                                    <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col gap-1">
                                        <a href="{{ route('planlama.index') }}" class="p-1.5 bg-indigo-50 text-indigo-600 rounded-md hover:bg-indigo-100 text-xs text-center" title="Planlama Sayfasına Git">✏️</a>
                                        <form action="{{ route('planlama.schedule.destroy', $l->id) }}" method="POST" onsubmit="return confirm('Silmek istediğinize emin misiniz?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-1.5 bg-red-50 text-red-600 rounded-md hover:bg-red-100 text-xs w-full">🗑️</button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <div x-show="tab === 'sinav'" style="display:none;" x-transition>
        @if(count($exams) == 0)
             <div class="p-8 text-center bg-white dark:bg-slate-800 rounded-2xl border shadow-sm text-slate-500">Sınavınız bulunmuyor.</div>
        @else
            <div x-data="{ examTab: 'hafta1' }">
                
                <div class="flex gap-6 border-b border-slate-200 dark:border-slate-700 mb-8">
                    <button @click="examTab = 'hafta1'" :class="examTab == 'hafta1' ? 'border-red-500 text-red-500 dark:text-red-400' : 'border-transparent text-slate-500 hover:text-slate-700 dark:hover:text-slate-300'" class="pb-3 border-b-2 font-bold flex items-center gap-2 transition-colors">
                        📌 1. Hafta Sınavları
                    </button>
                    @if(count($week2Dates) > 0)
                        <button @click="examTab = 'hafta2'" :class="examTab == 'hafta2' ? 'border-red-500 text-red-500 dark:text-red-400' : 'border-transparent text-slate-500 hover:text-slate-700 dark:hover:text-slate-300'" class="pb-3 border-b-2 font-bold flex items-center gap-2 transition-colors">
                            📌 2. Hafta Sınavları
                        </button>
                    @endif
                </div>

                <div x-show="examTab === 'hafta1'" x-transition>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        @foreach($week1Dates as $dateStr)
                            <div>
                                <h3 class="font-extrabold text-lg text-slate-800 dark:text-white mb-4">{{ $dateStr }}</h3>
                                <div class="space-y-4">
                                    @foreach($exams->where('day', $dateStr) as $exam)
                                        <div class="p-5 bg-transparent rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm relative group">
                                            
                                            <p class="font-extrabold text-slate-800 dark:text-white mb-4">{{ \Carbon\Carbon::parse($exam->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($exam->end_time)->format('H:i') }}</p>
                                            
                                            <p class="text-base font-bold text-red-600 dark:text-red-400 mb-3">✏️ {{ $exam->course->name }}</p>
                                            
                                            <p class="text-sm font-semibold text-slate-600 dark:text-slate-400 mb-2 flex items-center gap-2">👤 {{ $exam->user->name }} {{ $exam->user->surname }}</p>
                                            <p class="text-sm font-semibold text-slate-600 dark:text-slate-400 mb-1 flex items-center gap-2">📍 {{ $exam->classroom->name }}</p>

                                            <div class="absolute bottom-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity flex gap-2">
                                                <a href="{{ route('planlama.index') }}" class="px-3 py-1.5 bg-slate-800 text-white rounded-lg hover:bg-slate-900 text-xs font-bold transition-colors">✏️ Düzenle</a>
                                                <form action="{{ route('planlama.schedule.destroy', $exam->id) }}" method="POST" onsubmit="return confirm('Sınavı silmek istediğinize emin misiniz?');">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="px-3 py-1.5 bg-transparent text-slate-500 rounded-lg border border-slate-300 hover:bg-slate-100 dark:border-slate-600 dark:hover:bg-slate-700 text-xs font-bold transition-colors">🗑️ Sil</button>
                                                </form>
                                            </div>
                                            
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                @if(count($week2Dates) > 0)
                    <div x-show="examTab === 'hafta2'" style="display:none;" x-transition>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            @foreach($week2Dates as $dateStr)
                                <div>
                                    <h3 class="font-extrabold text-lg text-slate-800 dark:text-white mb-4">{{ $dateStr }}</h3>
                                    <div class="space-y-4">
                                        @foreach($exams->where('day', $dateStr) as $exam)
                                            <div class="p-5 bg-transparent rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm relative group">
                                                
                                                <p class="font-extrabold text-slate-800 dark:text-white mb-4">{{ \Carbon\Carbon::parse($exam->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($exam->end_time)->format('H:i') }}</p>
                                                
                                                <p class="text-base font-bold text-red-600 dark:text-red-400 mb-3">✏️ {{ $exam->course->name }}</p>
                                                
                                                <p class="text-sm font-semibold text-slate-600 dark:text-slate-400 mb-2 flex items-center gap-2">👤 {{ $exam->user->name }} {{ $exam->user->surname }}</p>
                                                <p class="text-sm font-semibold text-slate-600 dark:text-slate-400 mb-1 flex items-center gap-2">📍 {{ $exam->classroom->name }}</p>

                                                <div class="absolute bottom-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity flex gap-2">
                                                    <a href="{{ route('planlama.index') }}" class="px-3 py-1.5 bg-slate-800 text-white rounded-lg hover:bg-slate-900 text-xs font-bold transition-colors">✏️ Düzenle</a>
                                                    <form action="{{ route('planlama.schedule.destroy', $exam->id) }}" method="POST" onsubmit="return confirm('Sınavı silmek istediğinize emin misiniz?');">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="px-3 py-1.5 bg-transparent text-slate-500 rounded-lg border border-slate-300 hover:bg-slate-100 dark:border-slate-600 dark:hover:bg-slate-700 text-xs font-bold transition-colors">🗑️ Sil</button>
                                                    </form>
                                                </div>
                                                
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                
            </div>
        @endif
    </div>
</div>
@endsection