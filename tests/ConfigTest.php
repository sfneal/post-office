<?php

namespace Sfneal\PostOffice\Tests;

class ConfigTest extends TestCase
{
    /** @test */
    public function config_is_accessible()
    {
        $this->assertIsArray(config('post-office'));
    }

    /** @test */
    public function queue()
    {
        $expected = 'default';
        $output = config('post-office.queue');

        $this->assertIsString($output);
        $this->assertSame($expected, $output);
    }

    /** @test */
    public function driver()
    {
        $expected = config('queue.default');
        $output = config('post-office.driver');

        $this->assertIsString($output);
        $this->assertSame($expected, $output);
    }
}
