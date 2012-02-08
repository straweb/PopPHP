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

namespace PopTest\Auth;

use Pop\Loader\Autoloader,
    Pop\Auth\Role;

// Require the library's autoloader.
require_once __DIR__ . '/../../../src/Pop/Loader/Autoloader.php';

// Call the autoloader's bootstrap function.
Autoloader::factory()->splAutoloadRegister();

class RoleTest extends \PHPUnit_Framework_TestCase
{

    public function testFactory()
    {
        $r = Role::factory('editor', 5);
        $class = 'Pop\\Auth\\Role';
        $this->assertTrue($r instanceof $class);
    }

    public function testCompare()
    {
        $e = Role::factory('editor', 5);
        $r = Role::factory('reader', 1);
        $this->assertGreaterThan(0, $e->compare($r));
    }

    public function testGetLevel()
    {
        $e = Role::factory('editor', 5);
        $this->assertEquals(5, $e->getLevel());
    }

    public function testGetName()
    {
        $e = Role::factory('editor', 5);
        $this->assertEquals('editor', $e->getName());
    }

}

?>