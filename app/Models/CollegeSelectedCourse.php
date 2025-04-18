<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollegeSelectedCourse extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'link',
        'semester',
        'department',
        'added_by',
    ];
}
