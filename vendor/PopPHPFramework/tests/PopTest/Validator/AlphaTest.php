<?php
/**
 * Pop PHP Framework Unit Tests
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.TXT.
 * It is also available through the world-wide-web at this URL:
 * http://www.popphp.org/LICENSE.TXT
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to info@popphp.org so we can send you a copy immediately.
 *
 */

namespace PopTest\Validator;

use Pop\Loader\Autoloader,
    Pop\Validator\Validator\Alpha;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class AlphaTest extends \PHPUnit_Framework_TestCase
{

    public function testSetAndGetCondition()
    {
        $v = new Alpha();
        $v->setCondition(true);
        $this->assertTrue($v->getCondition());
    }

    public function testSetAndGetInput()
    {
        $v = new Alpha();
        $v->setInput('123');
        $this->assertEquals('123', $v->getInput());
    }

    public function testSetAndGetValue()
    {
        $v = new Alpha();
        $v->setValue('123');
        $this->assertEquals('123', $v->getValue());
    }

    public function testEvaluateTrue()
    {
        $v = new Alpha();
        $this->assertTrue($v->evaluate('abcdef'));
        $this->assertFalse($v->evaluate('123456'));
    }

    public function testEvaluateFalse()
    {
        $v = new Alpha(null, false);
        $this->assertFalse($v->evaluate('abcdef'));
        $this->assertTrue($v->evaluate('123456'));
    }

}

