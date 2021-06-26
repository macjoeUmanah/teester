<?php

namespace Phlib\XssSanitizer\Test\Filter\AttributeContent;

use Phlib\XssSanitizer\Filter\AttributeContent\DecodeUtf8;

/**
 * Class DecodeUtf8Test
 * @package Phlib\XssSanitizer\Test\Filter\AttributeContents
 */
class DecodeUtf8Test extends \PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider decodeDataProvider
     * @param string $original
     * @param string $expected
     */
    public function testDecode($original, $expected)
    {
        $actual = (new DecodeUtf8())->filter($original);
        $this->assertEquals($expected, $actual);
    }

    public function decodeDataProvider()
    {
        return [
            ['xx \u006a xx', 'xx j xx'],
            ['xx \u0061 xx', 'xx a xx'],
            ['xx \u0076 xx', 'xx v xx'],
            ['xx \u0073 xx', 'xx s xx'],
            ['xx \u003A xx', 'xx : xx'],
        ];
    }

}
