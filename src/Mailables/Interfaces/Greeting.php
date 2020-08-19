<?php

namespace Sfneal\PostOffice\Mailables\Interfaces;

interface Greeting
{
    /**
     * Retrieve a string with the greeting line of the mailable.
     *
     * @return string
     */
    public function getGreeting(): string;
}
