const express = require('express');
const Tache = require('./models/Tache');
const donneesInitiales = require('./data/taches.json');

const app = express();
const PORT = 3000;

app.use(express.json());

// On part des données du fichier JSON et on crée de vraies instances de Tache
let taches = donneesInitiales.map(t => new Tache(t.id, t.titre, t.description, t.estTerminee));
let prochainId = taches.length + 1;

// Affiche dans la console chaque requête qui arrive sur le serveur
app.use((req, res, next) => {
  console.log(`[${new Date().toISOString()}] ${req.method} ${req.url}`);
  next();
});

// Retourne toutes les tâches, avec un filtre optionnel par statut (?statut=terminee ou ?statut=en-cours)
app.get('/taches', (req, res) => {
  const { statut } = req.query;

  if (statut === 'terminee') {
    return res.status(200).json(taches.filter(t => t.estTerminee === true));
  }
  if (statut === 'en-cours') {
    return res.status(200).json(taches.filter(t => t.estTerminee === false));
  }

  res.status(200).json(taches);
});

// Cherche une tâche par son id, retourne 404 si elle n'existe pas
app.get('/taches/:id', (req, res) => {
  const id = parseInt(req.params.id);
  const tache = taches.find(t => t.id === id);

  if (!tache) return res.status(404).json({ message: `Tâche avec l'id ${id} introuvable.` });

  res.status(200).json(tache);
});

// Crée une nouvelle tâche après avoir validé les données reçues
app.post('/taches', (req, res) => {
  const erreur = Tache.valider(req.body);
  if (erreur) return res.status(400).json({ message: erreur });

  const nouvelleTache = new Tache(prochainId++, req.body.titre, req.body.description, req.body.estTerminee);
  taches.push(nouvelleTache);
  res.status(201).json(nouvelleTache);
});

// Remplace complètement une tâche existante par les nouvelles données
app.put('/taches/:id', (req, res) => {
  const id = parseInt(req.params.id);
  const index = taches.findIndex(t => t.id === id);

  if (index === -1) return res.status(404).json({ message: `Tâche avec l'id ${id} introuvable.` });

  const erreur = Tache.valider(req.body);
  if (erreur) return res.status(400).json({ message: erreur });

  taches[index] = new Tache(id, req.body.titre, req.body.description, req.body.estTerminee);
  res.status(200).json(taches[index]);
});

// Coche ou décoche une tâche sans toucher au reste
app.patch('/taches/:id', (req, res) => {
  const id = parseInt(req.params.id);
  const tache = taches.find(t => t.id === id);

  if (!tache) return res.status(404).json({ message: `Tâche avec l'id ${id} introuvable.` });

  if (typeof req.body.estTerminee !== 'boolean') {
    return res.status(400).json({ message: 'Le champ "estTerminee" est requis et doit être un booléen.' });
  }

  tache.estTerminee = req.body.estTerminee;
  res.status(200).json(tache);
});

// Supprime une tâche de la liste
app.delete('/taches/:id', (req, res) => {
  const id = parseInt(req.params.id);
  const index = taches.findIndex(t => t.id === id);

  if (index === -1) return res.status(404).json({ message: `Tâche avec l'id ${id} introuvable.` });

  taches.splice(index, 1);
  res.status(204).send();
});

app.listen(PORT, () => {
  console.log(`Serveur démarré sur http://localhost:${PORT}`);
});
