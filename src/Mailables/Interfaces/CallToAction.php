<?php

namespace Sfneal\PostOffice\Mailables\Interfaces;

interface CallToAction
{
    /**
     * Call to Action button in the body of the email.
     *
     * @return array
     */
    public function getCallToAction(): array;
}
