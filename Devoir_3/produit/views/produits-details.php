<div class="container py-5">
    <div class="content-wrapper p-4 p-md-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="display-6 fw-bold text-primary">
                <i class="bi bi-eye-fill me-2"></i>Details du Produit
            </h2>
            <a href="<?= $baseUrl ?>/produits" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i>Retour a la liste
            </a>
        </div>

        <div class="card product-card">
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-md-8">
                        <h1 class="display-5 mb-3"><?= htmlspecialchars($baseExtraData[0]['nom_produit'], ENT_QUOTES, 'UTF-8') ?></h1>

                        <div class="mb-4">
                            <span class="badge bg-success fs-4 me-2">
                                <i class="bi bi-currency-euro me-1"></i><?= number_format($baseExtraData[0]['prix_produit'], 2, ',', ' ') ?> &euro;
                            </span>
                            <span class="badge bg-secondary fs-6">
                                <i class="bi bi-folder me-1"></i><?= htmlspecialchars($baseExtraData[0]['categorie_nom'], ENT_QUOTES, 'UTF-8') ?>
                            </span>
                        </div>

                        <div class="mb-4">
                            <h5 class="text-muted mb-2"><i class="bi bi-text-paragraph me-2"></i>Description</h5>
                            <p class="lead"><?= $baseExtraData[0]['description_produit'] ? htmlspecialchars($baseExtraData[0]['description_produit'], ENT_QUOTES, 'UTF-8') : 'Aucune description disponible' ?></p>
                        </div>

                        <div class="mb-3">
                            <h5 class="text-muted mb-2"><i class="bi bi-info-circle me-2"></i>Informations</h5>
                            <div>
                                <span class="info-badge">
                                    <i class="bi bi-upc me-1"></i>R&eacute;f&eacute;rence: <strong><?= htmlspecialchars($baseExtraData[0]['reference_nom'], ENT_QUOTES, 'UTF-8') ?></strong>
                                </span>
                                <span class="info-badge">
                                    <i class="bi bi-images me-1"></i>Images: <strong><?= count($imagesData) ?></strong>
                                </span>
                            </div>
                        </div>
                    </div>

                    <?php if (!empty($imagesData)): ?>
                    <div class="col-md-4">
                        <img id="mainImage" src="<?= $baseUrl ?>/<?= htmlspecialchars($imagesData[0]['images_nom'], ENT_QUOTES, 'UTF-8') ?>" class="img-fluid rounded shadow" alt="<?= htmlspecialchars($baseExtraData[0]['nom_produit'], ENT_QUOTES, 'UTF-8') ?>">
                    </div>
                    <?php endif; ?>
                </div>

                <?php if (!empty($imagesData)): ?>
                <div class="mt-4">
                    <h5 class="text-muted mb-3"><i class="bi bi-images me-2"></i>Galerie d'images (<?= count($imagesData) ?>)</h5>
                    <div class="row g-3">
                        <?php foreach ($imagesData as $image): ?>
                        <div class="col-md-3 col-6">
                            <img src="<?= $baseUrl ?>/<?= htmlspecialchars($image['images_nom'], ENT_QUOTES, 'UTF-8') ?>"
                                 class="img-fluid gallery-img shadow-sm"
                                 alt="Image produit"
                                 data-image-src="<?= $baseUrl ?>/<?= htmlspecialchars($image['images_nom'], ENT_QUOTES, 'UTF-8') ?>">
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

                <hr class="my-4">

                <div class="d-flex gap-2 flex-wrap">
                    <a href="<?= $baseUrl ?>/produits/<?= $baseExtraData[0]['id_produit'] ?>/editer" class="btn btn-warning btn-lg">
                        <i class="bi bi-pencil me-2"></i>Modifier
                    </a>
                    <a href="<?= $baseUrl ?>/produits/<?= $baseExtraData[0]['id_produit'] ?>/supprimer"
                       class="btn btn-danger btn-lg"
                       onclick="return confirm('Etes-vous sur de vouloir supprimer ce produit ?')">
                        <i class="bi bi-trash me-2"></i>Supprimer
                    </a>
                    <a href="<?= $baseUrl ?>/produits" class="btn btn-secondary btn-lg">
                        <i class="bi bi-house me-2"></i>Accueil
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
