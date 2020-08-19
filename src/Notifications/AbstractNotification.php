<?php

namespace Sfneal\PostOffice\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Bus\Queueable as QueueableTrait;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Sfneal\PostOffice\Mailables\AbstractMailable;

abstract class AbstractNotification extends Notification implements ShouldQueue
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
        $this->onQueue('mail');
        $this->onConnection('database');
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
     * @return MailMessage|AbstractMailable
     */
    abstract public function toMail($notifiable);

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    abstract public function toArray($notifiable): array;
}
