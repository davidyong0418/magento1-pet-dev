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
 
class Adepta_DeliveryTime_Model_Checkout_Onepage extends Mage_Checkout_Model_Type_Onepage
{
    public function saveBilling($data, $customerAddressId)
    {
        $desiredDeliveryDate = $this->getQuote()->getShippingAddress()->getDesiredDeliveryDate();
        $returnValue = parent::saveBilling($data, $customerAddressId);
        $this->getQuote()->getShippingAddress()->setDesiredDeliveryDate($desiredDeliveryDate)->save();
        return $returnValue;
    }
}
