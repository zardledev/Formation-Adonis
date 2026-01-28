<?php
require_once __DIR__ . '/../BaseModel.php';

class ProduitsModel extends BaseModel
{
    public ?int $id_produit;
    public string $nom_produit;
    public string $description_produit;
    public float $prix_produit;
    public int $produit_categorie;
    public int $produit_reference;

    public function __construct($id = null, string $nom = '', string $desc = '', float $prix = 0, int $idCat = 0, int $idReference = 0)
    {
        parent::__construct();
        $this->tableName = 'produits';
        $this->addExclude('id_produit');
        $this->id_produit = $id ? (int)$id : null;
        $this->nom_produit = htmlspecialchars($nom);
        $this->description_produit = htmlspecialchars($desc);
        $this->prix_produit = (float)$prix;
        $this->produit_categorie = (int)$idCat;
        $this->produit_reference = (int)$idReference;
    }

    public function getId_produit(): ?int
    {
        return $this->id_produit;
    }

    public function setId_produit(?int $id): void
    {
        $this->id_produit = $id;
    }

    public function getNom_produit(): string
    {
        return $this->nom_produit;
    }

    public function setNom_produit(string $nom): void
    {
        $this->nom_produit = htmlspecialchars($nom);
    }

    public function getDescription_produit(): string
    {
        return $this->description_produit;
    }

    public function setDescription_produit(string $desc): void
    {
        $this->description_produit = htmlspecialchars($desc);
    }

    public function getPrix_produit(): float
    {
        return $this->prix_produit;
    }

    public function setPrix_produit(float $prix): void
    {
        $this->prix_produit = $prix;
    }

    public function getProduit_categorie(): int
    {
        return $this->produit_categorie;
    }

    public function setProduit_categorie(int $idCat): void
    {
        $this->produit_categorie = $idCat;
    }

    public function getProduit_reference(): ?int
    {
        return $this->produit_reference;
    }

    public function setProduit_reference(?int $idRef): void
    {
        $this->produit_reference = $idRef;
    }
}
