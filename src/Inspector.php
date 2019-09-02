<?php

namespace webignition\WebDriverElementInspector;

use Facebook\WebDriver\WebDriverElement;
use webignition\WebDriverElementCollection\RadioButtonCollection;

class Inspector
{
    const INPUT_ELEMENT_TAG_NAME = 'input';
    const TEXTAREA_TAG_NAME = 'textarea';

    const VALUE_ATTRIBUTE = 'value';

    public static function create(): Inspector
    {
        return new Inspector();
    }

    public function getValue(WebDriverElement $element): ?string
    {
        $tagName = $element->getTagName();

        if (self::INPUT_ELEMENT_TAG_NAME === $tagName) {
            return $this->getValueAttribute($element);
        }

        if (self::TEXTAREA_TAG_NAME === $tagName) {
            return $element->getText();
        }

        return null;
    }

    public function getRadioGroupValue(RadioButtonCollection $collection): ?string
    {
        foreach ($collection as $radioButton) {
            if ($radioButton->isSelected()) {
                return $this->getValueAttribute($radioButton);
            }
        }

        return null;
    }

    private function getValueAttribute(WebDriverElement $element): ?string
    {
        return $element->getAttribute(self::VALUE_ATTRIBUTE);
    }
}
