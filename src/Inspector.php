<?php

namespace webignition\WebDriverElementInspector;

use Facebook\WebDriver\WebDriverElement;

class Inspector
{
    const INPUT_ELEMENT_VALUE_ATTRIBUTE = 'value';

    public static function create(): Inspector
    {
        return new Inspector();
    }

    public function getValue(WebDriverElement $element): ?string
    {
        return $element->getAttribute(self::INPUT_ELEMENT_VALUE_ATTRIBUTE);
    }
}
