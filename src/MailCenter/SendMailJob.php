<?php

namespace Sfneal\PostOffice\MailCenter;

use Illuminate\Mail\Mailable;
use Sfneal\Queueables\AbstractJob;

// TODO: create package SendMail?
class SendMailJob extends AbstractJob
{
    /**
     * @var string Queue to use
     */
    public $queue = 'mail';

    /**
     * @var string Queue connection to use
     */
    public $connection = 'database';

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
     * @param string $to
     * @param Mailable $mailable
     * @param array|null $cc
     */
    public function __construct(string $to, Mailable $mailable, array $cc = null)
    {
        $this->to = $to;
        $this->mailable = $mailable;
        $this->cc = $cc;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (!SendMailAction::execute($this->mailable, $this->to, $this->cc)) {
            $this->fail();
        }
    }
}
