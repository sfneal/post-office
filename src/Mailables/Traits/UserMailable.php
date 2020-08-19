<?php


namespace Sfneal\PostOffice\Mailables\Traits;


trait UserMailable
{
    /**
     * @return string First line of email
     */
    public function getGreeting(): string {
        return "Hi {$this->user->first_name}";
    }

    /**
     * Email recipient
     *
     * @return string
     */
    public function getEmail(): string {
        return $this->user->email;
    }
}
