<?php

namespace Sfneal\PostOffice\Tests;

class ConfigTest extends TestCase
{
    /** @test */
    public function config_is_accessible()
    {
        $this->assertIsArray(config('post-office'));
        $this->assertIsArray(config('post-office.mailables'));
        $this->assertIsArray(config('post-office.mailables.footer'));
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

    /** @test */
    public function mailables_view()
    {
        $expected = 'post-office::email';
        $output = config('post-office.mailables.view');

        $this->assertIsString($output);
        $this->assertSame($expected, $output);
    }

    /** @test */
    public function mailables_footer_enabled()
    {
        $output = config('post-office.mailables.footer.enabled');

        $this->assertIsBool($output);
        $this->assertTrue($output);
    }

    /** @test */
    public function mailables_footer_address()
    {
        $expected = '35 Main Street, Milford MA 01747';
        $output = config('post-office.mailables.footer.address');

        $this->assertIsString($output);
        $this->assertSame($expected, $output);
    }

    /** @test */
    public function mailables_footer_unsubscribe_route()
    {
        $expected = 'unsubscribe';
        $output = config('post-office.mailables.footer.unsubscribe_route');

        $this->assertIsString($output);
        $this->assertSame($expected, $output);
    }
}
