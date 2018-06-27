<?php

/**
 * Dropfin
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE_AFL.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade 
 * this extension to newer versions in the future. 
 *
 * @category    Dropfin
 * @package     Previous / Next Product
 * @copyright   Copyright (c) Dropfin (http://www.dropfin.com)
 */

class Dropfin_Previousnext_Model_Showbackbuttonas
{

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value' => 1, 'label' => Mage::helper('adminhtml')->__('Button Only')),
            array('value' => 2, 'label' => Mage::helper('adminhtml')->__('Button + Category Name')),
            array('value' => 3, 'label' => Mage::helper('adminhtml')->__('Button + Category Name + Thumb Image'))
        );
    }

    /**
     * Get options in "key-value" format
     *
     * @return array
     */
    public function toArray()
    {
        return array(
            1 => Mage::helper('adminhtml')->__('Button Only'),
            2 => Mage::helper('adminhtml')->__('Button + Category Name'),
            3 => Mage::helper('adminhtml')->__('Button + Category Name + Thumb Image')
        );
    }

}
