<?php
/* @var $this Mage_Core_Model_Resource_Setup */
$this->startSetup();

$this->removeAttribute('catalog_category', 'olegnaxmegamenu_type');
$this->removeAttribute('catalog_category', 'olegnaxmegamenu_layout');
$this->removeAttribute('catalog_category', 'olegnaxmegamenu_menu');
$this->removeAttribute('catalog_category', 'olegnaxmegamenu_top');
$this->removeAttribute('catalog_category', 'olegnaxmegamenu_bottom');
$this->removeAttribute('catalog_category', 'olegnaxmegamenu_right');
$this->removeAttribute('catalog_category', 'olegnaxmegamenu_right_percent');

$this->addAttribute('catalog_category', 'olegnaxmegamenu_type', array(
	'group' => 'Olegnax Megamenu',
	'type' => 'varchar',
	'input' => 'select',
	'source' => 'olegnaxmegamenu/category_attribute_source_type',
	'label' => 'Dropdown type',
	'note' => "For top-level categories only",
	'backend' => '',
	'visible' => true,
	'required' => false,
	'visible_on_front' => true,
	'wysiwyg_enabled' => true,
	'is_html_allowed_on_front'	=> true,
	'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
));

$this->addAttribute('catalog_category', 'olegnaxmegamenu_layout', array(
	'group' => 'Olegnax Megamenu',
	'type' => 'varchar',
	'input' => 'select',
	'source' => 'olegnaxmegamenu/category_attribute_source_layout',
	'label' => 'Dropdown Layout',
	'backend' => '',
	'visible' => true,
	'required' => false,
	'visible_on_front' => true,
	'wysiwyg_enabled' => true,
	'is_html_allowed_on_front'	=> true,
	'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
));

$this->addAttribute('catalog_category', 'olegnaxmegamenu_menu', array(
	'group' => 'Olegnax Megamenu',
	'type' => 'int',
	'input' => 'select',
	'source' => 'olegnaxmegamenu/category_attribute_source_yesno',
	'label' => 'Show subcategories',
	'note' => "Show/hide subcategories list",
	'backend' => '',
	'visible' => true,
	'required' => false,
	'visible_on_front' => true,
	'wysiwyg_enabled' => true,
	'is_html_allowed_on_front'	=> true,
	'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
));

$this->addAttribute('catalog_category', 'olegnaxmegamenu_top', array(
	'group' => 'Olegnax Megamenu',
	'input' => 'textarea',
	'type' => 'text',
	'label' => 'Top block',
	'note' => "For top-level categories only",
	'backend' => '',
	'visible' => true,
	'required' => false,
	'visible_on_front' => true,
	'wysiwyg_enabled' => true,
	'is_html_allowed_on_front'	=> true,
	'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
));

$this->addAttribute('catalog_category', 'olegnaxmegamenu_bottom', array(
	'group' => 'Olegnax Megamenu',
	'input' => 'textarea',
	'type' => 'text',
	'label' => 'Bottom block',
	'note' => "For top-level categories only",
	'backend' => '',
	'visible' => true,
	'required' => false,
	'visible_on_front' => true,
	'wysiwyg_enabled' => true,
	'is_html_allowed_on_front'	=> true,
	'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
));

$this->addAttribute('catalog_category', 'olegnaxmegamenu_right', array(
	'group' => 'Olegnax Megamenu',
	'input' => 'textarea',
	'type' => 'text',
	'label' => 'Right block',
	'note' => "For top-level categories only",
	'backend' => '',
	'visible' => true,
	'required' => false,
	'visible_on_front' => true,
	'wysiwyg_enabled' => true,
	'is_html_allowed_on_front'	=> true,
	'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
));

$this->addAttribute('catalog_category', 'olegnaxmegamenu_right_percent', array(
	'group' => 'Olegnax Megamenu',
	'type' => 'varchar',
	'input' => 'select',
	'source' => 'olegnaxmegamenu/category_attribute_source_percent',
	'label' => 'Right block width',
	'note' => "Width of right block in percents",
	'backend' => '',
	'visible' => true,
	'required' => false,
	'visible_on_front' => true,
	'wysiwyg_enabled' => true,
	'is_html_allowed_on_front'	=> true,
	'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
));

$this->endSetup();