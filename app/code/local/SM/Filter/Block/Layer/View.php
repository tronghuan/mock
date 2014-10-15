<?php 
/**
* 
*/
class SM_Filter_Block_Layer_View 
	extends Mage_Catalog_Block_Layer_View
{
	protected function _prepareLayout()
	{
	    $stateBlock = $this->getLayout()->createBlock($this->_stateBlockName)
	        ->setLayer($this->getLayer());

	    $categoryBlock = $this->getLayout()->createBlock($this->_categoryBlockName)
	        ->setLayer($this->getLayer())
	        ->init();

	    $this->setChild('layer_state', $stateBlock);
	    $this->setChild('category_filter', $categoryBlock);

	    $filterableAttributes = $this->_getFilterableAttributes();
	    foreach ($filterableAttributes as $attribute) {
	        if ($attribute->getAttributeCode() == 'price') {
	            $filterBlockName = $this->_priceFilterBlockName;
	        } elseif ($attribute->getBackendType() == 'decimal') {
	            $filterBlockName = $this->_decimalFilterBlockName;
	        } else {
	            $filterBlockName = $this->_attributeFilterBlockName;
	        }

	        $block = $this->getLayout()->createBlock($filterBlockName)
	                ->setLayer($this->getLayer())
	                ->setAttributeModel($attribute);
	                

	        /* My custom: Set template */
			$type = $attribute->getNavigationDisplay();
	        $block->setTemplate(
	        	SM_Filter_Model_Source_Navigation::getTemplateFile($type))
	        	->init();;

	        $this->setChild($attribute->getAttributeCode() . '_filter',
	            $block);
	    }

	    $this->getLayer()->apply();

	    return Mage_Core_Block_Template::_prepareLayout();
	}
}
