<?php

namespace SsMailer\Tests\Json;

use PHPUnit\Framework\TestCase;
use SsMailer\Json\NativeCoder;
use stdClass;
use JsonSerializable;

class NativeCoderTest extends TestCase
{
    protected function setUp(): void
    {
        $this->coder = new NativeCoder();
    }

    public function provideDecodeData(): array
    {
        $data = [];
        $data[] = ['""', ''];
        $data[] = ['[]', []];
        $data[] = ['{}', new stdClass()];
        $data[] = ['true', true];
        $data[] = ['false', false];
        $data[] = ['[{}]', [new stdClass]];
        $data[] = ['[{},{},1,"foo"]', [new stdClass, new stdClass,1,'foo']];

        $abc= new stdClass();
        $abc->abc = [];
        $data[] = ['{"abc":[]}', $abc];

        $objectWithProperty = new stdClass();
        $objectWithProperty->status = [1,2,3,'d',new stdClass];
        $data[] = ['{"status":[1,2,3,"d",{}]}', $objectWithProperty];

        return $data;
    }

    /**
     * @dataProvider provideDecodeData
     */
    public function testDecode($testInput, $expectedOutput): void
    {
        $output = $this->coder->decode($testInput);
        $this->assertEquals($expectedOutput, $output);
    }

    public function provideDecodePrettyData(): array
    {
        $data = [];
        $data[] = ['[
        ]', []];
        $data[] = ['{  }', new stdClass()];
        $data[] = ['[ {
            }
        ]', [new stdClass]];
        $data[] = ['[{},{ } , 1 ,
            "foo"]', [new stdClass, new stdClass,1,'foo']];

        $abc= new stdClass();
        $abc->abc = [];
        $data[] = ['{
            "abc": []
        }', $abc];

        $objectWithProperty = new stdClass();
        $objectWithProperty->status = [1,2,3,'d',new stdClass];
        $data[] = ['{"status": [1, 2 , 3, "d",{}]}', $objectWithProperty];

        return $data;
    }


    /**
     * @dataProvider provideDecodePrettyData
     */
    public function testDecodePretty($testInput, $expectedOutput): void
    {
        $output = $this->coder->decode($testInput);
        $this->assertEquals($expectedOutput, $output);
    }

    public function provideEncodeData(): array
    {
        $decodeData = $this->provideDecodeData();
        $data = [];
        foreach ($decodeData as $item) {
            $data[] = [$item[1], $item[0]];
        }
        return $data;
    }

    /**
     * @dataProvider provideEncodeData
     */
    public function testEncode($testInput, $expectedOutput): void
    {
        $output = $this->coder->encode($testInput);
        $this->assertSame($expectedOutput, $output);
    }

    /**
     * @dataProvider provideEncodeData
     */
    public function testEncodeJsonSerializable($testInput, $expectedOutput): void
    {
        $mock = $this->createMock(JsonSerializable::class);
        $mock->method('jsonSerialize')
            ->willReturn($testInput);
        $mock->expects($this->once())
            ->method('jsonSerialize');

        $output = $this->coder->encode($mock);
        $this->assertSame($expectedOutput, $output);
    }
}
