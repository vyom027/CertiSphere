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



    public function certificateRequest()
    {
        return $this->belongsTo(CertificateRequest::class);
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class, 'batch_id', 'batch_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'dept_id', 'dept_id');
    }
}
