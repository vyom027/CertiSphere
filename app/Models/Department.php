<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $table = 'department';

    protected $primaryKey = 'dept_id';

    protected $fillable = [
        'name',
    ];

    public function batches()
    {
        return $this->belongsTo(Batch::class, 'dept_id', 'dept_id');
    }
}
