<?php
/**
 * Created by PhpStorm.
 * User: tronghuan
 * Date: 10/12/14
 * Time: 3:56 PM
 */
class SM_MegaMenu_Block_Adminhtml_Menu_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);

        $fieldset = $form->addFieldset('web_form', array('legend'=>Mage::helper('megamenu')->__('Item information')));

        $fieldset->addField('menu_name', 'text', array(
            'label'     => Mage::helper('megamenu')->__('Menu name'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'menu_name',
        ));
        $fieldset->addField('menu_type', 'select', array(
            'label'     => Mage::helper('megamenu')->__('Menu type'),
            'name'      => 'menu_type',
            'values'    => array(
                '1'     =>"Custom Link",
                '2'     =>"Category Link",
                '3'     =>"Block Link"
            )
        ));
        $fieldset->addField('custom_link', 'text', array(
            'label'     => Mage::helper('megamenu')->__('Custom Link'),
            'name'      => 'custom_link'
        ));
        $fieldset->addField('cate_id', 'select', array(
            'label'     => 'Category',
            'name'      => 'cate_id',
            'values' => $this->getCategories()
        ));
//        $fieldset->addField('block_link', 'text', array(
//            'label'     => Mage::helper('megamenu')->__('Block Link'),
//            'name'      => 'block_link'
//        ));
        $fieldset->addField('block_link', 'select', array(
            'label'     => Mage::helper('megamenu')->__('Block Link'),
            'name'      => 'block_link',
            'values'   => Mage::getModel('megamenu/source_cms_block')->getAllBlock(),
        ));
        $fieldset->addField('menu_order', 'text', array(
            'label'     => Mage::helper('megamenu')->__('Sort order'),
            'class'     => 'validate-number',
            'name'      => 'menu_order',
        ));
        $fieldset->addField('menu_level', 'text', array(
            'label'     => Mage::helper('megamenu')->__('Menu Level'),
            'class'     => 'validate-number',
            'required'  => true,
            'name'      => 'menu_level',
        ));
        $fieldset->addField('menu_status', 'select', array(
            'label'     => Mage::helper('megamenu')->__('Menu status'),
            'class'     => 'required-entry',
            'name'      => 'menu_status',
            'values'    => array(
                '0'     =>"Enable",
                '1'     =>"Disable"
            )
        ));
        $fieldset->addField('menu_limit', 'text', array(
            'label'     => Mage::helper('megamenu')->__('Menu child limit'),
            'class'     => 'validate-number',
            'required'  => true,
            'name'      => 'menu_limit',
        ));
        $fieldset->addField('parent_id', 'select', array(
            'label'     => 'Parent menu',
            'name'      => 'parent_id',
            'values' => $this->getMegaMenu()
        ));
        if ( Mage::getSingleton('adminhtml/session')->getMenuData() )
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getMenuData());
            Mage::getSingleton('adminhtml/session')->getMenuData(null);
        } elseif ( Mage::registry('menu_data') ) {
            $form->setValues(Mage::registry('menu_data')->getData());
        }
        $this->setForm($form);
        $this->setChild('form_after', $this->getLayout()->createBlock('adminhtml/widget_form_element_dependence')
                ->addFieldMap('menu_type', 'menu_type')
                ->addFieldMap('custom_link', 'custom_link')
                ->addFieldMap('cate_id', 'cate_id')
                ->addFieldMap('block_link', 'block_link')
                ->addFieldDependence(
                    'custom_link',
                    'menu_type',
                    1
                )
                ->addFieldDependence(
                    'cate_id',
                    'menu_type',
                    2
                )
                ->addFieldDependence(
                    'block_link',
                    'menu_type',
                    3
                )
        );

        return parent::_prepareForm();
    }
    protected function getCategories(){

        $category = Mage::getModel('catalog/category');
        $tree = $category->getTreeModel();
        $tree->load();
        $ids = $tree->getCollection()->getAllIds();
        $arr = array();
        if ($ids){
            foreach ($ids as $id){
                $cat = Mage::getModel('catalog/category');
                $cat->load($id);
                $arr[$id] = $cat->getName();
            }
        }

        return $arr;

    }
    protected function getMegaMenu(){
        $menu = Mage::getModel('megamenu/menu')->getCollection();
        $ids = $menu->getAllIds();
        $arr = array();
        $arr[0]="Root menu";
        if($ids){
            foreach($ids as $id){
                $menu = Mage::getModel('megamenu/menu');
                $menu->load($id);
                $arr[$id]=$menu->getMenuName();
            }
        }
        return $arr;
    }
    public function getBlockLink($blockId)
    {
        $html = $this->getLayout()->createBlock('cms/block')->setBlockId($blockId)->toHtml();

        return $html;
    }
}