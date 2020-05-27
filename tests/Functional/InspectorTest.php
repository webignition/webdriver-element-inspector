<?php

declare(strict_types=1);

namespace webignition\WebDriverElementInspector\Tests\Functional;

use webignition\DomElementIdentifier\ElementIdentifier;
use webignition\SymfonyDomCrawlerNavigator\Navigator;
use webignition\WebDriverElementInspector\Inspector;

class InspectorTest extends AbstractTestCase
{
    private Inspector $inspector;

    protected function setUp(): void
    {
        parent::setUp();

        $this->inspector = Inspector::create();
    }

    /**
     * @dataProvider getValueDataProvider
     */
    public function testGetValue(string $fixture, string $elementCssSelector, ?string $expectedValue)
    {
        $crawler = self::$client->request('GET', $fixture);
        $navigator = Navigator::create($crawler);
        $collection = $navigator->find(new ElementIdentifier($elementCssSelector));

        $this->assertSame($expectedValue, $this->inspector->getValue($collection));
    }

    public function getValueDataProvider(): array
    {
        return [
            'radio button collection, none checked' => [
                'fixture' => '/form.html',
                'elementCssSelector' => 'input[type="radio"][name="radio-not-checked"]',
                'expectedValue' => null,
            ],
            'radio button collection, has checked' => [
                'fixture' => '/form.html',
                'elementCssSelector' => 'input[type="radio"][name="radio-checked"]',
                'expectedValue' => 'checked-2',
            ],
            'select option collection, none selected' => [
                'fixture' => '/form.html',
                'elementCssSelector' => 'select[name="select-none-selected"] option',
                'expectedValue' => 'none-selected-1',
            ],
            'select option collection, has selected' => [
                'fixture' => '/form.html',
                'elementCssSelector' => 'select[name="select-has-selected"] option',
                'expectedValue' => 'has-selected-3',
            ],
            'select, none selected' => [
                'fixture' => '/form.html',
                'elementCssSelector' => 'select[name="select-none-selected"]',
                'expectedValue' => 'none-selected-1',
            ],
            'select, has selected' => [
                'fixture' => '/form.html',
                'elementCssSelector' => 'select[name="select-has-selected"]',
                'expectedValue' => 'has-selected-3',
            ],
            'collection of unrelated elements' => [
                'fixture' => '/form.html',
                'elementCssSelector' => 'input',
                'expectedValue' => null,
            ],
            'input, empty value' => [
                'fixture' => '/form.html',
                'elementCssSelector' => 'input[name="input-with-empty-value"]',
                'expectedValue' => '',
            ],
            'input, non-empty value' => [
                'fixture' => '/form.html',
                'elementCssSelector' => 'input[name="input-with-non-empty-value"]',
                'expectedValue' => 'value content',
            ],
            'input, no value attribute' => [
                'fixture' => '/form.html',
                'elementCssSelector' => 'input[name="input-without-value"]',
                'expectedValue' => '',
            ],
            'textarea element, empty' => [
                'fixture' => '/form.html',
                'elementCssSelector' => 'textarea[name="empty-textarea"]',
                'expectedValue' => '',
            ],
            'textarea element, non-empty' => [
                'fixture' => '/form.html',
                'elementCssSelector' => 'textarea[name="non-empty-textarea"]',
                'expectedValue' => 'textarea content',
            ],
            'paragraph, content with no line returns' => [
                'fixture' => '/content.html',
                'elementCssSelector' => '.p1',
                'expectedValue' => 'Single non-breaking line',
            ],
            'paragraph, content wrapped in line returns' => [
                'fixture' => '/content.html',
                'elementCssSelector' => '.p2',
                'expectedValue' => 'Single non-breaking line wrapped in line returns',
            ],
            'paragraph, content wrapped in many line returns' => [
                'fixture' => '/content.html',
                'elementCssSelector' => '.p3',
                'expectedValue' => 'Single non-breaking line wrapped in many line returns',
            ],
        ];
    }
}
