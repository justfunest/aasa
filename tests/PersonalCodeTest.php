<?php

class PersonalCodeTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @dataProvider centuaryCheckCodesProvider
     */
    public function testCentuaryNumberInCode($code, $expected)
    {
        $rule = new \App\Validation\Rules\PersonalCode();
        $this->assertEquals($rule->validate($code), $expected);
    }

    /**
     * @dataProvider monthCheckCodesProvider
     */
    public function testMonthNumberInCode($code, $expected)
    {
        $rule = new \App\Validation\Rules\PersonalCode();
        $this->assertEquals($rule->validate($code), $expected);
    }

    private function invokePrivateMethod($methodName, array $args) {
        $rule = new \App\Validation\Rules\PersonalCode();
        $reflectionMethod = new \ReflectionMethod(get_class($rule), $methodName);
        $reflectionMethod->setAccessible(true);
        return $reflectionMethod->invokeArgs($rule, $args);
    }

    public function testGetChechSum()
    {
        foreach ($this->centuaryCheckCodesProvider() as $data) {
            $code = $data[0];
            $checkCode = $this->invokePrivateMethod('getCheckSum', [$code]);
            $this->assertEquals($checkCode, substr($code, -1));
        }
    }


    public function testGetReminderShouldThrowException()
    {
        $this->expectException(Exception::class);
        $this->invokePrivateMethod('getReminder', ['17605030297', '5435345345']);
    }


    public function centuaryCheckCodesProvider() {
        return [
            ["07605030296", false],
            ["17605030297", true],
            ["27605030298", true],
            ["37605030299", true],
            ["47605030295", true],
            ["57605030290", true],
            ["67605030291", true],
            ["77605030292", true],
            ["87605030293", true],
            ["97605030294", false]
        ];
    }

    public function monthCheckCodesProvider() {
        return [
            ["57601030292", true],
            ["57605030290", true],
            ["57611030296", true],
            ["57633030292", false],
            ["57676030290", false]
        ];
    }
}