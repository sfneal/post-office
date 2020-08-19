<?php


namespace Sfneal\PostOffice\MailCenter;


use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;
use Sfneal\Actions\AbstractActionStatic;

class SendMailAction extends AbstractActionStatic
{
    /**
     * Execute the SendMailAction
     *
     * @param Mailable $mailable
     * @param string $to
     * @param array $cc
     * @return bool
     */
    public static function execute(Mailable $mailable, string $to, array $cc = null)
    {
        // Initialize
        $mail = Mail::to($to);

        // CC users if provided
        if (isset($cc)) {
            $mail->cc($cc);
        }

        // Send mail
        $mail->send($mailable);

        // Confirm Email was sent
        return empty(Mail::failures());
    }
}
