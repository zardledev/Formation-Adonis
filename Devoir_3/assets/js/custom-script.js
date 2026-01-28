/* ============================================================
   GESTION DE LA PRÉVISUALISATION DES IMAGES AVANT UPLOAD
   ============================================================ */

let uploadedFiles = [];

function previewImages(event) {
    const preview = document.getElementById('preview');
    preview.innerHTML = '';

    uploadedFiles = Array.from(event.target.files);

    uploadedFiles.forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = function(e) {
            // Créer le conteneur de la prévisualisation
            const colDiv = document.createElement('div');
            colDiv.className = 'col-md-3 col-6';

            const container = document.createElement('div');
            container.className = 'position-relative image-preview-container';
            container.style.cssText = 'border-radius: 10px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1);';

            // Créer l'image
            const img = document.createElement('img');
            img.src = e.target.result;
            img.className = 'img-fluid';
            img.alt = 'Aperçu image';

            // Créer le bouton de suppression
            const deleteBtn = document.createElement('button');
            deleteBtn.type = 'button';
            deleteBtn.className = 'btn btn-danger btn-sm position-absolute';
            deleteBtn.style.cssText = 'top: 5px; right: 5px; z-index: 10;';
            deleteBtn.innerHTML = '<i class="bi bi-trash"></i>';
            deleteBtn.onclick = function(e) {
                e.preventDefault();
                uploadedFiles.splice(index, 1);
                colDiv.remove();
            };

            // Assembler les éléments
            container.appendChild(img);
            container.appendChild(deleteBtn);
            colDiv.appendChild(container);
            preview.appendChild(colDiv);
        };
        reader.readAsDataURL(file);
    });
}

/* ============================================================
   CHANGEMENT DE L'IMAGE PRINCIPALE (PAGE DÉTAILS)
   ============================================================ */

function changeMainImage(imageSrc) {
    const mainImage = document.getElementById('mainImage');

    if (mainImage) {
        // Animation de transition (effet de fondu)
        mainImage.style.opacity = '0.5';
        setTimeout(() => {
            mainImage.src = imageSrc;
            mainImage.style.opacity = '1';
        }, 200);
    }
}

/* ============================================================
   INITIALISATION AU CHARGEMENT DE LA PAGE
   ============================================================ */

document.addEventListener('DOMContentLoaded', function() {

    /* ------------------------------------------------------------
       Gestion du clic sur les images de la galerie
       ------------------------------------------------------------ */
    const galleryImages = document.querySelectorAll('.gallery-img');

    galleryImages.forEach(img => {
        img.addEventListener('click', function() {
            const imageSrc = this.getAttribute('data-image-src');
            if (imageSrc) {
                changeMainImage(imageSrc);
            }
        });
    });

    /* ------------------------------------------------------------
       Confirmation avant suppression
       ------------------------------------------------------------ */
    const deleteLinks = document.querySelectorAll('a[href*="supprimer"]');
    deleteLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            if (!this.hasAttribute('onclick')) {
                if (!confirm('Êtes-vous sûr de vouloir supprimer cet élément ?')) {
                    e.preventDefault();
                }
            }
        });
    });
});
