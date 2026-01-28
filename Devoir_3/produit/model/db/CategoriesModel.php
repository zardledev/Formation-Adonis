<?php
require_once __DIR__ . '/../BaseModel.php';

class CategoriesModel extends BaseModel
{
    public ?int $categorie_id;
    public string $categorie_nom;

    public function __construct(?int $categorie_id = null, string $categorie_nom = '')
    {
        parent::__construct();
        $this->categorie_id = $categorie_id;
        $this->categorie_nom = $categorie_nom;
    }
}
