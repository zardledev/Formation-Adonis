<?php
require_once __DIR__ . '/../BaseModel.php';

class ProduitsImagesModel extends BaseModel
{
    public int $produits_id;
    public int $image_id;

    public function __construct(?int $produits_id = null, ?int $image_id = null)
    {
        parent::__construct();
        $this->produits_id = (int)$produits_id;
        $this->image_id = (int)$image_id;
    }
}
