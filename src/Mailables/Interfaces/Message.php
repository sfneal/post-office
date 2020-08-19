<?php

namespace Sfneal\PostOffice\Mailables\Interfaces;

interface Message
{
    /**
     * Retrieve an array of messages to include in a mailable.
     *
     * @return array
     */
    public function getMessages(): array;
}
