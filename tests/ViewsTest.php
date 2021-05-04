<?php

namespace Sfneal\PostOffice\Tests;

use Sfneal\PostOffice\Tests\Assets\InvoiceUnpaidMailable;
use Sfneal\Users\Models\User;

class ViewsTest extends TestCase
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
    public function email_view_can_be_rendered()
    {
        $data = [
            'greeting' => $this->mailable->getGreeting(),
            'email' => $this->mailable->getEmail(),
            'title' => $this->mailable->getTitle(),
            'messages' => $this->mailable->getMessages(),
            'call_to_action' => $this->mailable->getCallToAction(),
        ];
        $view = view('post-office::email', $data);

        $this->assertStringContainsString($data['greeting'], $view);
        $this->assertStringContainsString($data['title'], $view);
        foreach ($data['messages'] as $message) {
            $this->assertStringContainsString(htmlentities($message, ENT_QUOTES), $view);
        }
    }
}
