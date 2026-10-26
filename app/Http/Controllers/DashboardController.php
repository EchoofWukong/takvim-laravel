<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // TARİH MOTORUNU TÜRKÇEYE ZORLUYORUZ (Saturday -> Cumartesi)
        \Carbon\Carbon::setLocale('tr');
        
        $userId = Auth::id();
        $todayName = ucfirst(now()->translatedFormat('l')); 
        $currentTime = now()->format('H:i:s');

        $todaySchedules = Schedule::with(['course', 'classroom'])
            ->where('user_id', $userId)
            ->where('day', 'LIKE', '%' . $todayName . '%')
            ->orderBy('start_time')->get();

        $timeCounts = [];
        foreach ($todaySchedules as $s) { $timeCounts[$s->start_time][] = $s->id; }

        $orderByRaw = "CASE WHEN day LIKE '%Pazartesi%' THEN 1 WHEN day LIKE '%Salı%' THEN 2 WHEN day LIKE '%Çarşamba%' THEN 3 WHEN day LIKE '%Perşembe%' THEN 4 WHEN day LIKE '%Cuma%' THEN 5 WHEN day LIKE '%Cumartesi%' THEN 6 ELSE 7 END, start_time";

        $weeklyLessons = Schedule::with(['course', 'classroom'])
            ->where('user_id', $userId)
            ->where('type', 'lesson')
            ->orderByRaw($orderByRaw)->get();

        $exams = Schedule::with(['course', 'classroom', 'user'])
            ->where('user_id', $userId)
            ->where('type', 'exam')
            ->orderByRaw($orderByRaw)->get();

        $uniqueDates = $exams->pluck('day')->unique()->toArray();
        
        usort($uniqueDates, function($a, $b) {
            preg_match('/\d+/', $a, $matchA);
            preg_match('/\d+/', $b, $matchB);
            $numA = $matchA ? (int)$matchA[0] : 0;
            $numB = $matchB ? (int)$matchB[0] : 0;
            return $numA <=> $numB;
        });

        $week1Dates = [];
        $week2Dates = [];
        $seenDays = [];
        $daysOfWeek = ['Pazartesi', 'Salı', 'Çarşamba', 'Perşembe', 'Cuma', 'Cumartesi', 'Pazar'];

        foreach ($uniqueDates as $dateStr) {
            $dayName = '';
            foreach ($daysOfWeek as $d) {
                if (mb_stripos($dateStr, $d) !== false) {
                    $dayName = $d; break;
                }
            }
            
            if (in_array($dayName, $seenDays) && $dayName != '') {
                $week2Dates[] = $dateStr;
            } elseif (count($week2Dates) > 0) {
                $week2Dates[] = $dateStr;
            } else {
                $week1Dates[] = $dateStr;
                if ($dayName != '') $seenDays[] = $dayName;
            }
        }

        return view('dashboard', compact('todaySchedules', 'currentTime', 'todayName', 'timeCounts', 'weeklyLessons', 'exams', 'week1Dates', 'week2Dates'));
    }

    public function ortak()
    {
        $schedules = Schedule::with(['course', 'classroom', 'user'])->get();
        $classrooms = \App\Models\Classroom::orderBy('name')->get();
        $exams = $schedules->where('type', 'exam');
        $conflicts = [];
        
        foreach ($schedules as $s1) {
            foreach ($schedules as $s2) {
                if ($s1->id != $s2->id && $s1->day == $s2->day && $s1->classroom_id == $s2->classroom_id) {
                    if ($s1->start_time < $s2->end_time && $s1->end_time > $s2->start_time) {
                        $conflicts[] = $s1->id;
                    }
                }
            }
        }
        
        $conflicts = array_unique($conflicts);
        return view('dashboard.ortak', compact('schedules', 'classrooms', 'exams', 'conflicts'));
    }
}