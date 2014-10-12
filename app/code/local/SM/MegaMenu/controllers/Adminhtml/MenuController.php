<?php
/**
 * Created by PhpStorm.
 * User: tronghuan
 * Date: 10/12/14
 * Time: 3:47 PM
 */
class SM_MegaMenu_Adminhtml_MenuController extends Mage_Adminhtml_Controller_Action{
    protected function _initAction() {
        $this->loadLayout()
            ->_setActiveMenu('megamenu/menu')
            ->_addBreadcrumb(Mage::helper('megamenu')->__('Menu Manager'), Mage::helper('megamenu')->__('Menu Manager'));

        return $this;
    }
    public function indexAction(){
        echo __METHOD__;
        $this->loadLayout();
        $this->renderLayout();
        $catlistHtml = $this->getTreeCategories(1, false);
    }

    function getTreeCategories($parentId, $isChild){
        $html="";
        $allCats = Mage::getModel('catalog/category')->getCollection()
            ->addAttributeToSelect('*')
            ->addAttributeToFilter('is_active','1')
            ->addAttributeToFilter('include_in_menu','1')
            ->addAttributeToFilter('parent_id',array('eq' => $parentId))
            ->addAttributeToSort('position', 'asc');

        $class = ($isChild) ? "sub-cat-list" : "cat-list";
        $html .= '<ul class="'.$class.'">';
        foreach($allCats as $category)
        {
            $html .= '<li><span>'."id:".$category->getId()."-name:".$category->getName()."-parent:".$category->getParentId()."-level:".$category->getLevel()."</span>";
            $subcats = $category->getChildren();
            if($subcats != ''){
                $html .= $this->getTreeCategories($category->getId(), true);
            }
            $html .= '</li>';
        }
        $html .= '</ul>';
        return $html;
    }
    public function newAction() {
        $this->_forward('edit');
    }
    public function editAction() {
        $id     = $this->getRequest()->getParam('id');
        $model  = Mage::getModel('megamenu/menu')->load($id);

        if ($model->getId() || $id == 0) {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            if (!empty($data)) {
                $model->setData($data);
            }

            Mage::register('menu_data', $model);

            $this->loadLayout();
            $this->_setActiveMenu('megamenu/menu');

            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Menu Manager'), Mage::helper('adminhtml')->__('Menu Manager'));
            $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Menu News'), Mage::helper('adminhtml')->__('Menu News'));

            $this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

            $this->_addContent($this->getLayout()->createBlock('megamenu/adminhtml_menu_edit'))
                ->_addLeft($this->getLayout()->createBlock('megamenu/adminhtml_menu_edit_tabs'));

            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('megamenu')->__('Item does not exist'));
            $this->_redirect('*/*/');
        }
    }
    public function saveAction() {
        if ($data = $this->getRequest()->getPost()) {
            $model = Mage::getModel('megamenu/menu');
            $model->setData($data)
                ->setId($this->getRequest()->getParam('id'));

            try {
                if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
                    $model->setCreatedTime(now())
                        ->setUpdateTime(now());
                } else {
                    $model->setUpdateTime(now());
                }

                $model->save();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('megamenu')->__('Item was successfully saved'));
                Mage::getSingleton('adminhtml/session')->setFormData(false);

                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('megamenu')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
    }
    public function deleteAction() {
        if( $this->getRequest()->getParam('id') > 0 ) {
            try {
                $model = Mage::getModel('megamenu/menu');

                $model->setId($this->getRequest()->getParam('id'))
                    ->delete();

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        }
        $this->_redirect('*/*/');
    }
}