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
 
class Adepta_DeliveryTime_Model_Carrier_Method_Express extends 
Adepta_DeliveryTime_Model_Carrier_Method_Abstract 
{
    protected $_startDaysOffset = 1;
    protected $_endDaysOffset = 10;
    
    public function getCost()
    {
        return 5.00;
    }
 
    public function getPrice()
    {
        return 10.00;
    }
}
