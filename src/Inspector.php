<?php

namespace webignition\WebDriverElementInspector;

use Facebook\WebDriver\WebDriverElement;
use webignition\WebDriverElementCollection\RadioButtonCollection;
use webignition\WebDriverElementCollection\SelectOptionCollection;
use webignition\WebDriverElementCollection\WebDriverElementCollectionInterface;

class Inspector
{
    const INPUT_ELEMENT_TAG_NAME = 'input';
    const TEXTAREA_TAG_NAME = 'textarea';
    const SELECT_TAG_NAME = 'select';

    const VALUE_ATTRIBUTE = 'value';

    public static function create(): Inspector
    {
        return new Inspector();
    }

    public function getValue(WebDriverElementCollectionInterface $collection): ?string
    {
        if ($collection instanceof RadioButtonCollection || $collection instanceof SelectOptionCollection) {
            return $this->getSelectedCollectionValue($collection);
        }

        if (1 === count($collection)) {
            $element = $collection->get(0);

            if ($element instanceof WebDriverElement) {
                return $this->getElementValue($element);
            }
        }

        return null;
    }

    private function getElementValue(WebDriverElement $element): ?string
    {
        $tagName = $element->getTagName();

        if (in_array($tagName, [self::INPUT_ELEMENT_TAG_NAME, self::TEXTAREA_TAG_NAME, self::SELECT_TAG_NAME])) {
            return $this->getValueAttribute($element);
        }

        return $element->getText();
    }

    private function getValueAttribute(WebDriverElement $element): ?string
    {
        return $element->getAttribute(self::VALUE_ATTRIBUTE);
    }

    private function getSelectedCollectionValue(WebDriverElementCollectionInterface $collection): ?string
    {
        foreach ($collection as $item) {
            if ($item->isSelected()) {
                return $this->getValueAttribute($item);
            }
        }

        return null;
    }
}
