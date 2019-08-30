<?php
/** @noinspection PhpDocSignatureInspection */

declare(strict_types=1);

namespace webignition\WebDriverElementInspector\Tests\Functional;

use Facebook\WebDriver\WebDriverElement;
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
        ];
    }
}
