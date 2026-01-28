<div class="container py-5">
    <div class="content-wrapper p-4 p-md-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="display-5 fw-bold text-primary">
                <i class="bi bi-bag-fill me-2"></i>Gestion des Produits
            </h1>
            <a href="<?= $baseUrl ?>/produits/ajouter" class="btn btn-success btn-lg shadow">
                <i class="bi bi-plus-circle me-2"></i>Nouveau Produit
            </a>
        </div>

        <?php if (empty($baseExtraData)): ?>
        <div class="alert alert-info text-center py-5">
            <i class="bi bi-inbox fs-1 d-block mb-3"></i>
            <h4>Aucun produit pour le moment</h4>
            <p class="mb-0">Commencez par ajouter votre premier produit !</p>
        </div>
        <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th><i class="bi bi-hash me-1"></i>ID</th>
                        <th><i class="bi bi-tag me-1"></i>Nom</th>
                        <th><i class="bi bi-currency-euro me-1"></i>Prix</th>
                        <th><i class="bi bi-folder me-1"></i>Cat&eacute;gorie</th>
                        <th><i class="bi bi-upc me-1"></i>R&eacute;f&eacute;rence</th>
                        <th><i class="bi bi-images me-1"></i>Images</th>
                        <th class="text-center"><i class="bi bi-gear me-1"></i>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($baseExtraData as $data): ?>
                    <tr>
                        <td><strong>#<?= $data['id_produit'] ?></strong></td>
                        <td><?= htmlspecialchars($data['nom_produit'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><span class="badge bg-success fs-6"><?= number_format($data['prix_produit'], 2, ',', ' ') ?> &euro;</span></td>
                        <td><span class="badge bg-secondary"><?= htmlspecialchars($data['categorie_nom'], ENT_QUOTES, 'UTF-8') ?></span></td>
                        <td><code><?= htmlspecialchars($data['reference_nom'], ENT_QUOTES, 'UTF-8') ?></code></td>
                        <td>
                            <span class="badge badge-images">
                                <i class="bi bi-image me-1"></i><?= $baseExtraImageModel->getCountById($data['id_produit'], 'produits_id') ?>
                            </span>
                        </td>
                        <td class="text-center">
                            <a href="<?= $baseUrl ?>/produits/<?= $data['id_produit'] ?>" class="btn btn-info btn-sm me-1" title="Voir les d&eacute;tails">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="<?= $baseUrl ?>/produits/<?= $data['id_produit'] ?>/editer" class="btn btn-warning btn-sm me-1" title="Modifier">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="<?= $baseUrl ?>/produits/<?= $data['id_produit'] ?>/supprimer" class="btn btn-danger btn-sm"
                               onclick="return confirm('Etes-vous sur de vouloir supprimer ce produit ?')" title="Supprimer">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</div>
