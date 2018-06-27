<?php
class AW_Sarp2_Block_Catalog_Product_List extends Mage_Catalog_Block_Product_List
{
    
    /**
     * Retrieve url for add product to cart
     * Will return product view page URL if product has required options
     *
     * @param Mage_Catalog_Model_Product $product
     * @param array $additional
     * @return string
     */
    public function getAddToCartUrl($product, $additional = array())
    {
        $subscription = Mage::getModel('aw_sarp2/subscription')->loadByProductId($product->getId());
        if (is_null($subscription->getId())) {
            return parent::getAddToCartUrl($product, $additional);
        }
        $additional = array_merge(
            $additional,
            array(Mage_Core_Model_Url::FORM_KEY => $this->_getSingletonModel('core/session')->getFormKey())
        );
        if (!isset($additional['_escape'])) {
            $additional['_escape'] = true;
        }
        if (!isset($additional['_query'])) {
            $additional['_query'] = array();
        }
        $additional['_query']['options'] = 'cart';
        $product->setUrl(false);
        return $this->getProductUrl($product, $additional);
    }

}
