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
 * @package    Pop_Font
 * @author     Nick Sagona, III <nick@moc10media.com>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 */

/**
 * Pop_Font_TrueType_Table_Cmap
 *
 * @category   Pop
 * @package    Pop_Font
 * @author     Nick Sagona, III <nick@moc10media.com>
 * @copyright  Copyright (c) 2009-2012 Moc 10 Media, LLC. (http://www.moc10media.com)
 * @license    http://www.popphp.org/LICENSE.TXT     New BSD License
 * @version    0.9 beta
 */

class Pop_Font_TrueType_Table_Cmap
{

    /**
     * Cmap header
     * @var ArrayObject
     */
    public $header = null;

    /**
     * Cmap subtables
     * @var ArrayObject
     */
    public $subTables = array();

    /**
     * Constructor
     *
     * Instantiate a TTF 'cmap table object.
     *
     * @param  Pop_Font $font
     * @return void
     */
    public function __construct($font)
    {
        $bytePos = $font->tableInfo['cmap']->offset;

        // Get the CMAP header data.
        $cmapTableHeader = unpack('ntableVersion/' .
                                  'nnumberOfTables', $font->read($bytePos, 4));

        $this->header = new ArrayObject($cmapTableHeader, ArrayObject::ARRAY_AS_PROPS);
        $this->_parseSubTables($font);
    }

    /**
     * Method to parse the CMAP subtables.
     *
     * @return void
     */
    protected function _parseSubTables($font)
    {
        $bytePos = $font->tableInfo['cmap']->offset + 4;

        // Get each of the subtable's data.
        for ($i = 0; $i < $this->header->numberOfTables; $i++) {
            $ary = unpack('nplatformId/' .
                          'nencodingId/' .
                          'Noffset', $font->read($bytePos, 8));
            if (($ary['platformId'] == 0) && ($ary['encodingId'] == 0)) {
                $ary['encoding'] = 'Unicode 2.0';
            } else if (($ary['platformId'] == 0) && ($ary['encodingId'] == 3)) {
                $ary['encoding'] = 'Unicode';
            } else if (($ary['platformId'] == 3) && ($ary['encodingId'] == 1)) {
                $ary['encoding'] = 'Microsoft Unicode';
            } else if (($ary['platformId'] == 1) && ($ary['encodingId'] == 0)) {
                $ary['encoding'] = 'Mac Roman';
            } else {
                $ary['encoding'] = 'Unknown';
            }
            $this->subTables[] = new ArrayObject($ary, ArrayObject::ARRAY_AS_PROPS);
            $bytePos += 8;
        }

        // Parse each of the subtable's data.
        foreach ($this->subTables as $key => $subTable) {
            $bytePos = $font->tableInfo['cmap']->offset + $subTable->offset;
            $ary = unpack('nformat/' .
                          'nlength/' .
                          'nlanguage', $font->read($bytePos, 6));
            $this->subTables[$key]->format = $ary['format'];
            $this->subTables[$key]->length = $ary['length'];
            $this->subTables[$key]->language = $ary['language'];
            $bytePos += 6;
            $this->subTables[$key]->data = $font->read($bytePos, $ary['length'] - 6);
            switch ($this->subTables[$key]->format) {
                case 0:
                    $this->subTables[$key]->parsed = Pop_Font_TrueType_Table_Cmap_ByteEncoding::parseData($this->subTables[$key]->data);
                    break;
                case 4:
                    $this->subTables[$key]->parsed = Pop_Font_TrueType_Table_Cmap_SegmentToDelta::parseData($this->subTables[$key]->data);
                    break;
                case 6:
                    $this->subTables[$key]->parsed = Pop_Font_TrueType_Table_Cmap_TrimmedTable::parseData($this->subTables[$key]->data);
                    break;
            }
        }
    }

}