<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Classroom;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ScheduleController extends Controller
{
    public function index()
    {
        $courses = Course::orderBy('name')->get();
        $classrooms = Classroom::orderBy('name')->get();
        $teachers = User::orderBy('name')->get();
        
        $query = Schedule::with(['course', 'classroom', 'user'])
                         ->orderByRaw("CASE WHEN day LIKE '%Pazartesi%' THEN 1 WHEN day LIKE '%Salı%' THEN 2 WHEN day LIKE '%Çarşamba%' THEN 3 WHEN day LIKE '%Perşembe%' THEN 4 WHEN day LIKE '%Cuma%' THEN 5 WHEN day LIKE '%Cumartesi%' THEN 6 ELSE 7 END, start_time");

        if (!Auth::user()->is_admin) {
            $query->where('user_id', Auth::id());
        }

        $mySchedules = $query->get();

        return view('planlama.index', compact('courses', 'classrooms', 'teachers', 'mySchedules'));
    }

    public function storeCourse(Request $request) { /*... öncekiyle aynı ...*/ 
        $request->validate(['course_code' => 'required|unique:courses,course_code', 'name' => 'required']);
        Course::create($request->all());
        return redirect()->back()->with('success', 'Ders sisteme kaydedildi.');
    }

    public function storeClassroom(Request $request) { /*... öncekiyle aynı ...*/ 
        $request->validate(['name' => 'required|unique:classrooms,name']);
        Classroom::create($request->all());
        return redirect()->back()->with('success', 'Derslik sisteme eklendi.');
    }

    public function storeSchedule(Request $request) {
        $request->validate([
            'user_id' => 'required', 'course_id' => 'required', 'classroom_id' => 'required',
            'type' => 'required', 'day' => 'required', 'start_time' => 'required', 'end_time' => 'required'
        ]);

        $conflict = Schedule::where('day', $request->day)
            ->where(function($q) use ($request) {
                $q->where('classroom_id', $request->classroom_id)->orWhere('user_id', $request->user_id);
            })->where('start_time', '<', $request->end_time)->where('end_time', '>', $request->start_time)->exists();

        if ($conflict) return redirect()->back()->with('error', 'ÇAKIŞMA: Sınıf veya hoca dolu!');

        Schedule::create($request->all());
        return redirect()->back()->with('success', 'Takvime eklendi.');
    }

    public function updateSchedule(Request $request, Schedule $schedule) {
        if (Auth::id() != $schedule->user_id && !Auth::user()->is_admin) return redirect()->back()->with('error', 'Yetkisiz!');
        $schedule->update($request->all());
        return redirect()->back()->with('success', 'Güncellendi.');
    }

    public function destroySchedule(Schedule $schedule) {
        if (Auth::id() == $schedule->user_id || Auth::user()->is_admin) {
            $schedule->delete();
            return redirect()->back()->with('success', 'Silindi.');
        }
        return redirect()->back()->with('error', 'Yetkisiz!');
    }

    // YENİ: Toplu Silme Fonksiyonu
    public function truncateSchedules() {
        Schedule::where('user_id', Auth::id())->delete();
        return redirect()->back()->with('success', 'Tüm program kayıtlarınız başarıyla silindi!');
    }

    public function uploadPdf(Request $request)
    {
        $request->validate(['pdf_file' => 'required|mimes:pdf']);
        $path = $request->file('pdf_file')->storeAs('pdfs', time() . '_program.pdf');
        
        $fullPath = str_replace('\\', '/', Storage::path($path));
        $scriptPath = str_replace('\\', '/', base_path('scripts/pdf_parser.py'));
        $teacherName = Auth::user()->name . ' ' . Auth::user()->surname;
        
        $isExam = $request->input('schedule_type') == 'exam' ? "true" : "false";
        $importAll = $request->has('import_all') ? "true" : "false";

        $command = 'python ' . escapeshellarg($scriptPath) . ' ' . escapeshellarg($fullPath) . ' ' . escapeshellarg($teacherName) . ' ' . $isExam . ' ' . $importAll;
        $output = shell_exec($command);

        if (!$output) return redirect()->back()->with('error', 'Python betiği çalıştırılamadı.');
        $parsedData = json_decode($output, true);
        if (isset($parsedData['error'])) return redirect()->back()->with('error', 'PDF Hatası: ' . $parsedData['error']);
        if (empty($parsedData)) return redirect()->back()->with('error', 'Kayıt bulunamadı. (Sınav programı yüklüyorsanız isminiz yazmıyor olabilir, "İsme Bakma" seçeneğini kullanın).');

        $addedCount = 0;
        foreach ($parsedData as $item) {
            
            // YENİ: Derslik yoksa BÜYÜK/KÜÇÜK harfe bakmaksızın bul veya oluştur!
            $roomName = trim($item['classroom']);
            $classroom = Classroom::whereRaw('LOWER(name) = ?', [mb_strtolower($roomName)])->first();
            if (!$classroom) {
                $classroom = Classroom::create(['name' => $roomName]);
            }

            // Dersi de aynı şekilde bul veya oluştur
            $courseName = trim($item['subject']);
            $course = Course::whereRaw('LOWER(name) = ?', [mb_strtolower($courseName)])->first();
            if (!$course) {
                $course = Course::create(['name' => $courseName, 'course_code' => strtoupper(substr(md5($courseName), 0, 5))]);
            }

            $exists = Schedule::where('user_id', Auth::id())->where('day', $item['day'])->where('start_time', $item['start_time'])->exists();
            if (!$exists) {
                Schedule::create([
                    'user_id' => Auth::id(), 'course_id' => $course->id, 'classroom_id' => $classroom->id,
                    'type' => $item['type'], 'day' => $item['day'], 'start_time' => $item['start_time'], 'end_time' => $item['end_time']
                ]);
                $addedCount++;
            }
        }
        return redirect()->back()->with('success', "$addedCount adet yeni kayıt eklendi. Bulunamayan derslikler otomatik oluşturuldu.");
    }
}