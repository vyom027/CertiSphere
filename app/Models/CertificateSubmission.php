<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CertificateSubmission extends Model
{
    use HasFactory;

    protected $table = 'certificate_submissions';

    protected $fillable = [
        'certificate_request_id',
        'enrollment_no',
        'batch_id',
        'dept_id',
        'division',
        'certificate_file',
        'submitted_at',
        'status',
    ];

    protected $dates = ['submitted_at'];

    // Relationships



    public function request()
    {
        return $this->belongsTo(CertificateRequest::class, 'certificate_request_id');
    }


    public function batch()
    {
        return $this->belongsTo(Batch::class, 'batch_id', 'batch_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'dept_id', 'dept_id');
    }
    public function student()
    {
        return $this->belongsTo(Student::class, 'enrollment_no', 'enrollment_no');
    }
}
