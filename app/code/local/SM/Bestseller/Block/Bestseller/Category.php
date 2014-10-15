<?php 
/**
* 
*/
class SM_Bestseller_Block_Bestseller_Category 
	extends SM_Bestseller_Block_Bestseller_Abstract
{
	protected static $config_path = "sm_bestseller/category_slider/";
	public function getBestsellerProducts()	
	{

		$store_id = (int) Mage::app()->getStore()->getId();

		// Date
		// $date = new Zend_Date();
		// Zend_Debug::dump($date->setDay(1)->get('Y-MM-dd'));die();
		// $toDate = $date->setDay(1)->get('Y-MM-dd');
		// $fromDate = $date->subMonth(1)->get('Y-MM-dd');

		// Collection product
		$collection = Mage::getResourceModel('catalog/product_collection')
			->addAttributeToSelect(Mage::getSingleton('catalog/config')->getProductAttributes())
			->addStoreFilter()
			->addPriceData()
			->addTaxPercents()
			->addUrlRewrite()
			->setPageSize($this->_getPageSize());
		// Join with category
		$category = Mage::registry('current_category');
		$collection
		    ->joinField('category_id',
		                'catalog/category_product',
		                'category_id',
		                'product_id=entity_id',
		                null,
		                'left')
		    ->addAttributeToFilter('category_id', array('in', $category->getAllChildren(true)));
		// join with bestseller table
		$collection->getSelect()
			->joinLeft(
				array('aggregation' => $collection->getResource()->getTable('sales/bestsellers_aggregated_monthly')),
					"e.entity_id = aggregation.product_id AND aggregation.store_id={$store_id}",
					array('SUM(aggregation.qty_ordered) AS sold_quantity')
				)
			->group('e.entity_id')
			->order(array('sold_quantity DESC', 'e.created_at'));

		Mage::getSingleton('catalog/product_status')
			->addVisibleFilterToCollection($collection);
		Mage::getSingleton('catalog/product_visibility')
			->addVisibleInCatalogFilterToCollection($collection);

		return $collection;
	}

}
