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
 
class Adepta_DeliveryTime_Model_Observer
{
    public function saveDesiredDeliveryTime($observer)
    {
        $postData = $observer->getRequest()->getPost();
 
        if(isset($postData['delivery_date']))
        {
            $deliveryDate = (empty($postData['delivery_date'])) ? NULL : $postData['delivery_date'];
            $observer->getQuote()->getShippingAddress()->setDesiredDeliveryDate($deliveryDate); 
        }
    }
 
    public function copyDesiredDeliveryTimeToQuote($observer)
    {
        $observer->getQuote()->getShippingAddress()->setDesiredDeliveryDate($observer->getOrder()->getDesiredDeliveryDate());
    }

    public function updateOrderCreationQuoteWithDeliveryDate($observer)
    {
        $postData = $observer->getRequest();
     
        if(isset($postData['order']['desired_delivery_date']))
        {
            $deliveryDate = (empty($postData['order']['desired_delivery_date'])) ? NULL : $postData['order']['desired_delivery_date'];
            $deliveryDate = Mage::helper('adepta_deliverytime')->getDeliveryDateToStore($deliveryDate);
            $observer->getOrderCreateModel()->getQuote()->getShippingAddress()->setDesiredDeliveryDate($deliveryDate);
        }
    }
} 
