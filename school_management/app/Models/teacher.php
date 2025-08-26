<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class teacher extends Model
{
    /** @use HasFactory<\Database\Factories\TeacherFactory> */
    use HasFactory, SoftDeletes;
    protected $primaryKey = 'teacher_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'teacher_name',
        'teacher_email',
        'teacher_password',
        'image',
        'phone',
        'is_active'
    ];

    protected $hidden = [
        'teacher_password',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the subjects taught by the teacher.
     */
    public function subject()
    {
        return $this->hasMany(Subject::class, 'teacher_id', 'teacher_id');
    }

    /**
     * Get the attendance records for the teacher's subjects.
     */
    public function attendances()
    {
        return $this->hasManyThrough(Attendance::class, Subject::class, 'teacher_id', 'subject_id', 'teacher_id', 'subject_id');
    }

    /**
     * Get the password attribute.
     */
    public function getAuthPassword()
    {
        return $this->teacher_password;
    }
}
