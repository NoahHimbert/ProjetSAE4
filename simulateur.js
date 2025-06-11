// Récupère le corps du tableau HTML
const tableau = document.querySelector('#tableau tbody');

// Charge les données depuis le stockage local du navigateur (ou vide si rien)
let donnees = JSON.parse(localStorage.getItem('domomixData')) || [];

// Fonction pour ajouter une ligne au tableau HTML
function ajouterLigne(c, v, d) {
  const ligne = document.createElement('tr'); // crée une ligne de tableau
  ligne.innerHTML = `<td>${c}</td><td>${v}</td><td>${d}</td>`; // ajoute les 3 colonnes
  tableau.appendChild(ligne); // insère la ligne dans le tableau
}

// Fonction pour rafraîchir le tableau avec les données en mémoire
function majTableau(data) {
  tableau.innerHTML = ''; // vide le tableau
  data.forEach(d => ajouterLigne(d.capteur, d.valeur, d.date)); // ajoute chaque ligne
}

// Événement quand on soumet le formulaire
document.getElementById('formCapteur').addEventListener('submit', function(e) {
  e.preventDefault(); // empêche le rechargement de la page

  // Récupère les valeurs saisies dans les champs du formulaire
  const capteur = document.getElementById('capteur').value;
  const valeur = document.getElementById('valeur').value;
  const date = new Date().toLocaleString(); // génère la date actuelle

  // Ajoute la nouvelle donnée dans le tableau en mémoire
  donnees.push({ capteur, valeur, date });

  // Sauvegarde dans le stockage local du navigateur
  localStorage.setItem('domomixData', JSON.stringify(donnees));

  // Met à jour le tableau HTML avec les nouvelles données
  majTableau(donnees);

  // Réinitialise le formulaire
  this.reset();
});

// Fonction pour supprimer toutes les données
function viderDonnees() {
  if (confirm('Supprimer toutes les données ?')) {
    donnees = []; // vide le tableau mémoire
    localStorage.removeItem('domomixData'); // supprime le stockage local
    majTableau(donnees); // vide aussi l'affichage
  }
}

// Fonction pour filtrer les lignes par nom de capteur
function filtrerDonnees() {
  const filtre = document.getElementById('filtre').value;
  if (filtre === '') {
    majTableau(donnees); // si champ vide, affiche tout
  } else {
    const filtres = donnees.filter(d => d.capteur.includes(filtre)); // filtre
    majTableau(filtres); // affiche seulement les résultats filtrés
  }
}

// Fonction pour exporter les données au format CSV
function exporterCSV() {
  let csv = 'Capteur,Donnée,Date\n'; // en-tête du fichier
  donnees.forEach(d => {
    csv += `${d.capteur},${d.valeur},${d.date}\n`; // ajoute chaque ligne
  });

  // Crée un fichier téléchargeable à partir du texte CSV
  const blob = new Blob([csv], { type: 'text/csv' });
  const url = URL.createObjectURL(blob);

  // Simule un clic sur un lien de téléchargement
  const a = document.createElement('a');
  a.href = url;
  a.download = 'domomix_donnees.csv';
  a.click();

  // Nettoie l’URL générée
  URL.revokeObjectURL(url);
}

// Quand la page est chargée, on affiche les données déjà présentes
document.addEventListener('DOMContentLoaded', () => {
  majTableau(donnees);
});
