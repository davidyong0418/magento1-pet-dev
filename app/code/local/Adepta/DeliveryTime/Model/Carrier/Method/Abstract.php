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
 
abstract class Adepta_DeliveryTime_Model_Carrier_Method_Abstract 
{   
    protected $_startDaysOffset = 0;
    protected $_endDaysOffset = 0;
    
    abstract public function getCost();
    abstract public function getPrice();
    
    public function getDatesOptionArray()
    {
        $datesArray = array();
        $displayDate = Mage::getModel('core/locale')->storeDate();
        $displayDate->add($this->_startDaysOffset, Zend_Date::DAY);
        $dayOffset = $this->_startDaysOffset;
     
        do
        {
            $datesArray[$displayDate->toString(Varien_Date::DATE_INTERNAL_FORMAT)] = Mage::helper('core')->formatDate($displayDate,  Mage_Core_Model_Locale::FORMAT_TYPE_FULL);
            $displayDate->add('1', Zend_Date::DAY);
            $dayOffset++;
     
        } while ($dayOffset <= $this->_endDaysOffset);
     
        return $datesArray;
    }
} 
