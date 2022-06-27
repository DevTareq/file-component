<?php

namespace Test\Unit;

use App\Rules\DecimalRule;
use Illuminate\Contracts\Validation\Rule;
use Mockery\Adapter\Phpunit\MockeryTestCase;

class DecimalRuleTest extends MockeryTestCase
{
    protected Rule $rule;

    protected function setUp(): void
    {
        $this->rule = new DecimalRule(8, 3);
    }

    /**
     * @dataProvider getDecimalTestCases
     */
    public function testDecimalPointHasValidFormat($input, $expected): void
    {
        $this->assertEquals($expected, $this->rule->passes('', $input));
    }

    /**
     * @return \bool[][]
     */
   public function getDecimalTestCases(): array
    {
        return [
            'Should pass default case (xx.yy)' => [10.23, true],
            'Should pass digits length (xxx.yy)' => [100.23, true],
            'Should not pass negative digits (-xx.yy)' => [-00.23, false],
            'Should pass length of scale (xx.yyy)' => [11.123, true],
            'Should not pass exceeded length of scale (xx.yyyy)' => [11.1201, false],
            'Should not pass minimum length of digits (x.yyy)' => [1.121, true],
            'Should pass maximum number of scale digits (xxxxxxxx.yyy)' => [12345678.101, true],
            'Should not pass exceeded number of scale digits (xxxxxxxxx.yyy)' => [123456789.101, false],
            'Should pass integer value' => [0, true],
            'Should pass string value' => ['11.344', true],
        ];
    }
}
