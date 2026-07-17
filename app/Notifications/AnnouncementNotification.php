<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AnnouncementNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $title;
    protected $message;

    public function __construct($title, $message)
    {
        $this->title = $title;
        $this->message = $message;
    }

    // Mengirim via Email dan Database
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    // Desain Email yang akan diterima anggota
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Pengumuman HIMA: ' . $this->title)
                    ->greeting('Halo ' . $notifiable->name . '!')
                    ->line($this->message)
                    ->action('Lihat Detail di Dashboard', url('/dashboard'))
                    ->line('Terima kasih atas dedikasi Anda di Himpunan Mahasiswa!');
    }

    // Data yang disimpan di tabel notifikasi (untuk UI Dashboard)
    public function toArray(object $notifiable): array
    {
        return [
            'title' => $this->title,
            'message' => $this->message,
        ];
    }
}