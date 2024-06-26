<?php

namespace Sfneal\PostOffice\MailCenter;

use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;
use Sfneal\Queueables\Job;

class SendMail extends Job
{
    /**
     * @var string Email address of recipient
     */
    public $to;

    /**
     * @var string Email address of users to CC
     */
    public $cc;

    /**
     * @var Mailable The mailable to send to the recipient
     */
    public $mailable;

    /**
     * Create a new job instance.
     *
     * @param  string  $to
     * @param  Mailable  $mailable
     * @param  array|null  $cc
     */
    public function __construct(string $to, Mailable $mailable, array $cc = null)
    {
        $this->to = $to;
        $this->mailable = $mailable;
        $this->cc = $cc;

        $this->onQueue(config('post-office.queue'));
        $this->onConnection(config('post-office.driver'));
    }

    /**
     * Execute the job.
     *
     * @return bool
     */
    public function handle(): bool
    {
        $sent = $this->send();

        // Fail the Job if the mailable was not sent
        if (! $sent) {
            $this->fail();

            return false;
        }

        return true;
    }

    /**
     * Send a Mailable to an email recipient with optional CC recipients.
     *
     * @return bool
     */
    private function send(): bool
    {
        // Initialize
        $mail = Mail::to($this->to);

        // CC users if provided
        if (isset($this->cc)) {
            $mail->cc($this->cc);
        }

        // Send mail
        $mail->send($this->mailable);

        // Confirm Email was sent
        return Mail::hasSent($this->mailable);
    }
}
