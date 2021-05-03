<?php


namespace Sfneal\PostOffice\Tests\Assets;


use Illuminate\Notifications\Messages\MailMessage;
use Sfneal\PostOffice\Mailables\AbstractMailable;
use Sfneal\PostOffice\Notifications\AbstractNotification;
use Sfneal\Users\Models\User;

class InvoiceUnpaidNotification extends AbstractNotification
{
    /**
     * @var User
     */
    public $user;

    /**
     * @var int
     */
    public $invoice_id;

    /**
     * InvoicePaidMailable constructor.
     *
     * @param User $user
     * @param int $invoice_id
     */
    public function __construct(User $user, int $invoice_id)
    {
        $this->user = $user;
        $this->invoice_id = $invoice_id;
        parent::__construct();
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return InvoiceUnpaidMailable
     */
    public function toMail($notifiable): InvoiceUnpaidMailable
    {
        return (new InvoiceUnpaidMailable($this->user, $this->invoice_id))->to($notifiable->email);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable): array
    {
        return [
            'user_id' => $this->user->getKey(),
            'invoice_id' => $this->invoice_id,
        ];
    }
}
