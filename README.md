# README – Projet MVC Mihoyo Collection

## 1. Description du projet
Ce projet est une application web PHP permettant de gérer une collection de personnages Mihoyo.  
Il utilise une architecture MVC, un routeur personnalisé, un système d’authentification, des services métier, des DAO via PDO, et un journal de logs.


## 2. Configuration

Un fichier de configuration d'exemple est fourni :

 Config/dev_sample.ini

 
Contenu :

```ini
;config dev
[DB]
dsn = 'mysql:host=localhost;dbname=YOURDBNAME;charset=utf8';
user = 'YOUR_USERNAME';
pass = 'YOUR_PASSWORD';
```

Ensuite importer le script SQL le fichier ce nomme 127_0_0_1.sql


-> Comptes de test

Pour se connecter à l'application :

Identifiant	Mot de passe :

test	test

admin	admin