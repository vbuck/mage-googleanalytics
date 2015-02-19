<?php

/**
 * Google Analytics mode source model.
 * 
 * PHP Version 5
 * 
 * @category  Class
 * @package   Vbuck_GoogleAnalytics
 * @author    Rick Buczynski <me@rickbuczynski.com>
 * @copyright 2015 Rick Buczynski. All Rights Reserved.
 */

/**
 * Class declaration
 *
 * @category Class_Type_Model
 * @package  Vbuck_GoogleAnalytics
 * @author   Rick Buczynski <me@rickbuczynski.com>
 */

class Vbuck_GoogleAnalytics_Model_System_Config_Source_Mode
{

    const MODE_CLASSICAL = 0;
    const MODE_UNIVERSAL = 1;

    /**
     * Get the analytics modes as an option array.
     * 
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array(
                'value' => self::MODE_CLASSICAL,
                'label' => Mage::helper('googleanalytics')->__('Classical Analytics'),
            ),
            array(
                'value' => self::MODE_UNIVERSAL,
                'label' => Mage::helper('googleanalytics')->__('Universal Analytics'),
            ),
        );
    }

}