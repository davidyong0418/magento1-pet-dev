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
class Adepta_DeliveryTime_Block_Onepage_Deliverydate_Dropdown extends Mage_Checkout_Block_Onepage_Abstract
{
    public function __construct()
    {
        $this->setTemplate('adepta_deliverytime/checkout/onepage/shipping_method/datedropdown.phtml');     
    }
 
    protected function _getCarrierMethodCode()
    {
        //Shipping code may have been set by ajax action
        //If it's not, use the saved one in the quote if available
        if(!$this->hasShippingCode())
            $this->setShippingCode($this->getQuote()->getShippingAddress()->getShippingMethod());
 
        if(trim($this->getShippingCode()) != '')
            $returnValue =  explode('_', $this->getShippingCode());
        else
            $returnValue = false;
 
        return $returnValue;
    }
 
    public function displayDeliveryDate()
    {
        $returnValue = false;
        $fullCode = $this->_getCarrierMethodCode();
 
        if(is_array($fullCode))
            $returnValue = Mage::getStoreConfigFlag('carriers/'.$fullCode[0].'/show_delivery_date');
 
        return $returnValue;
    }
 
    public function getDeliveryDateArrayOptions()
    {
        $returnValue = array();
        $fullCode = $this->_getCarrierMethodCode();
 
        if(is_array($fullCode))
        {
            $carrierModel = Mage::getSingleton('shipping/config')->getCarrierInstance($fullCode[0]);
            $returnValue = $carrierModel->getMethodDeliveryDates($fullCode[1]);
        }
 
        return $returnValue;
    }
 
    public function getSelectedDeliveryDate()
    {
        return $this->getQuote()->getShippingAddress()->getDesiredDeliveryDate();
    }
}
