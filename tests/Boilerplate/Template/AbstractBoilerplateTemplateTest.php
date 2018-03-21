<?php

namespace Tests\Boilerplate\Template;

// From PSR-3
use Psr\Log\NullLogger;

// From 'charcoal-project-boilerplate'
use Boilerplate\Template\AbstractBoilerplateTemplate;
use Tests\TestCase;

/**
 * Class AbstractBoilerplateTemplateTest
 */
class AbstractBoilerplateTemplateTest extends TestCase
{
    /**
     * The class to test.
     *
     * @var AbstractBoilerplateTemplate
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
     * @covers \Boilerplate\Template\AbstractBoilerplateTemplate::debug
     * @return void
     */
    public function testDebugIsFalseByDefault()
    {
        $this->assertFalse($this->obj->debug());
    }

    /**
     * Create object to test.
     *
     * @return AbstractBoilerplateTemplate
     */
    protected function createTemplate()
    {
        $mock = $this->getMockBuilder(AbstractBoilerplateTemplate::class)
                     ->disableOriginalConstructor()
                     ->getMockForAbstractClass();

        $mock->setLogger(new NullLogger());

        return $mock;
    }
}
