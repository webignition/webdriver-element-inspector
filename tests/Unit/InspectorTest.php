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
        $emptyInput = \Mockery::mock(WebDriverElement::class);
        $emptyInput
            ->shouldReceive('getTagName')
            ->andReturn(Inspector::INPUT_ELEMENT_TAG_NAME);

        $emptyInput
            ->shouldReceive('getAttribute')
            ->andReturn('');

        $input = \Mockery::mock(WebDriverElement::class);
        $input
            ->shouldReceive('getTagName')
            ->andReturn(Inspector::INPUT_ELEMENT_TAG_NAME);

        $input
            ->shouldReceive('getAttribute')
            ->andReturn('value content');

        $emptyTextarea = \Mockery::mock(WebDriverElement::class);
        $emptyTextarea
            ->shouldReceive('getTagName')
            ->andReturn('textarea');

        $emptyTextarea
            ->shouldReceive('getText')
            ->andReturn('');

        $textarea = \Mockery::mock(WebDriverElement::class);
        $textarea
            ->shouldReceive('getTagName')
            ->andReturn('textarea');

        $textarea
            ->shouldReceive('getText')
            ->andReturn('textarea content');

        return [
            'empty input' => [
                'element' => $emptyInput,
                'expectedValue' => '',
            ],
            'input' => [
                'element' => $input,
                'expectedValue' => 'value content',
            ],
            'empty textarea' => [
                'element' => $emptyTextarea,
                'expectedValue' => '',
            ],
            'textarea' => [
                'element' => $textarea,
                'expectedValue' => 'textarea content',
            ],
        ];
    }
}
