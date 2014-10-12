<?php
/**
 * Created by PhpStorm.
 * User: tronghuan
 * Date: 10/12/14
 * Time: 3:51 PM
 */
class SM_MegaMenu_Model_Source_Cms_Block
{
    protected $_options;

    public function getAllBlock()
    {
        if(!$this->_options){
            $this->_options = Mage::getResourceModel('cms/block_collection')
            ;
        }
        $option = array();
        foreach($this->_options as $value){
            $option[]=array(
                'value' => $value->getIdentifier(),
                'label' =>  $value->getTitle(),
            );
        }

        return $option;
    }
}