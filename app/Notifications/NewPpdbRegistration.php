<?php

namespace App\Notifications;

use App\Models\PpdbRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class NewPpdbRegistration extends Notification
{
    use Queueable;

    protected $registration;

    public function __construct(PpdbRegistration $registration)
    {
        $this->registration = $registration;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'Pendaftaran PPDB Baru',
            'message' => 'Pendaftaran baru dari ' . $this->registration->student_name,
            'registration_id' => $this->registration->id,
            'registration_number' => $this->registration->registration_number,
            'student_name' => $this->registration->student_name,
            'icon' => 'user-plus',
            'url' => route('admin.ppdb-registrations.show', $this->registration->id),
        ];
    }
}
