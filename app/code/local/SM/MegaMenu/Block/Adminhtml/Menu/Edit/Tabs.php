<?php
/**
 * Created by PhpStorm.
 * User: tronghuan
 * Date: 10/12/14
 * Time: 3:55 PM
 */
class SM_MegaMenu_Block_Adminhtml_Menu_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('menu_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('megamenu')->__('Menu Item'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab('form_section', array(
            'label'     => Mage::helper('megamenu')->__('Menu Item Information'),
            'title'     => Mage::helper('megamenu')->__('Menu Item Information'),
            'content'   => $this->getLayout()->createBlock('megamenu/adminhtml_menu_edit_tab_form')->toHtml(),
        ));

        return parent::_beforeToHtml();
    }
}
