// Représente une tâche dans notre liste
class Tache {
  constructor(id, titre, description, estTerminee = false) {
    this.id = id;
    this.titre = titre.trim();
    this.description = description.trim();
    this.estTerminee = estTerminee;
  }

  // Vérifie que les données envoyées par le client sont correctes avant de créer ou modifier une tâche
  static valider(body) {
    const { titre, description, estTerminee } = body;
    if (typeof titre !== 'string' || titre.trim() === '') return 'Le champ "titre" est requis et doit être une chaîne non vide.';
    if (typeof description !== 'string' || description.trim() === '') return 'Le champ "description" est requis et doit être une chaîne non vide.';
    if (typeof estTerminee !== 'boolean') return 'Le champ "estTerminee" est requis et doit être un booléen.';
    return null;
  }
}

module.exports = Tache;
