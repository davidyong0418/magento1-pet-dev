<?php
/**
 * Adepta Software Ltd
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 *
 * @copyright   Copyright (c) 2012 Adepta Software Ltd. (http://adeptasoftware.co.uk)
 * @license     http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */
?>
<?php
 
class Adepta_DeliveryTime_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getFormattedDeliveryDate($date, $format = Mage_Core_Model_Locale::FORMAT_TYPE_SHORT, $displayNullDateMsg = true)
    {
        $formattedDate = '';
     
        //Don't use the timezone adjustment - keep date as it is, last arg false.
        if($date != NULL)
        {
            $date = Mage::app()->getLocale()->date($date, Varien_Date::DATE_INTERNAL_FORMAT, NULL, false);
            $format = Mage::app()->getLocale()->getDateFormat($format);
            $formattedDate = $date->toString($format);
        }
        else if($displayNullDateMsg)
            $formattedDate = $this->__('Date Not Specified');
     
        return $formattedDate;
    }
    
    public function getDeliveryDateToStore($date, $format = Mage_Core_Model_Locale::FORMAT_TYPE_SHORT)
    {
        //Don't use the timezone adjustment - keep date as it is, last arg false.
        if($date != NULL)
        {
            try
            {
                $date = Mage::app()->getLocale()->date($date, Mage::app()->getLocale()->getDateFormat($format), NULL, false);
                $date = $date->toString(Varien_Date::DATE_INTERNAL_FORMAT); 
            }
            catch(Exception $e)
            {
                Mage::throwException($this->__('Invalid Delivery Date'));
            }
        }
     
        return $date;
    } 
}
