<?php

namespace Sfneal\PostOffice\Tests\Feature;

use Sfneal\PostOffice\Mailables\Mailable;
use Sfneal\PostOffice\Tests\Assets\InvoiceUnpaidMailable;
use Sfneal\PostOffice\Tests\TestCase;
use Sfneal\Users\Models\User;

class MailableTest extends TestCase
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
    }

    /** @test */
    public function mailable_was_created()
    {
        $this->assertNotNull($this->mailable);
        $this->assertInstanceOf(Mailable::class, $this->mailable);
        $this->assertInstanceOf(InvoiceUnpaidMailable::class, $this->mailable);
    }

    /** @test */
    public function mailable_has_greeting()
    {
        $this->assertTrue(method_exists($this->mailable, 'getGreeting'));
        $this->mailable->assertSeeInHtml("Hi {$this->user->first_name}");
    }

    /** @test */
    public function mailable_has_email()
    {
        $this->assertTrue(method_exists($this->mailable, 'getEmail'));
        $this->assertSame($this->user->email, $this->mailable->email);
    }

    /** @test */
    public function mailable_has_title()
    {
        $title = "Unpaid Invoice: #{$this->invoice_id}";
        $this->assertTrue(method_exists($this->mailable, 'getTitle'));
        $this->mailable->assertSeeInHtml($title);
        $this->assertSame($title, $this->mailable->subject);
    }

    /** @test */
    public function mailable_has_message()
    {
        $this->assertTrue(method_exists($this->mailable, 'getMessages'));
        $this->mailable->assertSeeInHtml(htmlentities('You have one or more unpaid invoices.  Please send use money asap!', ENT_QUOTES));
        $this->mailable->assertSeeInHtml(htmlentities("If your invoice is not paid within 30 days we're going to send a team of ninja's to your last known location.", ENT_QUOTES));
    }

    /** @test */
    public function mailable_has_call_to_action()
    {
        $this->assertTrue(method_exists($this->mailable, 'getCallToAction'));
        $this->mailable->assertSeeInHtml('https://google.com');
        $this->mailable->assertSeeInHtml('Pay Invoice');
    }

    /** @test */
    public function mailable_has_footer()
    {
        $this->mailable->assertSeeInHtml('<div class="footer">');
        $this->mailable->assertSeeInHtml(config('post-office.mailables.footer.address'));
        $this->mailable->assertSeeInHtml(route(
            config('post-office.mailables.footer.unsubscribe_route'),
            ['email' => $this->user->email]
        ));
    }
}
