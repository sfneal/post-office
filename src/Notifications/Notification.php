<?php

namespace Sfneal\PostOffice\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Bus\Queueable as QueueableTrait;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Sfneal\PostOffice\Mailables\Mailable;

abstract class Notification extends \Illuminate\Notifications\Notification implements ShouldQueue
{
    use Queueable, InteractsWithQueue, QueueableTrait, SerializesModels;

    /**
     * @var array channels to send notification via
     */
    private const VIA = ['mail'];

    /**
     * @var array channels to send notification via
     */
    public $via;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        $this->via = $this->via ?? ['mail'];
        $this->onQueue(config('post-office.queue'));
        $this->onConnection(config('post-office.driver'));
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable): array
    {
        return $this->via;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return MailMessage|Mailable
     */
    abstract public function toMail($notifiable);

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    abstract public function toArray($notifiable): array;

    /**
     * Send the Notification using the `Illuminate\Support\Facades\Notification` facade.
     *
     * @param Collection|array|mixed $notifiables
     */
    public function send($notifiables): void
    {
        \Illuminate\Support\Facades\Notification::send($notifiables, $this);
    }

    /**
     * Send the Notification immediately using the `Illuminate\Support\Facades\Notification` facade.
     *
     * @param Collection|array|mixed $notifiables
     */
    public function sendNow($notifiables): void
    {
        \Illuminate\Support\Facades\Notification::sendNow($notifiables, $this);
    }
}
