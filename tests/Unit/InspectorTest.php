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
     * @dataProvider getElementValueDataProvider
     */
    public function testGetElementValue(WebDriverElement $element, string $expectedValue)
    {
        $this->assertSame($expectedValue, $this->inspector->getElementValue($element));
    }

    public function getElementValueDataProvider(): array
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

        $paragraph = \Mockery::mock(WebDriverElement::class);
        $paragraph
            ->shouldReceive('getTagName')
            ->andReturn('p');

        $paragraph
            ->shouldReceive('getText')
            ->andReturn('paragraph content');

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
            'paragraph' => [
                'element' => $paragraph,
                'expectedValue' => 'paragraph content',
            ],
        ];
    }
}
