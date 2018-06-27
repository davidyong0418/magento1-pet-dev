<?php
class Olegnax_Athlete_Block_Product_List_Featured extends Mage_Catalog_Block_Product_List
{
	protected $_productsCount = null;
	protected $_blockTitle = null;

	const DEFAULT_PRODUCTS_COUNT = 6;

	/**
	 * Retrieve loaded category collection
	 *
	 * @return Mage_Eav_Model_Entity_Collection_Abstract
	 */
	protected function _getProductCollection()
	{
		if (is_null($this->_productCollection)) {
			$layer = $this->getLayer();
			/* @var $layer Mage_Catalog_Model_Layer */
			if ($this->getShowRootCategory()) {
				$this->setCategoryId(Mage::app()->getStore()->getRootCategoryId());
			}

			$origCategory = null;
			if ($this->getCategoryId()) {
				$category = Mage::getModel('catalog/category')->load($this->getCategoryId());
				if ($category->getId()) {
					$origCategory = $layer->getCurrentCategory();
					$layer->setCurrentCategory($category);
				}
			}
			$this->_productCollection = $layer->getProductCollection();

			$this->prepareSortableFieldsByCategory($layer->getCurrentCategory());

			if ($origCategory) {
				$layer->setCurrentCategory($origCategory);
			}
		}

		return $this->_productCollection;
	}

	/**
	 * apply parameters from cms block
	 *
	 * Available options
	 * category_id
	 * products_count
	 * block_title
	 * block_title_size
	 * product_columns
	 * is_random
	 */
	protected function _beforeToHtml()
	{
		$collection = $this->_getProductCollection();

		$isRandom = $this->getIsRandom();
		if ($isRandom)
			$collection->getSelect()->order('rand()');

		$collection->setPage(1, $this->getProductsCount())
			->load();

		$this->setCollection($collection);

		return parent::_beforeToHtml();
	}

	/**
	 * Get block title
	 *
	 * @return string
	 */
	public function getBlockTitle()
	{
		$this->_blockTitle = $this->getData('block_title');
		if (empty($this->_blockTitle)) {
			$this->_blockTitle = '';
		}
		return $this->_blockTitle;
	}

	/**
	 * Get number of products to be displayed
	 *
	 * @return int
	 */
	public function getProductsCount()
	{
		$this->_productsCount = $this->getData('products_count');
		if (empty($this->_productsCount)) {
			$this->_productsCount = self::DEFAULT_PRODUCTS_COUNT;
		}
		return $this->_productsCount;
	}

}
