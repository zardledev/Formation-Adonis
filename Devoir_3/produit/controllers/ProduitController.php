<?php
class ProduitController
{
    private string $basePath;
    private string $rootPath;
    private string $baseUrl;

    public function __construct(string $basePath, string $baseUrl)
    {
        $this->basePath = $basePath;
        $this->rootPath = dirname($basePath);
        $this->baseUrl = $baseUrl;
    }

    public function index(): void
    {
        require_once $this->basePath . '/model/BaseExtraModel.php';
        $baseExtraModel = new BaseExtraModel('produits');
        $baseExtraData = $baseExtraModel->getAllRequest([
            [
                'table' => 'categories',
                'foreign' => 'produit_categorie',
                'reference' => 'categorie_id',
            ],
            [
                'table' => 'produit_references',
                'foreign' => 'produit_reference',
                'reference' => 'reference_id',
            ],
        ]);
        $baseExtraImageModel = new BaseExtraModel('produits_images');
        $this->render('produits-index', [
            'baseExtraData' => $baseExtraData,
            'baseExtraImageModel' => $baseExtraImageModel,
            'title' => 'Gestion des Produits',
        ]);
    }

    public function create(): void
    {
        require_once $this->basePath . '/model/db/CategoriesModel.php';
        $categorieModel = new CategoriesModel();
        $categories = $categorieModel->getAll();
        $this->render('produits-ajouter', [
            'categories' => $categories,
            'title' => 'Ajouter un Produit',
        ]);
    }

    public function store(): void
    {
        require_once $this->basePath . '/model/db/ProduitsModel.php';
        require_once $this->basePath . '/model/db/CategoriesModel.php';
        require_once $this->basePath . '/model/db/ReferenceModel.php';
        require_once $this->basePath . '/model/db/ImagesModel.php';
        require_once $this->basePath . '/model/db/ProduitsImagesModel.php';

        $name_products = $this->sanitize($_POST['nom_produit'] ?? '');
        $description_products = $this->sanitize($_POST['description_produit'] ?? '');
        $price_products = $this->sanitize($_POST['prix_produit'] ?? 0);
        $id_categorie = (int)($_POST['id_categorie'] ?? 0);
        $reference_products = $this->sanitize($_POST['reference_produit'] ?? '');

        if (!isset($_FILES['photo_produit'])) {
            $this->redirect('/produits/ajouter');
        }

        $produit = new ProduitsModel(
            null,
            $name_products,
            $description_products,
            (float)$price_products,
            $id_categorie,
            0
        );

        $reference = new ReferenceModel(null, $reference_products);
        $getReferenceName = $reference->getByField('reference_nom', $reference_products);

        if (empty($getReferenceName)) {
            $reference->insertIntoDatabase();
            $getReferenceName = $reference->getByField('reference_nom', $reference_products);
        }

        $produit->produit_reference = (int)$getReferenceName[0]['reference_id'];
        $produit->insertIntoDatabase();

        $id_produit_insere = (int)$produit->id_produit;

        $files = $_FILES['photo_produit'];
        for ($i = 0; $i < count($files['name']); $i++) {
            if ($files['error'][$i] !== UPLOAD_ERR_OK) {
                continue;
            }

            $tmpName = $files['tmp_name'][$i];
            $name = basename($files['name'][$i]);
            $targetRel = 'assets/uploads/' . $name;
            $targetDir = $this->rootPath . '/assets/uploads';

            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            $targetPath = $this->rootPath . '/' . $targetRel;

            if (move_uploaded_file($tmpName, $targetPath)) {
                $image = new ImagesModel(null, $targetRel);
                $image->insertIntoDatabase();
                $id_image_insere = (int)$image->image_id;
                $produit_image = new ProduitsImagesModel($id_produit_insere, $id_image_insere);
                $produit_image->insertIntoDatabase();
            }
        }

        $this->redirect('/produits');
    }

