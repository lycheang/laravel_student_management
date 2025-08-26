<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class subject extends Model
{
    /** @use HasFactory<\Database\Factories\SubjectFactory> */
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'subject_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'subject_name',
        'teacher_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the teacher that teaches the subject.
     */
    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id', 'teacher_id');
    }

    /**
     * Get the attendance records for the subject.
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'subject_id', 'subject_id');
    }

    /**
     * Get the students enrolled in the subject through attendance.
     */
    public function students()
    {
        return $this->hasManyThrough(Student::class, Attendance::class, 'subject_id', 'student_id', 'subject_id', 'student_id');
    }

    /**
     * Scope a query to only include subjects taught by a specific teacher.
     */
    public function scopeByTeacher($query, $teacherId)
    {
        return $query->where('teacher_id', $teacherId);
    }
}
