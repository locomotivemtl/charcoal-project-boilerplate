<?php

namespace Boilerplate\Tests\Template;

// From PHPUnit
use PHPUnit_Framework_TestCase;

// From PSR-3
use Psr\Log\NullLogger;

// From 'charcoal-project-boilerplate'
use Boilerplate\Template\AbstractBoilerplateTemplate;

/**
 * Class AbstractBoilerplateTemplateTest
 */
class AbstractBoilerplateTemplateTest extends PHPUnit_Framework_TestCase
{
    /**
     * The class to test.
     *
     * @var AbstractBoilerplateTemplate
     */
    private $obj;

    /**
     * Setup the test.
     */
    public function setUp()
    {
        $mock = $this->getMockBuilder(AbstractBoilerplateTemplate::class)
                     ->disableOriginalConstructor()
                     ->getMockForAbstractClass();

        $mock->setLogger(new NullLogger());

        $this->obj = $mock;
    }

    public function testDebugIsFalseByDefault()
    {
        $this->assertFalse($this->obj->debug());
    }
}
