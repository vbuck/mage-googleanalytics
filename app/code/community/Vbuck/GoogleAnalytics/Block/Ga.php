<?php

/**
 * Google Analytics tracking code block extensions.
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
 * @category Class_Type_Block
 * @package  Vbuck_GoogleAnalytics
 * @author   Rick Buczynski <me@rickbuczynski.com>
 */

class Vbuck_GoogleAnalytics_Block_Ga 
    extends Mage_GoogleAnalytics_Block_Ga
{

    /**
    * Prepare the block templates based on analytics mode.
    *
    * @return string
    */
    protected function _toHtml()
    {
        // Support for Universal Analytics
        if (Mage::getStoreConfig('google/analytics/mode') == Vbuck_GoogleAnalytics_Model_System_Config_Source_Mode::MODE_UNIVERSAL) {
            $this->setTemplate('googleanalytics/ga/universal.phtml');
        } else { // Fallback to Classical Analytics
            $this->setTemplate('googleanalytics/ga/classic.phtml');
        }

        $this->addOrderTrackingBlock();
        $this->addCustomTrackingBlock();

        // Parent will check if GA is enabled in system before rendering
        return parent::_toHtml();
    }

    /**
     * Add a custom tracking block for convenient extensions.
     *
     * @return Vbuck_GoogleAnalytics_Block_Ga
     */
    public function addCustomTrackingBlock()
    {
        $block = $this->getLayout()
            ->createBlock('core/text_list');

        $this->setChild('custom_tracking', $block);

        Mage::dispatchEvent('google_analytics_custom_tracking', array('block' => $block));

        return $this;
    }

    /**
     * Append the order tracking block.
     * 
     * @return Vbuck_GoogleAnalytics_Block_Ga
     */
    public function addOrderTrackingBlock()
    {
        $orderIds = $this->getOrderIds();

        if ( empty($orderIds) || !is_array($orderIds) ) {
            return;
        }

        $collection = Mage::getResourceModel('sales/order_collection')
            ->addFieldToFilter('entity_id', array('in' => $orderIds));

        $block = $this->getLayout()
                ->createBlock('core/template')
                ->setOrders($collection);

        // Support for Universal Analytics
        if (Mage::getStoreConfig('google/analytics/mode') == Vbuck_GoogleAnalytics_Model_System_Config_Source_Mode::MODE_UNIVERSAL) {
            $block->setTemplate('googleanalytics/ga/universal/order.phtml');
        } else { // Fallback to Classical Analytics
            $block->setTemplate('googleanalytics/ga/classic/order.phtml');
        }

        $this->setChild('order_tracking', $block);
    }

    /**
     * Determine whether the IP should be anonymized while tracking.
     * 
     * @return boolean
     */
    public function isAnonymizedIp()
    {
        return Mage::getStoreConfigFlag('google/analytics/anonymization');
    }

    /**
     * Get the Google Analytics account ID.
     * 
     * @return string
     */
    public function getAccount()
    {
        return Mage::getStoreConfig(Mage_GoogleAnalytics_Helper_Data::XML_PATH_ACCOUNT);
    }

    /**
     * Get the user-defined cookie domain if available.
     * 
     * @return string
     */
    public function getCookieDomain()
    {
        return Mage::getStoreConfig('google/analytics/use_domain');
    }

    /**
     * Get the Google Checkout JS library URL. Carried over from CE 1.4, but does not appear to be used in CE 1.9.
     * 
     * @return string
     */
    public function getGoogleCheckoutCodeUrl()
    {
        return (Mage::app()->getCurrentStore()->isCurrentlySecure() ? 'https' : 'https') .
            '//checkout.google.com/files/digital/ga_post.js';
    }

}