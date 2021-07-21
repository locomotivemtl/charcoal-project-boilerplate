<?php

namespace Tests\App\Template;

use App\Template\AbstractTemplate;
use Psr\Log\NullLogger;
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
    public function setUp(): void
    {
        $this->obj = $this->createTemplate();
    }

    /**
     * Test debug boolean.
     *
     * @covers \App\Template\AbstractTemplate::debug
     * @return void
     */
    public function testDebugIsFalseByDefault(): void
    {
        $this->assertFalse($this->obj->debug());
    }

    /**
     * Create object to test.
     *
     * @return AbstractTemplate
     */
    protected function createTemplate(): AbstractTemplate
    {
        $mock = $this->getMockBuilder(AbstractTemplate::class)
                     ->disableOriginalConstructor()
                     ->getMockForAbstractClass();

        $mock->setLogger(new NullLogger());

        return $mock;
    }
}
