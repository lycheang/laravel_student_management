<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class student extends Model
{
    /** @use HasFactory<\Database\Factories\StudentFactory> */
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'student_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'student_name',
        'student_password',
        'student_email',
        'image',
        'gender',
        'address',
        'phone',
        'date_of_birth',
        'major',
        'is_active',
        'is_graduate',
        'enrollment_date',
        'graduation_date'
    ];

    protected $hidden = [
        'student_password',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'enrollment_date' => 'date',
        'graduation_date' => 'date',
        'is_active' => 'boolean',
        'is_graduate' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the attendance records for the student.
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'student_id', 'student_id');
    }

    /**
     * Get the subjects the student is enrolled in through attendance.
     */
    public function subjects()
    {
        return $this->hasManyThrough(Subject::class, Attendance::class, 'student_id', 'subject_id', 'student_id', 'subject_id');
    }

    /**
     * Scope a query to only include active students.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include graduated students.
     */
    public function scopeGraduated($query)
    {
        return $query->where('is_graduate', true);
    }

    /**
     * Scope a query to only include non-graduated students.
     */
    public function scopeNotGraduated($query)
    {
        return $query->where('is_graduate', false);
    }

    /**
     * Get the password attribute.
     */
    public function getAuthPassword()
    {
        return $this->student_password;
    }
        
}
