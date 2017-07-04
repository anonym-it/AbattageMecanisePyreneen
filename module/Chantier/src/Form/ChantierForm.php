<?php

namespace Chantier\Form;

use Zend\Form\Form;

class ChantierForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('chantier');
        
        $this->add([
            'name' => 'id',
            'type' => 'hidden',
        ]);
        $this->add([
            'name' => 'nom',
            'type' => 'text',
            'options' => [
                'label' => 'Nom',
            ],
        ]);
        $this->add([
            'name' => 'lieu',
            'type' => 'text',
            'options' => [
                'label' => 'Lieu',
            ],
        ]);
        $this->add([
            'name' => 'foret',
            'type' => 'text',
            'options' => [
                'label' => 'Foret',
            ],
        ]);
        $this->add([
            'name' => 'client',
            'type' => 'text',
            'options' => [
                'label' => 'Client',
            ],
        ]);
        $this->add([
            'name' => 'codechantier',
            'type' => 'text',
            'options' => [
                'label' => 'Code chantier',
            ],
        ]);
        $this->add([
            'name' => 'debut',
            'type' => 'text',
            'options' => [
                'label' => 'Debut',
            ],
        ]);
        $this->add([
            'name' => 'fin',
            'type' => 'text',
            'options' => [
                'label' => 'Fin',
            ],
        ]);
        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Ajouter',
                'id'    => 'submitbutton',
            ],
        ]);
    }
}