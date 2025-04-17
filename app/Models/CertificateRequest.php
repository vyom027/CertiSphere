<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CertificateRequest extends Model
{
    protected $fillable = [
        'course_name', 'department_id', 'batch_id', 'description','status'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'dept_id');
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class, 'batch_id', 'batch_id');
    }

    public function certificateSubmissions()
    {
        return $this->hasMany(CertificateSubmission::class, 'certificate_request_id');
    }


}
