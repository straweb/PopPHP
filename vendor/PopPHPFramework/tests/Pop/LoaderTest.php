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

namespace Pop;

use Pop\Loader\Autoloader,
    Pop\Loader\Classmap,
    Pop\Filter\String;

// Require the library's autoloader.
require_once __DIR__ . '/../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class LoaderTest extends \PHPUnit_Framework_TestCase
{

    public function testAutoloader()
    {
        $s = new String('string');
        $class = 'Pop\\Filter\\String';
        $this->assertTrue($s instanceof $class);
    }

    public function testClassmap()
    {
        $classmap = __DIR__ . '/data/classmap.php';

        if (file_exists($classmap)) {
            unlink($classmap);
        }

        Classmap::generate(__DIR__ . '/../../src', $classmap);
        $this->fileExists($classmap);

        unlink($classmap);
    }

}

?>