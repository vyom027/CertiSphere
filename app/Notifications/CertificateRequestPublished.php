<?php

namespace App\Notifications;

use App\Models\CertificateRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CertificateRequestPublished extends Notification implements ShouldQueue
{
    use Queueable;

    private $certificateRequest;

    public function __construct(CertificateRequest $certificateRequest)
    {
        $this->certificateRequest = $certificateRequest;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        // Pass the data to the view
        return (new MailMessage)
            ->subject('New Certificate Request Published')
            ->markdown('admin.notification.certificate_request_published', [
                'certificateRequest' => $this->certificateRequest,
                'student' => $notifiable, // Assuming 'notifiable' is the Student model
            ]);
    }

    public function toArray($notifiable)
    {
        return [
            'certificate_request_id' => $this->certificateRequest->id,
        ];
    }
}
