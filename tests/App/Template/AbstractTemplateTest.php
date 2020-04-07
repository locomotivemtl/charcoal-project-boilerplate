<?php

namespace Tests\App\Template;

// From 'psr/log'
use Psr\Log\NullLogger;

// From App
use App\Template\AbstractTemplate;
use Tests\TestCase;

/**
 * Class AbstractTemplateTest
 */
class AbstractTemplateTest extends TestCase
{
    /**
     * The class to test.
     *
     * @var AbstractTemplate
     */
    private $obj;

    /**
     * @return void
     */
    public function setUp()
    {
        $this->obj = $this->createTemplate();
    }

    /**
     * Test debug boolean.
     *
     * @covers \App\Template\AbstractTemplate::debug
     * @return void
     */
    public function testDebugIsFalseByDefault()
    {
        $this->assertFalse($this->obj->debug());
    }

    /**
     * Create object to test.
     *
     * @return AbstractTemplate
     */
    protected function createTemplate()
    {
        $mock = $this->getMockBuilder(AbstractTemplate::class)
                     ->disableOriginalConstructor()
                     ->getMockForAbstractClass();

        $mock->setLogger(new NullLogger());

        return $mock;
    }
}
