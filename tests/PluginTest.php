<?php

namespace Weirdan\PsalmPluginRdKafka\Tests;

use SimpleXMLElement;
use Weirdan\PsalmPluginRdKafka\Plugin;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Psalm\Plugin\RegistrationInterface;

class PluginTest extends TestCase
{
    /**
     * @var ObjectProphecy
     */
    private $registration;

    public function setUp(): void
    {
        $this->registration = $this->prophesize(RegistrationInterface::class);
    }

    /**
     * @test
     * @return void
     */
    public function hasEntryPoint()
    {
        $this->expectNotToPerformAssertions();
        $plugin = new Plugin();
        $plugin($this->registration->reveal(), null);
    }

    /**
     * @test
     * @return void
     */
    public function acceptsConfig()
    {
        $this->expectNotToPerformAssertions();
        $plugin = new Plugin();
        $plugin($this->registration->reveal(), new SimpleXMLElement('<myConfig></myConfig>'));
    }
}
