<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    use HasFactory;

    protected $table = 'batch';

    protected $primaryKey = 'batch_id';

    protected $fillable = [
        'dept_id',
        'start_year',
        'end_year',
    ];

   
    public function department()
    {
        return $this->belongsTo(Department::class, 'dept_id', 'dept_id');
    }
    
}
