<?php

namespace webignition\WebDriverElementInspector;

use Facebook\WebDriver\WebDriverElement;

class Inspector
{
    const INPUT_ELEMENT_TAG_NAME = 'input';
    const TEXTAREA_TAG_NAME = 'textarea';

    const INPUT_ELEMENT_VALUE_ATTRIBUTE = 'value';

    public static function create(): Inspector
    {
        return new Inspector();
    }

    public function getValue(WebDriverElement $element): ?string
    {
        $tagName = $element->getTagName();

        if (self::INPUT_ELEMENT_TAG_NAME === $tagName) {
            return $element->getAttribute(self::INPUT_ELEMENT_VALUE_ATTRIBUTE);
        }

        if (self::TEXTAREA_TAG_NAME === $tagName) {
            return $element->getText();
        }

        return '';
    }
}
