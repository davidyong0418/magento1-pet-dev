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
 
class Adepta_DeliveryTime_Block_Onepage_Progress extends Mage_Checkout_Block_Onepage_Progress
{
    public function displayDeliveryDate()
    {
        $displayDate = false;
 
        if($this->getQuote()->getShippingAddress()->getDesiredDeliveryDate() != NULL)
            $displayDate = true;
 
        return $displayDate;
    }
 
    public function getDisplayDeliveryDate()
    {
        return Mage::helper('adepta_deliverytime')->getFormattedDeliveryDate($this->getQuote()->getShippingAddress()->getDesiredDeliveryDate(), Mage_Core_Model_Locale::FORMAT_TYPE_FULL);
    }
}
