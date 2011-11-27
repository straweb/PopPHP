<?php
/**
 * Pop PHP Framework
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
 * @category   Pop
 * @package    Pop_Session
 * @author     Nick Sagona, III <nick@moc10media.com>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * Pop_Session
 *
 * @category   Pop
 * @package    Pop_Session
 * @author     Nick Sagona, III <nick@moc10media.com>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9 beta
 */

class Pop_Session
{

    /**
     * Instance of the session
     * @var object
     */
    private static $_instance;

    /**
     * Session ID
     * @var string
     */
    private $_session_id = null;

    /**
     * Constructor
     *
     * Private method to instantiate the session object. As part of the
     * Singelton Pattern, it can only be called internally by the object itself.
     *
     * @return void
     */
    private function __construct()
    {
        // Start a session and set the session id.
        session_start();
        $this->_session_id = session_id();
    }

    /**
     * Determine whether or not an instance of the session object exists already,
     * and instantiate the object if it doesn't exist.
     *
     * @return Pop_Session
     */
    public static function getInstance()
    {
        if (empty(self::$_instance)) {
            self::$_instance = new Pop_Session();
        }

        return self::$_instance;
    }

    /**
     * Return the current the session id.
     *
     * @return string
     */
    public function getId()
    {
        return $this->_session_id;
    }

    /**
     * Regenerate the session id.
     *
     * @return void
     */
    public function regenerateId()
    {
        session_regenerate_id();
        $this->_session_id = session_id();
    }

    /**
     * Destroy the session.
     *
     * @return void
     */
    public function kill()
    {
        $_SESSION = null;
        session_unset();
        session_destroy();
        unset($this->_session_id);
    }

    /**
     * Set a property in the session object that is linked to the $_SESSION global variable.
     *
     * @param  string $name
     * @param  mixed $value
     * @return void
     */
    public function __set($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    /**
     * Get method to return the value of the $_SESSION global variable.
     *
     * @param  string $name
     * @return mixed
     */
    public function __get($name)
    {
        return (isset($_SESSION[$name])) ? $_SESSION[$name] : null;
    }

    /**
     * Return the isset value of the $_SESSION global variable.
     *
     * @param  string $name
     * @return boolean
     */
    public function __isset($name)
    {
        return isset($_SESSION[$name]);
    }

    /**
     * Unset the $_SESSION global variable.
     *
     * @param  string $name
     * @return void
     */
    public function __unset($name)
    {
        $_SESSION[$name] = null;
        unset($_SESSION[$name]);
    }

}