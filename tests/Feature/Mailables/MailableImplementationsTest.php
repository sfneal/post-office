<?php


namespace Sfneal\PostOffice\Tests\Feature\Mailables;


use Sfneal\PostOffice\Mailables\AbstractMailable;
use Sfneal\PostOffice\Tests\Assets\InvoiceUnpaidMailable;
use Sfneal\PostOffice\Tests\TestCase;
use Sfneal\Users\Models\User;

class MailableImplementationsTest extends TestCase
{
    /**
     * @var User
     */
    private $user;

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

        $this->mailable = new InvoiceUnpaidMailable($this->user, rand(1, 999));
    }

    /** @test */
    public function mailable_was_created()
    {
        $this->assertNotNull($this->mailable);
        $this->assertInstanceOf(AbstractMailable::class, $this->mailable);
        $this->assertInstanceOf(InvoiceUnpaidMailable::class, $this->mailable);
    }
}
