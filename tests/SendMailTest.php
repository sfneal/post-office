<?php

namespace Sfneal\PostOffice\Tests;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
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
        $sent = (new SendMail($this->user->email, $this->mailable))->handle();

        $this->assertTrue($sent);

        // Assert that a mailable was sent...
        Mail::assertSent(function (InvoiceUnpaidMailable $mailable) {
            return $mailable->email == $this->user->email;
        });
    }

    /** @test */
    public function mail_can_be_queued()
    {
        // Enable queue faking
        Queue::fake();

        // Assert that no jobs were pushed...
        Queue::assertNothingPushed();

        // Dispatch the first job...
        Queue::push(new SendMail($this->user->email, $this->mailable));

        // Assert a job was pushed...
        Queue::assertPushed(function (SendMail $sender) {
            return $sender->mailable === $this->mailable;
        });
    }

    /** @test */
    public function mail_can_be_queued_on_queue()
    {
        // Enable queue faking
        Queue::fake();

        // Assert that no jobs were pushed...
        Queue::assertNothingPushed();

        // Dispatch the first job...
        Queue::pushOn(
            config('post-office.queue'),
            new SendMail($this->user->email, $this->mailable)
        );

        // Assert a job was pushed...
        Queue::assertPushedOn(config('post-office.queue'), function (SendMail $sender) {
            return $sender->mailable === $this->mailable;
        });
    }
}
