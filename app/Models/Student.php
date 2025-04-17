<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $table = 'students';

    protected $primaryKey = 'enrollment_no';

    protected $fillable = [
        'enrollment_no','first_name', 'last_name', 'email', 'profile_picture', 
        'phone_number', 'batch_id', 'dept_id','division'
    ];

    // Relationship with Batch
    public function batch()
    {
        return $this->belongsTo(Batch::class, 'batch_id', 'batch_id');
    }

    // Relationship with Department
    public function department()
    {
        return $this->belongsTo(Department::class, 'dept_id' , 'dept_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }
    
    public function routeNotificationFor($notification)
    {
        return $this->email; // Assuming the email column in your students table is called 'email'
    }
}
