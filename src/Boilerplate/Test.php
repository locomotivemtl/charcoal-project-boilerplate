<?php

namespace Boilerplate;

// From `charcoal-core`
use \Charcoal\Object\Content as Content;

class Test extends Content
{
    public function __construct()
    {
        $this->metadata();
    }
}
