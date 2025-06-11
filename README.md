# Domomix - Supervision Domotique en PHP

Projet réalisé dans le cadre de la SAE4 - BUT GEII  
Encadrant : M. Pierrick Tasse  
Auteur : Noah Himbert Tom CHAUVIERE Elouan EHANNO

---

## Objectif du projet

Ce projet simule un système domotique de supervision de capteurs EnOcean, avec une interface web réalisée en PHP.  
Il remplit les objectifs suivants :

- Formulaire de **connexion simulé** via un script
- Réception de données capteurs simulée (via formulaire ou URL)
- Affichage dynamique sous forme de tableau
- **Filtrage par capteur**
- **Réinitialisation des données**
- **Export CSV** des données reçues
- Fonctionnement 100 % local sans base MySQL (utilise fichier `.csv`)

---

## Structure des fichiers

```
serveur/
├── main.php        # Application principale (formulaire + tableau)
├── donnees.csv     # Fichier généré automatiquement (base de données simulée)
├── README.md       # Ce fichier
```

---

## Lancer le projet en local (avec PHP installé)

1. Ouvre un terminal dans le dossier `serveur/`
2. Lance le serveur intégré PHP :

```bash
php -S localhost:8000
```

3. Ouvre dans ton navigateur :  
 `http://localhost:8000/main.php`

---

## Utilisation

- Saisir un ID de capteur et une valeur, cliquer sur **Envoyer**
- Les données s’affichent automatiquement dans le tableau
- Utiliser le champ **filtre** pour voir les valeurs d’un capteur spécifique
- Cliquer sur **"Vider les données"** pour tout supprimer
- Cliquer sur **"Exporter en CSV"** pour télécharger les données

---

## Lien avec les consignes du prof

>  Simulation d’un système domotique via une page web  
>  Interface de saisie et de lecture des données capteurs  
>  Traitement des paramètres `?idCapteur=XX&donnee=YY` simulé via formulaire  
>  Enregistrement dans une “table capteur” simulée (CSV)

---

## Compatible avec Replit, VS Code, ou serveur Apache/PHP
