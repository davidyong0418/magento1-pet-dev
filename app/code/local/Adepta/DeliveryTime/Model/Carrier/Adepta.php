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
class Adepta_DeliveryTime_Model_Carrier_Adepta extends Mage_Shipping_Model_Carrier_Abstract
implements Mage_Shipping_Model_Carrier_Interface {
 
    protected $_code = 'adeptacarrier';
 
    public function collectRates(Mage_Shipping_Model_Rate_Request $request)
    {
        if (!$this->getConfigFlag('active')) 
        {
            return false;
        }
 
        $result = Mage::getModel('shipping/rate_result');
 
        foreach($this->getAllowedMethods() as $methodName => $methodTitle)
        {
            $method = Mage::getModel('shipping/rate_result_method');
            $methodModel = Mage::getModel("adepta_deliverytime/carrier_method_{$methodName}");
            $method->setCarrier($this->_code);
            $method->setMethod($methodName);
            $method->setCarrierTitle($this->getConfigData('title'));
            $method->setMethodTitle($methodTitle);
            $method->setPrice($methodModel->getPrice());
            $method->setCost($methodModel->getCost());
            $result->append($method);
        }
 
        return $result;
    }
 
    public function getAllowedMethods()
    {
        $methods = array('express' => 'Express', 'standard' => 'Standard', 'budget' =>'Budget');  
        return $methods;
    }

    public function getMethodDeliveryDates($methodName)
    {
        $methodModel = Mage::getModel("adepta_deliverytime/carrier_method_{$methodName}");
        return $methodModel->getDatesOptionArray(); 
    }
}
