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

namespace PopTest\File;

use Pop\Loader\Autoloader,
    Pop\File\File;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class FileTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $this->assertInstanceOf('Pop\\File\\File', new File('test.txt'));
    }

    public function testRead()
    {
        $f = new File(__DIR__ . '/../tmp/access.txt');
        $this->assertContains('12test34', $f->read());
        $this->assertEquals('stus', $f->read(2, 4));
    }

    public function testAllowedTypes()
    {
        $f = new File(__DIR__ . '/../tmp/access.txt', array('txt' => 'text/plain'));
        $this->assertFalse($f->isAllowed('php'));
        $this->assertTrue(is_array($f->getAllowedTypes()));
        $f->setAllowedTypes(array('txt' => 'text/plain', 'php' => 'text/plain'));
        $f->addAllowedTypes(array('sql' => 'text/plain'));
        $this->assertTrue($f->isAllowed('php'));
    }

    public function testSetAndGetMode()
    {
        $f = new File(__DIR__ . '/../tmp/access.txt');
        $this->assertEquals(777, $f->getMode());
        $f->setMode(0775);
        $this->assertEquals(775, $f->getMode());
        $f->setMode(0777);
        $this->assertEquals(777, $f->getMode(true));
        $f->setMode(0775, true);
        $this->assertEquals(775, $f->getMode(true));
        $f->setMode(0777, true);

    }

    public function testCopyAndMove()
    {
        $f = new File(__DIR__ . '/../tmp/access.txt');
        $f->copy(__DIR__ . '/../tmp/access2.txt');
        $this->fileExists(__DIR__ . '/../tmp/access2.txt');
        $f->move(__DIR__ . '/../tmp/access3.txt');
        $this->fileExists(__DIR__ . '/../tmp/access3.txt');
        unlink(__DIR__ . '/../tmp/access3.txt');
    }

    public function testReadNewFile()
    {
        $f = new File(__DIR__ . '/../tmp/file.txt');
        $f->write('123456');
        $this->assertEquals('345', $f->read(2, 3));
    }

    public function testWrite()
    {
        $f = new File(__DIR__ . '/../tmp/access.txt');
        $f->write('123456', true);
        $this->assertContains('123456', $f->read());
    }

    public function testOutput()
    {
        if (file_exists(__DIR__ . '/../tmp/file.txt')) {
            unlink(__DIR__ . '/../tmp/file.txt');
        }

        $f = new File(__DIR__ . '/../tmp/file.txt');
        $f->write('123');
        $this->setExpectedException('Pop\\Http\\Exception');
        $f->output();
    }

    public function testWriteSaveAndDelete()
    {
        if (file_exists(__DIR__ . '/../tmp/file.txt')) {
            unlink(__DIR__ . '/../tmp/file.txt');
        }

        $f = new File(__DIR__ . '/../tmp/file.txt');
        $f->write('123')
          ->write('456', true)
          ->save();
        $f->setMode(0777);

        $this->fileExists(__DIR__ . '/../tmp/file.txt');
        $this->assertEquals('123456', $f->read());
        $this->assertEquals(6, $f->getSize());
        $this->assertEquals('text/plain', $f->getMime());

        $f->delete();
        $this->assertFalse(file_exists(__DIR__ . '/../tmp/file.txt'));
    }

}

