# Mini projet tutorial PHP Symfony & API Platform

## Introduction

Bonjour et bienvenue sur un mini tutorial pour apprendre les bases de PHP Symfony et construire une API à l'aide d'API Platform

Dans ce tutorial, vous avez accès au début du code du projet PokemonAPI contenant les entités Pokemon et Move. 
Ce début de projet vous donnera quelques exemples dont vous pourrez vous inspirer pour écrire la suite de cette API si vous le souhaitez.

Notions abordés :
- Entité
- Repository
- CRUD (Get - Post - Put/Patch - Delete) : A notez qu'en théorie le PUT doit remplacer toutes les données d'une instance alors que le PATCH remplace partiellement les données d'une instance
- Processor / Provider / Controler
- Contrainte de validation
- Authentification

A vous de compléter cette API avec par exemple 
- Une entité Trainer 
- Une entité Battle
- Une entité Item

## Installation XAMPP

Installer XAMPP https://www.apachefriends.org/download.html.

Configurez vos variables d'environnements pour mettre xampp/php dans votre path.

Ouvrez le panel et appuyer sur les boutons Start pour Apache et MySQL. Vous pouvez également ouvrir l'admin de MySQL, cela ouvrira directement phpMyAdmin

Par défaut le login est root et il n'y a pas de mot de passe, ce qui explique cette ligne dans le fichier .env : 

```
#.env
DATABASE_URL="mysql://root:@127.0.0.1:3306/PokemonAPI?serverVersion=8.0.32&charset=utf8mb4"
```

## Fichier de configuration

### config/packages/api_platform.yaml

Ajouter le format json 

```yaml
api_platform:
  title: Hello API Platform
  version: 1.0.0
  formats:
    jsonld: ['application/ld+json']
    json: ['application/json']
  docs_formats:
    jsonld: ['application/ld+json']
    jsonopenapi: ['application/vnd.openapi+json']
    html: ['text/html']
  defaults:
    stateless: true
    cache_headers:
      vary: ['Content-Type', 'Authorization', 'Origin']
    extra_properties:
      standard_put: true
      rfc_7807_compliant_errors: true
  keep_legacy_inflector: false
  use_symfony_listeners: true
```


© 2024 Tous droits réservés - DECLERCQ Renan

Ability
Sprite
height
weight
name

HM = hidden machine: CS
TM = technical machine : CT
