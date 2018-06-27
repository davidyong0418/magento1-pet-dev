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
 
class Adepta_DeliveryTime_Block_Adminhtml_Createorder_Deliverydate
    extends Mage_Adminhtml_Block_Sales_Order_Create_Abstract
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('sales_order_create_delivery_date_form');
    }
 
    public function getDisplayDate()
    {
        return Mage::helper('adepta_deliverytime')->getFormattedDeliveryDate($this->getCreateOrderModel()->getQuote()->getShippingAddress()->getDesiredDeliveryDate(), Mage_Core_Model_Locale::FORMAT_TYPE_SHORT, false);
    }
 
    public function getDateFormat()
    {
        return Mage::app()->getLocale()->getDateStrFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT);
    }
}
