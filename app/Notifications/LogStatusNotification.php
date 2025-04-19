<?php

namespace App\Notifications;

use App\Models\Log;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;

class LogStatusNotification extends Notification
{
    use Queueable;

    protected $log;
    protected $status;

    public function __construct(Log $log, $status)
    {
        $this->log = $log;
        $this->status = $status;
    }

    public function via($notifiable)
    {
        return ['database']; // Bisa tambahkan 'mail' jika ingin email juga
    }

    public function toDatabase($notifiable)
    {
        return new DatabaseMessage([
            'message' => "Log Anda tanggal {$this->log->created_at->format('d M Y')} telah {$this->status}.",
            'log_id' => $this->log->id,
            'status' => $this->status,
        ]);
    }
}