    public function show(int $id): void
    {
        require_once $this->basePath . '/model/BaseExtraModel.php';
        $baseExtraModel = new BaseExtraModel('produits');
        $baseExtraData = $baseExtraModel->getAllRequestById([
            [
                'table' => 'categories',
                'foreign' => 'produit_categorie',
                'reference' => 'categorie_id',
            ],
            [
                'table' => 'produit_references',
                'foreign' => 'produit_reference',
                'reference' => 'reference_id',
            ],
        ], 'id_produit', $id);

        if (!$baseExtraData || !$baseExtraData[0]) {
            $this->redirect('/produits');
        }

        $baseExtraImageModel = new BaseExtraModel('produits_images');
        $imagesData = $baseExtraImageModel->getAllRequestById([
            [
                'table' => 'images',
                'foreign' => 'image_id',
                'reference' => 'image_id',
            ],
        ], 'produits_id', $id);

        $this->render('produits-details', [
            'baseExtraData' => $baseExtraData,
            'imagesData' => $imagesData,
            'title' => 'Details - ' . $baseExtraData[0]['nom_produit'],
        ]);
    }

    public function edit(int $id): void
    {
        require_once $this->basePath . '/model/BaseExtraModel.php';
        require_once $this->basePath . '/model/db/CategoriesModel.php';
        require_once $this->basePath . '/model/db/ImagesModel.php';

        $baseExtraModel = new BaseExtraModel('produits');
        $baseExtraData = $baseExtraModel->getAllRequestById([
            [
                'table' => 'categories',
                'foreign' => 'produit_categorie',
                'reference' => 'categorie_id',
            ],
            [
                'table' => 'produit_references',
                'foreign' => 'produit_reference',
                'reference' => 'reference_id',
            ],
        ], 'id_produit', $id);

        if (!$baseExtraData || !$baseExtraData[0]) {
            $this->redirect('/produits');
        }

        $categorieModel = new CategoriesModel();
        $categories = $categorieModel->getAll();

        $baseExtraImageModel = new BaseExtraModel('produits_images');
        $imagesData = $baseExtraImageModel->getAllRequestById([
            [
                'table' => 'images',
                'foreign' => 'image_id',
                'reference' => 'image_id',
            ],
        ], 'produits_id', $id);

        if (isset($_GET['delete_image'])) {
            $image_id_to_delete = (int)$_GET['delete_image'];
            $imageModel = new ImagesModel();
            $imageData = $imageModel->getById($image_id_to_delete, 'image_id');

            if ($imageData) {
                $imageToDelete = new ImagesModel($imageData['image_id'], $imageData['images_nom']);
                $imageToDelete->deleteImageFile();
                $imageToDelete->deleteFromDatabase($image_id_to_delete, 'image_id');
            }

            $this->redirect('/produits/' . $id . '/editer');
        }

        $this->render('produits-editer', [
            'baseExtraData' => $baseExtraData,
            'categories' => $categories,
            'imagesData' => $imagesData,
            'id' => $id,
            'title' => 'Modifier - ' . $baseExtraData[0]['nom_produit'],
        ]);
    }

