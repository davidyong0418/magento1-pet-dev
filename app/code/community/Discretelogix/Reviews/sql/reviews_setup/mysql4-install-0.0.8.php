<?php
/**
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
 * @category    Discretelogix
 * @package     Discretelogix_Reviews
 * @copyright   Copyright (c) 2013 Discretelogix Pvt Ltd. (http://www.discretelogix.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
 
/*Change the Type of "created_at" field*/
$this->startSetup();
 
$this->run("ALTER TABLE `{$this->getTable('review')}` CHANGE `created_at` `created_at` DATETIME NOT NULL COMMENT 'Review create date'");
 
$this->endSetup();

?>