Projet 10 
Système de Réservation (Restaurant)


# Rapport
* doc/rapport.pdf
---

# Installation

## Prérequis

* PHP ^8.4
* MySQL 8 / MariaDB 10.11.15

## Démarrage du projet

* Installer les dépendances nécessaires avec :

```
composer install
```

* Renommer le fichier **.env.example** en **.env**, puis renseigner les informations de connexion à la base de données ainsi que la configuration SMTP pour l’envoi des e-mails.

* Importer la base de données **doc/reservation_restaurant.sql**.

## Lancement

- Local : [http://localhost/reservation_restaurant/](http://localhost/reservation_restaurant/)
- Démo En ligne: [http://bouskif.dwm.ma/](http://bouskif.dwm.ma/)

## Espace administrateur

Identifiants :

* **Nom d’utilisateur** : admin
* **Mot de passe** : 123456
