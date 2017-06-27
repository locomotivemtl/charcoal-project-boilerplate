<?php

namespace Boilerplate\Tests\Template;

use Boilerplate\Template\AbstractBoilerplateTemplate;

use PHPUnit_Framework_TestCase;

/**
 * Class AbstractBoilerplateTemplateTest
 */
class AbstractBoilerplateTemplateTest extends PHPUnit_Framework_TestCase
{
    /**
     * Object (mock) under test
     * @var AbstractBoilerplateTemplate
     */
    private $obj;

    public function setUp()
    {
        $this->obj = $this->getMockForAbstractClass(AbstractBoilerplateTemplate::class);
    }

    public function testDebugIsFalseByDefault()
    {
        $this->assertFalse($this->obj->debug());
    }
}
