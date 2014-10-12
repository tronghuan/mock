<?php
/**
 * Created by PhpStorm.
 * User: tronghuan
 * Date: 10/12/14
 * Time: 3:54 PM
 */
class SM_MegaMenu_Block_Adminhtml_Menu_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'megamenu';
        $this->_controller = 'adminhtml_menu';

        $this->_updateButton('save', 'label', Mage::helper('megamenu')->__('Save Menu Item'));
        $this->_updateButton('delete', 'label', Mage::helper('megamenu')->__('Delete Menu Item'));

        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('menu_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'menu_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'menu_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('menu_data') && Mage::registry('menu_data')->getId() ) {
            return Mage::helper('megamenu')->__("Edit Menu Item '%s'", $this->htmlEscape(Mage::registry('menu_data')->getTitle()));
        } else {
            return Mage::helper('megamenu')->__('Add Menu Item');
        }
    }
}