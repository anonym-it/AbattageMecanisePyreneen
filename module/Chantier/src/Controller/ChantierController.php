<?php

namespace Chantier\Controller;

use Chantier\Model\ChantierTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Chantier\Form\ChantierForm;
use Chantier\Model\Chantier;

class ChantierController extends AbstractActionController
{
    private $table;
    
    public function __construct(ChantierTable $table)
    {
        $this->table = $table;
    }
    
    public function indexAction()
    {
        return new ViewModel([
            'chantiers' => $this->table->fetchAll(),
        ]);  
    }
    
    public function addAction()
    {
        $form = new ChantierForm();
        $form->get('submit')->setValue('Add');
        
        $request = $this->getRequest();
        
        if (! $request->isPost()) {
            return ['form' => $form];
        }
        
        $chantier = new Chantier();
        $form->setInputFilter($chantier->getInputFilter());
        $form->setData($request->getPost());
        
        if (! $form->isValid()) {
            return ['form' => $form];
        }
        
        $chantier->exchangeArray($form->getData());
        $this->table->saveChantier($chantier);
        return $this->redirect()->toRoute('chantier');
        
    }
    
    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        
        if (0 === $id) {
            return $this->redirect()->toRoute('chantier', ['action' => 'add']);
        }
        
        try {
            $chantier = $this->table->getChantier($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('chantier', ['action' => 'index']);
        }
        
        $form = new ChantierForm();
        $form->bind($chantier);
        $form->get('submit')->setAttribute('value', 'Modifier');
        
        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form];
        
        if (! $request->isPost()) {
            return $viewData;
        }
        
        $form->setInputFilter($chantier->getInputFilter());
        $form->setData($request->getPost());
        
        if (! $form->isValid()) {
            return $viewData;
        }
        
        $this->table->saveChantier($chantier);
        
        return $this->redirect()->toRoute('chantier', ['action' => 'index']);
    }
    
    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('chantier');
        }
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'Non');
            
            if ($del == 'Oui') {
                $id = (int) $request->getPost('id');
                $this->table->deleteChantier($id);
            }
            
            return $this->redirect()->toRoute('chantier');
        }
        
        return [
            'id'    => $id,
            'chantier' => $this->table->getChantier($id),
        ];
    }
}