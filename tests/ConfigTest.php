<?php

namespace Sfneal\PostOffice\Tests;

class ConfigTest extends TestCase
{
    /** @test */
    public function config_is_accessible()
    {
        $this->assertIsArray(config('post-office'));
    }
}
