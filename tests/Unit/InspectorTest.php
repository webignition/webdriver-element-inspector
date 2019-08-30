<?php
/** @noinspection PhpDocSignatureInspection */

namespace webignition\WebDriverElementInspector\Tests\Unit;

use Facebook\WebDriver\WebDriverElement;
use webignition\WebDriverElementInspector\Inspector;

class InspectorTest extends \PHPUnit\Framework\TestCase
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
    public function testGetValue(WebDriverElement $element, string $expectedValue)
    {
        $this->assertSame($expectedValue, $this->inspector->getValue($element));
    }

    public function getValueDataProvider(): array
    {
        $hasEmptyValueAttributeElement = \Mockery::mock(WebDriverElement::class);
        $hasEmptyValueAttributeElement
            ->shouldReceive('getAttribute')
            ->andReturn('');

        $hasNotEmptyValueAttributeElement = \Mockery::mock(WebDriverElement::class);
        $hasNotEmptyValueAttributeElement
            ->shouldReceive('getAttribute')
            ->andReturn('value content');


        return [
            'has empty value attribute' => [
                'element' => $hasEmptyValueAttributeElement,
                'expectedValue' => '',
            ],
            'has non-empty value attribute' => [
                'element' => $hasNotEmptyValueAttributeElement,
                'expectedValue' => 'value content',
            ],
        ];
    }
}
