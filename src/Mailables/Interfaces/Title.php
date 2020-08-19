<?php

namespace Sfneal\PostOffice\Mailables\Interfaces;

interface Title
{
    /**
     * Retrieve the Mailable's subject/title.
     *
     * @return string
     */
    public function getTitle(): string;
}
