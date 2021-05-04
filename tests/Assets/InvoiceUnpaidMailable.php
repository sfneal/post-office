<?php

namespace Sfneal\PostOffice\Tests\Assets;

use Sfneal\PostOffice\Mailables\AbstractMailable;
use Sfneal\PostOffice\Mailables\Interfaces\CallToAction;
use Sfneal\PostOffice\Mailables\Interfaces\Email;
use Sfneal\PostOffice\Mailables\Interfaces\Greeting;
use Sfneal\PostOffice\Mailables\Interfaces\Message;
use Sfneal\PostOffice\Mailables\Interfaces\Title;
use Sfneal\PostOffice\Mailables\Traits\UserMailable;
use Sfneal\Users\Models\User;

class InvoiceUnpaidMailable extends AbstractMailable implements Greeting, Email, Title, Message, CallToAction
{
    use UserMailable;

    /**
     * @var string View blade to use for mailable content
     */
    public $view = 'post-office::email';

    /**
     * @var User
     */
    private $user;

    /**
     * @var int
     */
    private $invoice_id;

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
        parent::__construct(
            $this->getGreeting(),
            $this->getEmail(),
            $this->getTitle(),
            $this->getMessages(),
            $this->getCallToAction()
        );
    }

    /**
     * Retrieve the Mailable's subject/title.
     *
     * @return string
     */
    public function getTitle(): string
    {
        return "Unpaid Invoice: #{$this->invoice_id}";
    }

    /**
     * Retrieve an array of messages to include in a mailable.
     *
     * @return array
     */
    public function getMessages(): array
    {
        return [
            'You have one or more unpaid invoices.  Please send use money asap!',
            "If your invoice is not paid within 30 days we're going to send a team of ninja's to your last known location.",
        ];
    }

    /**
     * Call to Action button in the body of the email.
     *
     * @return array
     */
    public function getCallToAction(): array
    {
        return [
            'url' => 'https://google.com',
            'text' => 'Pay Invoice',
        ];
    }
}
