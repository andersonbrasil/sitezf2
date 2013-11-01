<?php

namespace Site\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Site\Model\Site;
use Site\Form\SiteForm;

class SiteController extends AbstractActionController
{
    protected $siteTable;
    public function getSiteTable()
     {
         if (!$this->siteTable) {
             $sm = $this->getServiceLocator();
             $this->siteTable = $sm->get('Site\Model\SiteTable');
         }
         return $this->siteTable;
     }
    public function indexAction()
    {
        return new ViewModel(array(
             'sites' => $this->getSiteTable()->fetchAll(),
         ));
    }

    public function addAction()
    {
        $form = new SiteForm();
         $form->get('submit')->setValue('Add');

         $request = $this->getRequest();
         if ($request->isPost()) {
             $site = new Site();
             $form->setInputFilter($site->getInputFilter());
             $form->setData($request->getPost());

             if ($form->isValid()) {
                 $site->exchangeArray($form->getData());
                 $this->getSiteTable()->saveSite($site);

                 // Redirect to list of sites
                 return $this->redirect()->toRoute('site');
             }
         }
         return array('form' => $form);

    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
         if (!$id) {
             return $this->redirect()->toRoute('site', array(
                 'action' => 'add'
             ));
         }

         // Get the Site with the specified id.  An exception is thrown
         // if it cannot be found, in which case go to the index page.
         try {
             $site = $this->getSiteTable()->getSite($id);
         }
         catch (\Exception $ex) {
             return $this->redirect()->toRoute('site', array(
                 'action' => 'index'
             ));
         }

         $form  = new SiteForm();
         $form->bind($site);
         $form->get('submit')->setAttribute('value', 'Edit');

         $request = $this->getRequest();
         if ($request->isPost()) {
             $form->setInputFilter($site->getInputFilter());
             $form->setData($request->getPost());

             if ($form->isValid()) {
                 $this->getSiteTable()->saveSite($site);

                 // Redirect to list of sites
                 return $this->redirect()->toRoute('site');
             }
         }

         return array(
             'id' => $id,
             'form' => $form,
         );
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
         if (!$id) {
             return $this->redirect()->toRoute('site');
         }

         $request = $this->getRequest();
         if ($request->isPost()) {
             $del = $request->getPost('del', 'No');

             if ($del == 'Yes') {
                 $id = (int) $request->getPost('id');
                 $this->getSiteTable()->deleteSite($id);
             }

             // Redirect to list of sites
             return $this->redirect()->toRoute('site');
         }

         return array(
             'id'    => $id,
             'site' => $this->getSiteTable()->getSite($id)
         );
    }


}

