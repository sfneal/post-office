<?php

namespace Sfneal\PostOffice\Mailables\Interfaces;

interface Email
{
    /**
     * Retrieve the recipients email address.
     *
     * @return string
     */
    public function getEmail(): string;
}
