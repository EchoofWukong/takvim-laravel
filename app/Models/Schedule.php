<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Takvimdeki kaydın hangi Derse ait olduğu
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // Takvimdeki kaydın hangi Sınıfa ait olduğu
    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    // Takvimdeki kaydın hangi Hocaya ait olduğu
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}