<?php

namespace Chantier\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

class ChantierTable
{
    private $tableGateway;
    
    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    
    public function fetchAll()
    {
        return $this->tableGateway->select();
    }
    
    public function getChantier($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['id' => $id]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf(
                'Aucun resultat avec identifiant : %d',
                $id
                ));
        }
        
        return $row;
    }
    
    public function saveChantier(Chantier $chantier)
    {
        $data = [
            'nom' => $chantier->nom,
            'lieu' => $chantier->lieu,
            'foret' => $chantier->foret,
            'client' => $chantier->client,
            'codechantier' => $chantier->codechantier,
            'debut' => $chantier->debut,
            'fin' => $chantier->fin,
        ];
        
        $id = (int) $chantier->id;
        
        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }
        
        if (! $this->getChantier($id)) {
            throw new RuntimeException(sprintf(
                'Impossible de mettre a jour, cet enregistrement %d est introuvable.',
                $id
                ));
        }
        
        $this->tableGateway->update($data, ['id' => $id]);
    }
    
    public function deleteChantier($id)
    {
        $this->tableGateway->delete(['id' => (int) $id]);
    }
}