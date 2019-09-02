<?php
/** @noinspection PhpDocSignatureInspection */

declare(strict_types=1);

namespace webignition\WebDriverElementInspector\Tests\Functional;

use Facebook\WebDriver\WebDriverElement;
use webignition\WebDriverElementCollection\RadioButtonCollection;
use webignition\WebDriverElementCollection\SelectOptionCollection;
use webignition\WebDriverElementInspector\Inspector;

class InspectorTest extends AbstractTestCase
{
    /**
     * @var Inspector
     */
    private $inspector;

    protected function setUp(): void
    {
        parent::setUp();

        $this->inspector = Inspector::create();
    }

    /**
     * @dataProvider getValueDataProvider
     */
    public function testGetValue(string $fixture, string $elementCssSelector, ?string $expectedValue = null)
    {
        $crawler = self::$client->request('GET', $fixture);
        $element = $crawler->filter($elementCssSelector)->getElement(0);

        if ($element instanceof WebDriverElement) {
            $this->assertSame($expectedValue, $this->inspector->getValue($element));
        }
    }

    public function getValueDataProvider(): array
    {
        return [
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
            'input[type=radio] not checked' => [
                'fixture' => '/form.html',
                'elementCssSelector' => 'input[name="radio-not-checked"]',
                'expectedValue' => 'not-checked-1',
            ],
            'input[type=radio] checked' => [
                'fixture' => '/form.html',
                'elementCssSelector' => 'input[name="radio-checked"]',
                'expectedValue' => 'checked-1',
            ],
        ];
    }

    /**
     * @dataProvider getRadioGroupValueDataProvider
     */
    public function testGetRadioGroupValue(string $fixture, string $elementCssSelector, ?string $expectedValue = null)
    {
        $crawler = self::$client->request('GET', $fixture);
        $elements = $crawler->filter($elementCssSelector);
        $collectionElements = [];

        foreach ($elements as $element) {
            $collectionElements[] = $element;
        }

        $collection = new RadioButtonCollection($collectionElements);

        $this->assertSame($expectedValue, $this->inspector->getRadioGroupValue($collection));
    }

    public function getRadioGroupValueDataProvider(): array
    {
        return [
            'input[type=radio] not checked' => [
                'fixture' => '/form.html',
                'elementCssSelector' => 'input[name="radio-not-checked"]',
                'expectedValue' => null,
            ],
            'input[type=radio] checked' => [
                'fixture' => '/form.html',
                'elementCssSelector' => 'input[name="radio-checked"]',
                'expectedValue' => 'checked-2',
            ],
        ];
    }

    /**
     * @dataProvider getSelectOptionGroupValueDataProvider
     */
    public function testGetSelectOptionGroupValue(
        string $fixture,
        string $elementCssSelector,
        ?string $expectedValue = null
    ) {
        $crawler = self::$client->request('GET', $fixture);
        $elements = $crawler->filter($elementCssSelector);
        $collectionElements = [];

        foreach ($elements as $element) {
            $collectionElements[] = $element;
        }

        $collection = new SelectOptionCollection($collectionElements);

        $this->assertSame($expectedValue, $this->inspector->getSelectOptionGroupValue($collection));
    }

    public function getSelectOptionGroupValueDataProvider(): array
    {
        return [
            'select, none selected' => [
                'fixture' => '/form.html',
                'elementCssSelector' => 'select[name="select-none-selected"] option',
                'expectedValue' => 'none-selected-1',
            ],
            'select, has selected' => [
                'fixture' => '/form.html',
                'elementCssSelector' => 'select[name="select-has-selected"] option',
                'expectedValue' => 'has-selected-3',
            ],
        ];
    }
}
