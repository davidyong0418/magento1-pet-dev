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
class Adepta_DeliveryTime_IndexController extends Mage_Core_Controller_Front_Action
{
    public function AjaxAction()
    {
        $shippingCode = $this->getRequest()->getPost('shipping_code');
 
        if(isset($shippingCode))
        {
            $dropdownBlock = $this->getLayout()->createBlock('adepta_deliverytime/onepage_deliverydate_dropdown');
            $dropdownBlock->setShippingCode($shippingCode);
            $content = $dropdownBlock->toHtml();
            $this->getResponse()->setBody(Mage::helper('core')->jsonEncode(array('dropdownhtml' => $content)));
        }
    }
}
