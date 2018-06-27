<?php

/**
 * Dropfin
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE_AFL.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade 
 * this extension to newer versions in the future. 
 *
 * @category    Dropfin
 * @package     Previous / Next Product
 * @copyright   Copyright (c) Dropfin (http://www.dropfin.com)
 */

class Dropfin_Previousnext_Helper_Data extends Mage_Core_Helper_Abstract {

    const XML_PATH_ENABLED = 'dropfin_previousnext/configurations/enabled';
    const XML_PATH_BUTTON_LOCATION = 'dropfin_previousnext/configurations/button_location';

    const XML_PATH_BUTTON_TYPE = 'dropfin_previousnext/button_setting/show_button_as';
    const XML_PATH_PREVIOUS_BUTTON = 'dropfin_previousnext/button_setting/pre_button_image';
    const XML_PATH_NEXT_BUTTON = 'dropfin_previousnext/button_setting/next_button_image';

    const XML_PATH_BACK_BUTTON_TYPE = 'dropfin_previousnext/back_button_setting/show_button_as';
    const XML_PATH_BACK_BUTTON = 'dropfin_previousnext/back_button_setting/pre_button_image';

    public function getStatus() {
    	return (int) Mage::getStoreConfig(self::XML_PATH_ENABLED);
    }

    public function isVisible($position) {
    	if(Mage::getStoreConfig(self::XML_PATH_BUTTON_LOCATION) == $position) {
    		return true;
    	}
    	return false;
    }

    public function getButtonType() {
    	return Mage::getStoreConfig(self::XML_PATH_BUTTON_TYPE);
    }

    public function getPreviousButton() {
        return Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).Mage::getStoreConfig(self::XML_PATH_PREVIOUS_BUTTON);
    }

    public function getNextButton() {
        return Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).Mage::getStoreConfig(self::XML_PATH_NEXT_BUTTON);
    }

    public function getBackButtonType() {
        return Mage::getStoreConfig(self::XML_PATH_BACK_BUTTON_TYPE);
    }

    public function getBackButton() {
        return Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).Mage::getStoreConfig(self::XML_PATH_BACK_BUTTON);
    }

    public function getCurrentProduct() {
    	if($productId = Mage::registry('current_product')->getId()) {
    		return $productId;
    	}
    	return false;
    }

    public function getCurrentCategory() {
        if($category = Mage::registry('current_category')){
            return $category;
        }
        return false;
    }

    public function getPreviousProduct() {

    	$productId = $this->getCurrentProduct();
        $category = $this->getCurrentCategory();
        if($productId && $category) {
            $category = $category->getProductsPosition();
            $keys = array_flip(array_keys($category));
            $values = array_keys($category);
            for ($i=1; $i <= $keys[$productId]; $i++) { 
                $_productId = $values[$keys[$productId]-$i];
                if($_productId){
                    $product = Mage::getModel('catalog/product')->load($_productId);
                    if($product->isVisibleInCatalog() && $product->isVisibleInSiteVisibility()) {
                        return $product;
                    }
                }
            }
        }
		return false;

    }

    public function getNextProduct() {

		$productId = $this->getCurrentProduct();
    	$category = $this->getCurrentCategory();
        if($productId && $category) {
            $category = $category->getProductsPosition();
            $keys = array_flip(array_keys($category));
            $values = array_keys($category);
            for ($i=($keys[$productId]+1); $i < count($values); $i++) { 
                $_productId = $values[$i];
                if($_productId){
                    $product = Mage::getModel('catalog/product')->load($_productId);
                    if($product->isVisibleInCatalog() && $product->isVisibleInSiteVisibility()) {
                        return $product;
                    }
                }
            }
        }
		return false;

	}
    
}
