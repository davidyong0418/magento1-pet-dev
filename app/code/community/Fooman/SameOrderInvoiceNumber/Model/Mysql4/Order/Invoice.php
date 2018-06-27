<?php

/**
 * Fooman Order = Invoice Number
 *
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * @category   Fooman
 * @package    SameOrderInvoiceNumber extending Magento Mage_Sales
 * @copyright  Copyright (c) 2009 Fooman Limited (http://www.fooman.co.nz)
 * @copyright  Copyright (c) 2008 Irubin Consulting Inc. DBA Varien (http://www.varien.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class Fooman_SameOrderInvoiceNumber_Model_Mysql4_Order_Invoice extends Mage_Sales_Model_Mysql4_Order_Invoice
{
    public function setNewIncrementId(Varien_Object $object)
    {
        if ($object->getIncrementId()) {
            return $this;
        }
        if(!empty($object)){
            $storeId = $object->getStore()->getId();
        }else{
            $storeId = Mage::getSingleton('checkout/session')->getStore()->getId();
        }
        $prefix = Mage::getStoreConfig('sameorderinvoicenumber/settings/invoiceprefix',$storeId);

        $incrementId = Mage::getModel('sales/order')->load($object->getOrderId())->getIncrementId();
        if (empty($incrementId)){
            $incrementId = (int)Mage::getSingleton('checkout/session')->getLastRealOrderId();
            if (!$incrementId==0){
                     $incrementId ++;
            }
        }

        //thanks to thaddeusmt for posting this idea
        //http://www.magentocommerce.com/boards/errors.php/viewthread/48251/
        if (empty($incrementId)) {
            $read = Mage::getSingleton('core/resource')->getConnection('core_read');

            $eav_entity_store = Mage::getSingleton('core/resource')->getTableName('eav_entity_store');
            $eav_entity_type = Mage::getSingleton('core/resource')->getTableName('eav_entity_type');

            $select = $read->select()
                ->from(array('s'=>$eav_entity_store), 'increment_last_id')
                ->joinInner(
                array('t' => $eav_entity_type),
                "s.entity_type_id = t.entity_type_id AND t.entity_type_code='order'",
                array()
            );
            $data = $read->fetchRow($select);
            $incrementId = $data['increment_last_id'];
        }

        if (!$incrementId){
            $incrementId = $this->getEntityType()->fetchNewIncrementId($object->getStoreId());
        }

        if (false!==$incrementId) {
            $object->setIncrementId($prefix."$incrementId");
        }

        return $this;

    }
}
