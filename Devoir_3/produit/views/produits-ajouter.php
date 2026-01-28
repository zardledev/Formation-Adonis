<div class="container py-5">
    <div class="content-wrapper p-4 p-md-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="display-6 fw-bold text-primary">
                <i class="bi bi-plus-circle-fill me-2"></i>Ajouter un Produit
            </h2>
            <a href="<?= $baseUrl ?>/produits" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i>Retour
            </a>
        </div>

        <form method="POST" enctype="multipart/form-data" action="<?= $baseUrl ?>/produits/ajouter">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label"><i class="bi bi-tag-fill me-1"></i>Nom du produit</label>
                    <input class="form-control form-control-lg" name="nom_produit" placeholder="Ex: iPhone 15 Pro" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label"><i class="bi bi-currency-euro me-1"></i>Prix</label>
                    <input type="number" step="0.01" class="form-control form-control-lg" name="prix_produit" placeholder="0.00" required>
                </div>

                <div class="col-12">
                    <label class="form-label"><i class="bi bi-text-paragraph me-1"></i>Description</label>
                    <textarea class="form-control" name="description_produit" rows="4" placeholder="Decrivez votre produit..."></textarea>
                </div>

                <div class="col-md-6">
                    <label class="form-label"><i class="bi bi-folder-fill me-1"></i>Cat&eacute;gorie</label>
                    <select class="form-select form-select-lg" name="id_categorie" required>
                        <option value="">Selectionner une categorie</option>
                        <?php foreach ($categories as $categorie): ?>
                            <option value="<?= $categorie['categorie_id'] ?>"><?= htmlspecialchars($categorie['categorie_nom'], ENT_QUOTES, 'UTF-8') ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label"><i class="bi bi-upc me-1"></i>R&eacute;f&eacute;rence</label>
                    <input class="form-control form-control-lg" name="reference_produit" placeholder="Ex: REF-2024-001" required>
                </div>

                <div class="col-12">
                    <label class="form-label"><i class="bi bi-images me-1"></i>Images du produit</label>
                    <div class="upload-zone">
                        <i class="bi bi-cloud-upload fs-1 text-primary mb-2"></i>
                        <h5>Cliquez pour selectionner des images</h5>
                        <p class="text-muted mb-0">Vous pouvez selectionner plusieurs images a la fois</p>
                        <input type="file" name="photo_produit[]" accept="image/*" multiple style="display: none;" onchange="previewImages(event)" id="fileInput">
                        <button type="button" class="btn btn-outline-primary mt-3" onclick="document.getElementById('fileInput').click()">
                            <i class="bi bi-plus-lg me-1"></i>Parcourir
                        </button>
                    </div>
                    <div id="preview" class="mt-3 row g-2"></div>
                </div>

                <div class="col-12 mt-4">
                    <button class="btn btn-success btn-lg w-100" name="ajouter">
                        <i class="bi bi-check-circle me-2"></i>Ajouter le Produit
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
