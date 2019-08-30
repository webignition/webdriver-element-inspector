<?php

namespace webignition\WebDriverElementInspector\Tests\Unit;

use webignition\WebDriverElementInspector\Inspector;

class InspectorTest extends \PHPUnit\Framework\TestCase
{
    public function testCreate()
    {
        $inspector = new Inspector();

        $this->assertInstanceOf(Inspector::class, $inspector);
    }
}
