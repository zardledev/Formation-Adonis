<?php
require_once __DIR__ . '/../BaseModel.php';

class ImagesModel extends BaseModel
{
    public ?int $image_id;
    public string $images_nom;

    public function __construct(?int $image_id = null, string $images_nom = '')
    {
        parent::__construct();
        $this->image_id = $image_id;
        $this->images_nom = $images_nom;
    }

    public function getImageId(): ?int
    {
        return $this->image_id;
    }

    public function setImageId(?int $image_id): void
    {
        $this->image_id = $image_id;
    }

    public function getImagesNom(): string
    {
        return $this->images_nom;
    }

    public function setImagesNom(string $images_nom): void
    {
        $this->images_nom = $images_nom;
    }

    public function deleteImageFile(): bool
    {
        if (file_exists($this->images_nom)) {
            return unlink($this->images_nom);
        }
        return false;
    }
}
