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
 * @package    Pop_Data
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * @namespace
 */
namespace Pop\Data\Type;

/**
 * This is the Xml class for the Data component.
 *
 * @category   Pop
 * @package    Pop_Data
 * @author     Nick Sagona, III <nick@popphp.org>
 * @copyright  Copyright (c) 2009-2013 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    1.2.0
 */
class Xml
{

    /**
     * Decode the data into PHP.
     *
     * @param  string  $data
     * @param  boolean $preserve
     * @return mixed
     */
    public static function decode($data, $preserve = false)
    {
        $nodes = array();

        if ($preserve) {
            $matches = array();
            preg_match_all('/<!\[cdata\[(.*?)\]\]>/is', $data, $matches);

            foreach ($matches[0] as $match) {
                $strip = str_replace(
                    array('<![CDATA[', ']]>', '<', '>'),
                    array('', '', '&lt;', '&gt;'),
                    $match
                );
                $data = str_replace($match, $strip, $data);
            }

            $nodes = json_decode(json_encode((array) simplexml_load_string($data)), true);
        } else {
            $xml = new \SimpleXMLElement($data);
            $i = 1;

            foreach ($xml as $key => $node) {
                $objs = array();
                foreach ($node as $k => $v) {
                    $j = 1;
                    if (array_key_exists((string)$k, $objs)) {
                        while (array_key_exists($k . '_' . $j, $objs)) {
                            $j++;
                        }
                        $newKey = (string)$k . '_' . $j;
                    } else {
                        $newKey = (string)$k;
                    }
                    $objs[$newKey] = trim((string)$v);
                }
                $nodes[$key . '_' . $i] = $objs;
                $i++;
            }
        }

        return $nodes;
    }

    /**
     * Encode the data into its native format.
     *
     * @param  mixed   $data
     * @param  string  $table
     * @param  boolean $pma
     * @return string
     */
    public static function encode($data, $table = null, $pma = false)
    {
        $xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?" . ">\n<data>\n";

        if ($pma) {
            foreach($data as $key => $ary) {
                $table = (null === $table) ? substr($key, 0, strrpos($key, '_')) : $table;
                $xml .= "    <table name=\"" . $table . "\">\n";
                foreach ($ary as $k => $v) {
                    $xml .= "        <column name=\"" . $k . "\">" . $v . "</column>\n";
                }
                $xml .= "    </table>\n";
            }
        } else {
            foreach($data as $key => $ary) {
                $table = (null === $table) ? substr($key, 0, strrpos($key, '_')) : $table;
                if (empty($table)) {
                    $table = 'row';
                }
                $xml .= "    <" . $table . ">\n";
                foreach ($ary as $k => $v) {
                    $xml .= "        <" . $k . ">" . $v . "</" . $k . ">\n";

                }
                $xml .= "    </" . $table . ">\n";
            }
        }

        $xml .= "</data>\n";

        return $xml;
    }

}