    public function update(int $id): void
    {
        require_once $this->basePath . '/model/BaseExtraModel.php';
        require_once $this->basePath . '/model/db/ProduitsModel.php';
        require_once $this->basePath . '/model/db/ReferenceModel.php';
        require_once $this->basePath . '/model/db/ImagesModel.php';
        require_once $this->basePath . '/model/db/ProduitsImagesModel.php';

        $baseExtraModel = new BaseExtraModel('produits');
        $baseExtraData = $baseExtraModel->getAllRequestById([
            [
                'table' => 'categories',
                'foreign' => 'produit_categorie',
                'reference' => 'categorie_id',
            ],
            [
                'table' => 'produit_references',
                'foreign' => 'produit_reference',
                'reference' => 'reference_id',
            ],
        ], 'id_produit', $id);

        if (!$baseExtraData || !$baseExtraData[0]) {
            $this->redirect('/produits');
        }

        $name_products = $this->sanitize($_POST['nom_produit'] ?? '');
        $description_products = $this->sanitize($_POST['description_produit'] ?? '');
        $price_products = $this->sanitize($_POST['prix_produit'] ?? 0);
        $id_categorie = (int)($_POST['categorie_id'] ?? 0);
        $reference_products_name = $this->sanitize($_POST['reference_nom'] ?? '');

        $produit = new ProduitsModel(
            $id,
            $name_products,
            $description_products,
            (float)$price_products,
            $id_categorie,
            $baseExtraData[0]['produit_reference']
        );
        $produit->updateDatabase('id_produit');

        $reference = new ReferenceModel($baseExtraData[0]['reference_id'], $reference_products_name);
        $reference->updateDatabase('reference_id');

        if (isset($_FILES['nouvelles_images']) && !empty($_FILES['nouvelles_images']['name'][0])) {
            $files = $_FILES['nouvelles_images'];
            for ($i = 0; $i < count($files['name']); $i++) {
                if ($files['error'][$i] !== UPLOAD_ERR_OK) {
                    continue;
                }

                $tmpName = $files['tmp_name'][$i];
                $name = basename($files['name'][$i]);
                $targetRel = 'assets/uploads/' . $name;
                $targetDir = $this->rootPath . '/assets/uploads';

                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0777, true);
                }

                $targetPath = $this->rootPath . '/' . $targetRel;

                if (move_uploaded_file($tmpName, $targetPath)) {
                    $image = new ImagesModel(null, $targetRel);
                    $image->insertIntoDatabase();
                    $id_image_insere = (int)$image->image_id;
                    $produit_image = new ProduitsImagesModel($id, $id_image_insere);
                    $produit_image->insertIntoDatabase();
                }
            }
        }

        $this->redirect('/produits/' . $id);
    }

    public function destroy(int $id): void
    {
        require_once $this->basePath . '/model/db/ProduitsModel.php';
        require_once $this->basePath . '/model/db/ReferenceModel.php';
        require_once $this->basePath . '/model/db/ImagesModel.php';
        require_once $this->basePath . '/model/BaseExtraModel.php';

        $baseExtraModel = new BaseExtraModel('produits');
        $baseExtraData = $baseExtraModel->getAllRequestById([
            [
                'table' => 'categories',
                'foreign' => 'produit_categorie',
                'reference' => 'categorie_id',
            ],
            [
                'table' => 'produit_references',
                'foreign' => 'produit_reference',
                'reference' => 'reference_id',
            ],
        ], 'id_produit', $id);

        if (!$baseExtraData || !$baseExtraData[0]) {
            $this->redirect('/produits');
        }

        $produitModel = new ProduitsModel();
        $produitModel->id_produit = (int)$baseExtraData[0]['id_produit'];

        $referenceModel = new ReferenceModel();
        $referenceModel->reference_id = (int)$baseExtraData[0]['reference_id'];

        $baseExtraImageModel = new BaseExtraModel('produits_images');
        $imagesData = $baseExtraImageModel->getAllRequestById([
            [
                'table' => 'images',
                'foreign' => 'image_id',
                'reference' => 'image_id',
            ],
        ], 'produits_id', $id);

        foreach ($imagesData as $imageData) {
            $imageModel = new ImagesModel($imageData['image_id'], $imageData['images_nom']);
            $imageModel->deleteImageFile();
        }

        $referenceModel->deleteFromDatabase($referenceModel->reference_id, 'reference_id');
        $produitModel->deleteFromDatabase($produitModel->id_produit, 'id_produit');

        $this->redirect('/produits');
    }

    private function render(string $view, array $data = []): void
    {
        extract($data);
        $baseUrl = $this->baseUrl;
        ob_start();
        require $this->basePath . '/views/' . $view . '.php';
        $content = ob_get_clean();
        require $this->basePath . '/template.php';
    }

    private function sanitize($value): string
    {
        return htmlspecialchars(trim((string)$value), ENT_QUOTES, 'UTF-8');
    }

    private function redirect(string $path): void
    {
        header('Location: ' . $this->baseUrl . $path);
        exit;
    }
}
