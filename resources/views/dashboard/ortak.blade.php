@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="roomAnalytics({{ $schedules->toJson() }}, {{ $classrooms->toJson() }})">
    
    <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-slate-200 dark:border-slate-700 pb-6">
        <div>
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 text-sm font-extrabold mb-4 shadow-sm border border-amber-200 dark:border-amber-800/50">
                👑 Yönetici Dashboard
            </div>
            <h1 class="text-3xl md:text-4xl font-black text-slate-800 dark:text-white tracking-tight">Genel İzleme Merkezi</h1>
        </div>
        <a href="{{ route('dashboard') }}" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-indigo-200 dark:shadow-none hover:-translate-y-0.5 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kendi Paneline Dön
        </a>
    </div>

    <div class="flex flex-wrap gap-2 mb-8 bg-slate-100 dark:bg-slate-800 p-1.5 rounded-2xl w-fit shadow-inner border border-slate-200 dark:border-slate-700">
        <button @click="tab = 'yönetim'" :class="tab == 'yönetim' ? 'bg-white dark:bg-slate-700 shadow-md text-amber-600 dark:text-amber-400' : 'text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-white'" class="px-6 py-2.5 rounded-xl font-bold transition-all flex items-center gap-2">
            🗂️ Tüm Kayıtlar
        </button>
        <button @click="tab = 'analiz'" :class="tab == 'analiz' ? 'bg-white dark:bg-slate-700 shadow-md text-amber-600 dark:text-amber-400' : 'text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-white'" class="px-6 py-2.5 rounded-xl font-bold transition-all flex items-center gap-2">
            🚪 Derslik Durumları
        </button>
        <button @click="tab = 'sinav'" :class="tab == 'sinav' ? 'bg-white dark:bg-slate-700 shadow-md text-amber-600 dark:text-amber-400' : 'text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-white'" class="px-6 py-2.5 rounded-xl font-bold transition-all flex items-center gap-2">
            📝 Sınav Takibi
        </button>
    </div>

    <div x-show="tab === 'yönetim'" x-transition>
        <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead class="bg-slate-50 dark:bg-slate-900/80 text-slate-500 dark:text-slate-400 font-bold border-b border-slate-200 dark:border-slate-700 uppercase tracking-wider text-xs">
                        <tr>
                            <th class="px-6 py-5">Öğretim Görevlisi</th>
                            <th class="px-6 py-5">Gün / Saat</th>
                            <th class="px-6 py-5">Ders Tipi</th>
                            <th class="px-6 py-5">Derslik</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700/50 text-slate-700 dark:text-slate-300">
                        @forelse($schedules as $s)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                                <td class="px-6 py-5 font-extrabold text-slate-900 dark:text-white flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-indigo-100 dark:bg-indigo-900/50 text-indigo-600 dark:text-indigo-400 flex items-center justify-center text-xs">{{ mb_substr($s->user->name, 0, 1) }}{{ mb_substr($s->user->surname, 0, 1) }}</div>
                                    {{ $s->user->name }} {{ $s->user->surname }}
                                </td>
                                <td class="px-6 py-5">
                                    <span class="font-bold text-slate-800 dark:text-slate-200">{{ $s->day }}</span> <br> 
                                    <span class="text-indigo-600 dark:text-indigo-400 font-bold">{{ \Carbon\Carbon::parse($s->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($s->end_time)->format('H:i') }}</span>
                                </td>
                                <td class="px-6 py-5 font-bold">
                                    <span class="mr-2 text-lg">{{ $s->type == 'exam' ? '📝' : '📚' }}</span> {{ $s->course->name }}
                                </td>
                                <td class="px-6 py-5">
                                    <span class="px-3 py-1 bg-slate-100 dark:bg-slate-900 rounded-lg border border-slate-200 dark:border-slate-700 text-amber-700 dark:text-amber-500 font-bold">📍 {{ $s->classroom->name }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-6 py-12 text-center text-slate-500">Kayıt bulunmuyor.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div x-show="tab === 'analiz'" style="display:none;" x-transition>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
            <div>
                <label class="block text-sm font-bold text-slate-600 dark:text-slate-400 mb-2 uppercase tracking-wide">Gün Seçin</label>
                <select x-model="selectedDay" class="w-full px-5 py-4 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl font-bold text-slate-800 dark:text-white shadow-sm focus:ring-2 focus:ring-indigo-500 outline-none transition-shadow">
                    <template x-for="day in days"><option :value="day" x-text="day"></option></template>
                </select>
            </div>
            <div>
                <label class="block text-sm font-bold text-slate-600 dark:text-slate-400 mb-2 uppercase tracking-wide">Saat Seçin (09:00 - 17:00)</label>
                <select x-model="selectedTime" class="w-full px-5 py-4 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl font-bold text-slate-800 dark:text-white shadow-sm focus:ring-2 focus:ring-indigo-500 outline-none transition-shadow">
                    <template x-for="time in hours"><option :value="time" x-text="time"></option></template>
                </select>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-emerald-50 dark:bg-emerald-900/10 border border-emerald-200 dark:border-emerald-800/50 rounded-3xl overflow-hidden shadow-sm">
                <div class="bg-emerald-500 dark:bg-emerald-600 text-white px-6 py-4 font-black flex items-center gap-3 text-lg">
                    <span class="w-3 h-3 rounded-full bg-white animate-pulse"></span> BOŞ DERSLİKLER
                </div>
                <div class="p-6 space-y-4">
                    <template x-for="room in getEmptyRooms()" :key="room.id">
                        <div class="flex items-center gap-3 text-emerald-800 dark:text-emerald-400 font-bold bg-white dark:bg-emerald-900/30 px-4 py-3 rounded-xl border border-emerald-100 dark:border-emerald-800/30">
                            📍 <span x-text="room.name"></span>
                        </div>
                    </template>
                    <template x-if="getEmptyRooms().length === 0"><p class="text-slate-500 italic px-2">Şu an boş derslik yok.</p></template>
                </div>
            </div>
            
            <div class="bg-red-50 dark:bg-red-900/10 border border-red-200 dark:border-red-800/50 rounded-3xl overflow-hidden shadow-sm">
                <div class="bg-red-500 dark:bg-red-600 text-white px-6 py-4 font-black flex items-center gap-3 text-lg">
                    <span class="w-3 h-3 rounded-full bg-white animate-pulse"></span> DOLU DERSLİKLER
                </div>
                <div class="p-6 space-y-4">
                    <template x-for="s in getOccupiedRooms()" :key="s.id">
                        <div class="bg-white dark:bg-red-900/30 p-4 rounded-xl border border-red-100 dark:border-red-800/30">
                            <div class="text-red-700 dark:text-red-400 font-black mb-2 text-lg">📍 <span x-text="s.classroom.name"></span></div>
                            <div class="text-sm font-medium text-slate-700 dark:text-slate-300 flex flex-col gap-1 pl-2 border-l-2 border-red-200 dark:border-red-800">
                                <span>👤 <span x-text="s.user.name + ' ' + s.user.surname"></span></span>
                                <span>📚 <i x-text="s.course.name"></i></span>
                            </div>
                        </div>
                    </template>
                    <template x-if="getOccupiedRooms().length === 0"><p class="text-slate-500 italic px-2">Tüm derslikler şu an boş.</p></template>
                </div>
            </div>
        </div>
    </div>

    <div x-show="tab === 'sinav'" style="display:none;" x-transition>
        <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead class="bg-slate-50 dark:bg-slate-900/80 text-slate-500 dark:text-slate-400 font-bold border-b border-slate-200 dark:border-slate-700 uppercase tracking-wider text-xs">
                        <tr><th class="px-6 py-5">Tarih / Gün / Saat</th><th class="px-6 py-5">Sınav Adı</th><th class="px-6 py-5">Gözetmen / Derslik</th></tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700/50 text-slate-700 dark:text-slate-300">
                        @forelse($exams as $e)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-colors">
                                <td class="px-6 py-5">
                                    <span class="font-extrabold text-slate-900 dark:text-white">{{ $e->day }}</span><br>
                                    <span class="text-amber-600 dark:text-amber-400 font-bold">{{ \Carbon\Carbon::parse($e->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($e->end_time)->format('H:i') }}</span>
                                </td>
                                <td class="px-6 py-5 font-bold">📝 {{ $e->course->name }}</td>
                                <td class="px-6 py-5 font-semibold">
                                    <div class="flex items-center gap-4">
                                        <span class="flex items-center gap-1"><span class="text-slate-400">👤</span> {{ $e->user->name }} {{ $e->user->surname }}</span>
                                        <span class="px-3 py-1 bg-slate-100 dark:bg-slate-900 rounded-lg border border-slate-200 dark:border-slate-700 text-amber-700 dark:text-amber-500 font-bold">📍 {{ $e->classroom->name }}</span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="px-6 py-12 text-center text-slate-500">Sınav kaydı bulunmuyor.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('roomAnalytics', (schedules, classrooms) => ({
            tab: 'analiz', schedules: schedules, classrooms: classrooms,
            selectedDay: 'Pazartesi', selectedTime: '09:00:00',
            days: ['Pazartesi', 'Salı', 'Çarşamba', 'Perşembe', 'Cuma', 'Cumartesi', 'Pazar'],
            hours: Array.from({length: 9}, (_, i) => String(i + 9).padStart(2, '0') + ':00:00'),
            
            getOccupiedRooms() {
                return this.schedules.filter(s => s.day.includes(this.selectedDay) && s.start_time <= this.selectedTime && s.end_time > this.selectedTime);
            },
            getEmptyRooms() {
                let occupied = this.getOccupiedRooms().map(s => s.classroom_id);
                return this.classrooms.filter(c => !occupied.includes(c.id));
            }
        }))
    })
</script>
@endsection