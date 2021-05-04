<?php

namespace Sfneal\PostOffice\Tests;

use Illuminate\Support\Facades\Mail;
use Sfneal\PostOffice\MailCenter\SendMail;
use Sfneal\PostOffice\Tests\Assets\InvoiceUnpaidMailable;
use Sfneal\Users\Models\User;

class SendMailTest extends TestCase
{
    /**
     * @var User
     */
    private $user;

    /**
     * @var int
     */
    private $invoice_id;

    /**
     * @var InvoiceUnpaidMailable
     */
    private $mailable;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->invoice_id = rand(1, 999);
        $this->mailable = new InvoiceUnpaidMailable($this->user, $this->invoice_id);

        // Enable Mail faking
        Mail::fake();

        // Assert that no mailables were sent...
        Mail::assertNothingSent();
        Mail::assertNothingQueued();

        // Assert a mailable was not sent or queued...
        Mail::assertNotSent(InvoiceUnpaidMailable::class);
        Mail::assertNotQueued(InvoiceUnpaidMailable::class);
    }

    /** @test */
    public function mail_can_be_sent()
    {
        // Send the mail
        (new SendMail($this->user->email, $this->mailable))->handle();

        // Assert that a mailable was sent...
        Mail::assertSent(function (InvoiceUnpaidMailable $mailable) {
            return $mailable->email == $this->user->email;
        });
    }

    /** @test */
//    public function mail_can_be_queued()
//    {
//        // Send the mail
//        SendMail::dispatch($this->user->email, $this->mailable);
//
//        // Assert that a mailable was sent...
//        Mail::assertQueued(function (InvoiceUnpaidMailable $mailable) {
//            return $mailable->email == $this->user->email;
//        });
//    }
}
