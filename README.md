# Informations générales

## Titre

Le projet se nomme ProjetWikiCampers

## Description

Le site généré respecte tous les attendus du cahier des charges.
En effet, il permet:
- la création/modification/suppression de véhicule.
- la création/modification/suppression de disponibilités (affectées aux véhicules).
- la recherche des véhicules disponibles selon une période donnée et dans le budget défini.
- Si aucun véhicule n'est disponible, la recherche s'élargit à +/- 1 jour de la période initiale.

# Installation

Procédure:
- Télécharger le dossier "ProjetWikiCampers" et sauvegarder le sous votre htdocs de votre serveur
- Lancer votre MySQL
- Ouvrir le fichier ProjetWikiCampers dans votre éditeur de code et lancer dans un terminal les commandes :

```
composer install
```

```
php -S localhost:8000 -t public
```

```
php bin/console doctrine:migrations:migrate
```

- Vous pourrez ainsi y avoir accès dans votre navigateur dans en saisissant l'url `http://localhost:8000/`

# Utilisation

Le site est composé de 4 pages:
- La page d'accueil
- La page de recherche de véhicules
- La page de gestion des véhicules
- La page de gestion des disponibilités

## La page d'accueil

Sur cette page, vous pourrez ainsi être redirigé selon vos besoins: location ou mise en location, vers les pages correspondantes.

## La page de recherche de véhicule

- Est composée d'un formulaire de recherche (3 champs: Date de départ / Date de retour / Prix maximum)

- Une fois le formulaire soumis, vous êtes redirigé vers les résultats de votre recherche.

- Les résulats vous affichent différentes informations sur les véhicules disponibles: La marque / Le modèle / Le prix total de la location

- Si aucun véhicule n'est disponible, les champs "date de départ", "date de retour" s'élargissent à +/- 1 jour, afin de pouvoir vous proposer d'autres véhicules disponibles.

- Si toujours aucun véhicule n'est disponible, un message vous en informent.

## La page de gestion de véhicule

est composée de:
- un bouton qui vous redirige vers un formulaire d'ajout de véhicule dans lequel vous sont demandés les champs suivants: L'immatriculation, la marque, et le modèle (sachant qu'il n'est pas possible de saisir l'immatriculation d'un véhicule déjà existant)
- un tableau, qui affiche tous les véhicules présents dans la base de données, en ne prenant que les champs suivants: L'immatriculation / Le modèle et la marque

Dans ce tableau il vous est aussi proposé pour chaque véhicule de: les modifier, les supprimer, ou bien de leur ajouter une disponilibité.
- Si vous cliquez sur le bouton de modification, vous êtes dirigé vers un formulaire vous affichant les champs de votre véhicule que vous pouvez modifier
- Si vous cliquez sur le bouton de suppression, le véhicule est immédiatement supprimé.
- Si vous cliquez sur le bouton d'ajout de disponibilité, vous êtes redirigé vers un formulaire dont les champs des disponibilités à saisir sont: la date de début / la date de fin / le prix journalier, une fois soumis la disponibilité sera créée et affectée au véhicule

## La page de gestion des disponibilités

Est composée d'un tableau qui vous affichent la totalité des disponibilités présentent dans la base de données (avec une pagination de 10/page).
Les champs affichés dans ce tableau sont:
- l'immatriculation du véhicule concerné
- la date de début
- la date de fin
- la prix journalier

Il vous est également possible de modifier ou supprimer une disponibilité.
- Si vous cliquez sur le bouton de modification, vous êtes dirigé vers un formulaire vous affichant les champs de votre disponibilité que vous pouvez modifier.
- Si vous cliquez sur le bouton de suppression, la disponibilité est immédiatement supprimé.

Dans le cas où vous souhaitez rajouter une nouvelle disponibilité, il vous faut revenir sur la page de gestion des véhicules.

# Limites du projet

Au vu de la structure du code, les problèmes suivants sont à résoudre.
- La recherche de véhicule ne fonctionnera dans le cas suivants:
Si deux disponibilités sont définies sur un même véhicule. Par ex: la première du 10/06 au 15/06 pour 10€/jr, et la suivante du 16 au 20/06 pour 20€/jr.
La recherche de véhicule du 12/06 au 17/06 n'affichera pas le véhicule disponible, étant donné que les périodes de recherche doivent être comprises dans une période de disponibilité.

# Structure du projet

- 2 entités :
    - Disponibilité (id / date de début / date de fin / prix journalier / id du véhicule attribué / Statut de la disponibilité)
    - Véhicule (id / modèle / marque / immatriculation)
- 4 Controllers : un pour la gestion de chaque page
- 2 forms : un pour chaque entité
- les templates :
    - Un sous dossier Disponibilité: Page d'accueil des disponibilités  / Page de modification
    - Un sous dossier Location : Page de formulaire / Page de résultat
    - Un sous dossier Vehicule : Page d'accueil des véhicueles / Formulaire d'ajout / Formulaire de modification / Formulaire d'ajout de disponibilité
    - un sous dossier avec les éléments communs à chaque : le header
    - La page d'accueil
- un README

# Contact

Si besoin, vous pouvez me joindre aux coordonnées suivantes:
- Tel : 06 74 96 98 27
- Mail : loiseau.julien79@gmail.com