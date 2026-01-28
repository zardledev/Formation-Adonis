<div class="container py-5">
    <div class="content-wrapper p-4 p-md-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="display-6 fw-bold text-primary">
                <i class="bi bi-pencil-square me-2"></i>Modifier le Produit
            </h2>
            <a href="<?= $baseUrl ?>/produits/<?= $id ?>" class="btn btn-outline-secondary">
                <i class="bi bi-x-circle me-1"></i>Annuler
            </a>
        </div>

        <form method="POST" enctype="multipart/form-data" action="<?= $baseUrl ?>/produits/<?= $id ?>/editer">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label"><i class="bi bi-tag-fill me-1"></i>Nom du produit</label>
                    <input class="form-control form-control-lg" name="nom_produit" value="<?= htmlspecialchars($baseExtraData[0]['nom_produit'], ENT_QUOTES, 'UTF-8') ?>" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label"><i class="bi bi-currency-euro me-1"></i>Prix</label>
                    <input type="number" step="0.01" class="form-control form-control-lg" name="prix_produit" value="<?= $baseExtraData[0]['prix_produit'] ?>" required>
                </div>

                <div class="col-12">
                    <label class="form-label"><i class="bi bi-text-paragraph me-1"></i>Description</label>
                    <textarea class="form-control" name="description_produit" rows="4"><?= htmlspecialchars($baseExtraData[0]['description_produit'], ENT_QUOTES, 'UTF-8') ?></textarea>
                </div>

                <div class="col-md-6">
                    <label class="form-label"><i class="bi bi-folder-fill me-1"></i>Cat&eacute;gorie</label>
                    <select class="form-select form-select-lg" name="categorie_id" required>
                        <?php foreach ($categories as $categorie): ?>
                            <option value="<?= $categorie['categorie_id'] ?>" <?= $categorie['categorie_id'] == $baseExtraData[0]['produit_categorie'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($categorie['categorie_nom'], ENT_QUOTES, 'UTF-8') ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label"><i class="bi bi-upc me-1"></i>R&eacute;f&eacute;rence</label>
                    <input class="form-control form-control-lg" name="reference_nom" value="<?= htmlspecialchars($baseExtraData[0]['reference_nom'], ENT_QUOTES, 'UTF-8') ?>" required>
                </div>

                <?php if (!empty($imagesData)): ?>
                <div class="col-12">
                    <label class="form-label"><i class="bi bi-images me-1"></i>Images actuelles (<?= count($imagesData) ?>)</label>
                    <div class="row g-3">
                        <?php foreach ($imagesData as $image): ?>
                        <div class="col-md-3 col-6">
                            <div class="image-preview-card">
                                <img src="<?= $baseUrl ?>/<?= htmlspecialchars($image['images_nom'], ENT_QUOTES, 'UTF-8') ?>" class="img-fluid" alt="Image produit">
                                <a href="<?= $baseUrl ?>/produits/<?= $id ?>/editer?delete_image=<?= $image['image_id'] ?>"
                                   class="delete-overlay text-decoration-none"
                                   onclick="return confirm('Supprimer cette image ?')">
                                    <i class="bi bi-trash me-1"></i>Supprimer
                                </a>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <div class="col-12">
                    <label class="form-label"><i class="bi bi-plus-circle me-1"></i>Ajouter de nouvelles images</label>
                    <div class="upload-zone">
                        <i class="bi bi-cloud-upload fs-1 text-primary mb-2"></i>
                        <h5>Cliquez pour ajouter des images</h5>
                        <p class="text-muted mb-0">Vous pouvez selectionner plusieurs images a la fois</p>
                        <input type="file" name="nouvelles_images[]" accept="image/*" multiple style="display: none;" onchange="previewImages(event)" id="fileInput">
                        <button type="button" class="btn btn-outline-primary mt-3" onclick="document.getElementById('fileInput').click()">
                            <i class="bi bi-plus-lg me-1"></i>Parcourir
                        </button>
                    </div>
                    <div id="preview" class="mt-3 row g-2"></div>
                </div>

                <div class="col-12 mt-4">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-between">
                        <a href="<?= $baseUrl ?>/produits/<?= $id ?>" class="btn btn-secondary btn-lg">
                            <i class="bi bi-x-circle me-2"></i>Annuler
                        </a>
                        <button class="btn btn-primary btn-lg" name="modifier">
                            <i class="bi bi-check-circle me-2"></i>Enregistrer les modifications
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
