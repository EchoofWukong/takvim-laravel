@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-slate-800 dark:text-white">📅 Bugünün Özeti</h1>
            <p class="text-slate-500 dark:text-slate-400 mt-2">Gün: <span class="font-semibold text-indigo-500">{{ $currentDay }}</span> | Saat: <span class="font-semibold text-indigo-500">{{ \Carbon\Carbon::parse($currentTime)->format('H:i') }}</span></p>
        </div>
    </div>

    @if(count($todaySchedules) == 0)
        <div class="bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-2xl p-8 text-center">
            <div class="text-5xl mb-4">🎉</div>
            <h3 class="text-xl font-bold text-emerald-800 dark:text-emerald-400">Harika!</h3>
            <p class="text-emerald-600 dark:text-emerald-500 mt-2">Bugün sistemde kayıtlı bir dersiniz veya sınavınız bulunmuyor.</p>
        </div>
    @else
        <div class="space-y-4">
            @foreach($todaySchedules as $c)
                @php
                    $isConflict = count($timeCounts[$c->start_time]) > 1;
                    $icon = $c->type == 'exam' ? '📝' : '📚';
                    
                    // Durum Kontrolü (Tamamlandı, Devam Ediyor, Yaklaşan)
                    $statusClass = '';
                    $statusText = '';
                    
                    if ($isConflict) {
                        $statusClass = 'bg-red-50 border-red-200 dark:bg-red-900/20 dark:border-red-800';
                        $statusText = '<span class="text-red-600 font-bold">⚠️ ÇAKIŞMA! Başka kaydınız var.</span>';
                    } elseif ($currentTime > $c->end_time) {
                        $statusClass = 'bg-slate-100 border-slate-200 opacity-60 dark:bg-slate-800/50 dark:border-slate-700';
                        $statusText = '<span class="text-slate-500 font-bold">✅ Tamamlandı</span>';
                    } elseif ($c->start_time <= $currentTime && $currentTime <= $c->end_time) {
                        $statusClass = 'bg-indigo-50 border-indigo-300 shadow-md ring-2 ring-indigo-500/20 dark:bg-indigo-900/30 dark:border-indigo-600';
                        $statusText = '<span class="text-indigo-600 dark:text-indigo-400 font-bold animate-pulse">🔥 ŞU AN DEVAM EDİYOR</span>';
                    } else {
                        $statusClass = 'bg-white border-slate-200 shadow-sm dark:bg-slate-800 dark:border-slate-700';
                        $statusText = '<span class="text-amber-500 font-bold">⏳ Yaklaşan Etkinlik</span>';
                    }
                @endphp

                <div class="flex items-center gap-6 p-6 rounded-2xl border transition-all {{ $statusClass }}">
                    <div class="flex flex-col items-center justify-center w-28 border-r border-slate-200 dark:border-slate-700/50 pr-6">
                        <span class="text-lg font-bold text-slate-800 dark:text-white">{{ \Carbon\Carbon::parse($c->start_time)->format('H:i') }}</span>
                        <span class="text-xs text-slate-500">{{ \Carbon\Carbon::parse($c->end_time)->format('H:i') }}</span>
                    </div>

                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-xl">{{ $icon }}</span>
                            <h3 class="text-lg font-bold text-slate-800 dark:text-white">{{ $c->course->course_code }} - {{ $c->course->name }}</h3>
                        </div>
                        <div class="flex items-center gap-4 text-sm text-slate-600 dark:text-slate-400 mt-2">
                            <span class="flex items-center gap-1">📍 <strong>{{ $c->classroom->name }}</strong></span>
                            <span>|</span>
                            <span>{!! $statusText !!}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection