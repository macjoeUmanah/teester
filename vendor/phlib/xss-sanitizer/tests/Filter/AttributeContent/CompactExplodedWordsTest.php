<?php

namespace Phlib\XssSanitizer\Test\Filter\AttributeContent;

use Phlib\XssSanitizer\Filter\AttributeContent\CompactExplodedWords;

/**
 * Class CompactExplodedWordsTest
 * @package Phlib\XssSanitizer\Test\Filter\AttributeContents
 */
class CompactExplodedWordsTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider filterDataProvider
     * @param string $original
     * @param string $expected
     */
    public function testFilter($original, $expected)
    {
        $actual = (new CompactExplodedWords())->filter($original);
        $this->assertEquals($expected, $actual);
    }

    public function filterDataProvider()
    {
        return [
            ['j a v a s c r i p t:alert(document.cookie);', 'javascript:alert(document.cookie);'],
            ['jav	ascript:alert(\'XSS\');', 'javascript:alert(\'XSS\');'],
            ['r e f r e s h', 'refresh'],

            // should not be affected
            ['javascriptor', 'javascriptor'],
        ];
    }

}
