<?php
require_once __DIR__ . '/../BaseModel.php';

class ReferenceModel extends BaseModel
{
    public ?int $reference_id;
    public string $reference_nom;

    public function __construct(?int $reference_id = null, string $reference_nom = '')
    {
        parent::__construct();
        $this->tableName = 'produit_references';
        $this->reference_id = $reference_id;
        $this->reference_nom = $reference_nom;
    }
}
