<?php

namespace Sfneal\PostOffice\Tests\Unit;

use Illuminate\Support\Facades\Notification;
use Sfneal\PostOffice\Notifications\Notification as SfnealNotification;
use Sfneal\PostOffice\Tests\Assets\InvoiceUnpaidNotification;
use Sfneal\PostOffice\Tests\TestCase;
use Sfneal\Users\Models\User;

class NotificationTest extends TestCase
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
     * Setup the test environment.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->invoice_id = rand(1, 999);

        // Fake notification sending
        Notification::fake();

        // Assert that no notifications were sent...
        Notification::assertNothingSent();
    }

    /** @test */
    public function mailable_was_created()
    {
        $notification = new InvoiceUnpaidNotification($this->user, $this->invoice_id);

        $this->assertNotNull($notification);
        $this->assertInstanceOf(SfnealNotification::class, $notification);
        $this->assertInstanceOf(InvoiceUnpaidNotification::class, $notification);
    }

    /** @test */
    public function notification_was_sent()
    {
        (new InvoiceUnpaidNotification($this->user, $this->invoice_id))->send($this->user);
        Notification::assertSentTo([$this->user], function (InvoiceUnpaidNotification $notification) {
            return $notification->invoice_id == $this->invoice_id && $notification->user == $this->user;
        });
    }

    /** @test */
    public function notification_was_sent_now()
    {
        (new InvoiceUnpaidNotification($this->user, $this->invoice_id))->sendNow($this->user);
        Notification::assertSentTo([$this->user], function (InvoiceUnpaidNotification $notification) {
            return $notification->invoice_id == $this->invoice_id && $notification->user == $this->user;
        });
    }

    /** @test */
    public function notification_array_is_correct()
    {
        $notification = new InvoiceUnpaidNotification($this->user, $this->invoice_id);
        $array = $notification->toArray($this->user);

        $this->assertIsArray($array);
        $this->assertEquals([
            'user_id' => $this->user->getKey(),
            'invoice_id' => $this->invoice_id,
        ], $array);
    }
}
