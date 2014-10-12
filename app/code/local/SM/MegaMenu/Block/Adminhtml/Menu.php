<?php
/**
 * Created by PhpStorm.
 * User: tronghuan
 * Date: 10/12/14
 * Time: 3:53 PM
 */
class SM_MegaMenu_Block_Adminhtml_Menu extends Mage_Adminhtml_Block_Widget_Grid_Container{
    public function __construct(){
        $this->_controller = 'adminhtml_menu';
        $this->_blockGroup = 'megamenu';
        $this->_headerText = Mage::helper('megamenu')->__('Menu Manager');
        parent::__construct();
        //$this->_removeButton('add');
    }
}