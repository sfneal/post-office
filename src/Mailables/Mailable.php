<?php

namespace Sfneal\PostOffice\Mailables;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;

abstract class Mailable extends \Illuminate\Mail\Mailable
{
    // todo: refactor to allow interfaces to set properties without passing to constructor
    // todo: refactor to use basic mailable building instead of views (new class?)
    use Queueable, SerializesModels;

    /**
     * @var string View blade to use for mailable content
     */
    public $view;

    /**
     * @var string First line of the email body
     */
    public $greeting;

    /**
     * @var string Recipient email address
     */
    public $email;

    /**
     * @var string Subject of the email
     */
    public $title;

    /**
     * @var array|string Array of strings to be displayed as paragraphs
     */
    public $messages;

    /**
     * @var array Action button url and text
     */
    public $call_to_action;

    /**
     * Mailable constructor.
     *
     * @param  string|null  $greeting
     * @param  string|null  $email
     * @param  string|null  $title
     * @param  null  $messages
     * @param  array|null  $call_to_action
     * @param  string|null  $view
     */
    public function __construct(string $greeting = null,
                                string $email = null,
                                string $title = null,
                                $messages = null,
                                array $call_to_action = null,
                                string $view = null)
    {
        $this->greeting = $greeting ?? $this->greeting;
        $this->email = $email ?? $this->email;
        $this->title = $title ?? $this->title;
        /** @phpstan-ignore-next-line */
        $this->messages = $messages ?? $this->messages;
        $this->call_to_action = $call_to_action ?? $this->call_to_action;

        $this->view = $this->setView($view);
        $this->onQueue(config('post-office.queue'));
        $this->onConnection(config('post-office.driver'));
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): self
    {
        return $this->subject($this->title)
            ->view($this->view, [
                'greeting' => $this->greeting,
                'email' => $this->email,
                'title' => $this->title,
                'messages' => $this->messages,
                'call_to_action' => $this->call_to_action,
            ]);
    }

    /**
     * Set the Mailable's $view property.
     *
     *  1. $view parameter passed to the constructor
     *  2. $view property declared in child `AbstractMailable` extension
     *  3. 'post-office.mailable.view' config value (defaults to post-office::email)
     *
     * @param  string|null  $view
     * @return string
     */
    private function setView(string $view = null): string
    {
        return $view ?? $this->view ?? config('post-office.mailables.view');
    }
}
