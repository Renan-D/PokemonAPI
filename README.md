# Mini projet tutorial PHP Symfony & API Platform

## Introduction

Bonjour et bienvenue sur un mini tutorial pour apprendre les bases de PHP Symfony et construire une API à l'aide d'API Platform

Dans ce tutorial, vous avez accès à une structure initiale du projet PokemonAPI avec des exemples de code contenant les entités Pokemon et Move. 

Notions retrouvés dans le code :
- Entité (Pokemon & Move)
- Repository (PokemonRepository)
- CRUD (Get - Post - Put/Patch - Delete) : A notez qu'en théorie le PUT doit remplacer toutes les données d'une instance alors que le PATCH remplace partiellement les données d'une instance
- Processor / Provider / Controller (CountPokemonController, ReverseOrderPokemonProvider, CreatePokemonProcessor)
- Service (PokemonService)
- Contrainte de validation (Assert\Range, Assert\Count, Assert\NotBlank, Assert\All, Assert\Choice ...)
- Authentification JWT (
- Filter avec API Platform pour une route non custom (Disponible dans l'entité Move)
- Filter avec Doctrine pour une route custom (PokemonRepository)

A partir de ce code, vous ouvez maintenant 
- Compléter l'entité Move et pourquoi pas différencier les CT des CS (TM & HM en anglais)
- Ajouter des entités comme Trainer 
- Ajouter des contraintes de validation
- Ajouter des routes personnalisées
- Ajouter des champs dans les entités
- Accepter les générations supérieures à la première (Il faudra changer la contrainte de validation de nationalNumber dans l'entité Pokemon et faire attention avec le service CreatePokemonProcessor qui ne fonctionne que pour les Pokemon 1ere gen)
...

## Données

Vous avez un fichier SQL dans le dossier sql pour insérer quelques pokemons de test dans votre base de données. 

## Prérequis

### Installer composer 

https://getcomposer.org/download/

Puis entrer cette commande à la racine du projet
```bash
$ composer install
```

### Installation XAMPP

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

# Tutorial Symfony & API Platform : Fondamentaux et utilisation pratique (issu de mon rapport d'alternance)

## Introduction au développement backend avec PHP Symfony et API Platform

Symfony est un framework web PHP open-source, reconnu pour sa robustesse, sa modularité et sa facilité de développement. Il offre une architecture MVC (Modèle-Vue-Contrôleur) ainsi qu'une multitude de composants réutilisables, facilitant la création d'applications web évolutives et performantes.



Cependant, lors de l'utilisation de Symfony pour développer une API avec API Platform, seuls le Modèle et le Contrôleur sont utilisés, la partie Vue étant réservée au framework front-end. Dans une application Symfony fullstack, la vue serait les twig HTML.

API Platform est un ensemble d'outils open-source destinés à simplifier le développement d’API web RESTful. Son utilisation facilite la création, la publication, et la gestion d'API web performantes et évolutives, offrant des fonctionnalités telles que la documentation automatique, la validation des données, l'authentification, l'autorisation, et bien plus encore. Elle permet aux développeurs de se concentrer sur la logique métier de leurs applications plutôt que sur les détails de mise en œuvre des API, accélérant ainsi le processus de développement.

Les services RESTful sont basés sur certaines caractéristiques :
- Stateless (sans état) : Chaque requête du client vers le serveur doit contenir toutes les informations nécessaires pour comprendre et traiter la requête. Le serveur ne conserve pas d'état des sessions client entre les requêtes.
- Ressources : Les services RESTful sont centrés sur les ressources, qui représentent les entités manipulées par l'application. Les ressources sont identifiées par des URI (Uniform Resource Identifiers).
- Actions HTTP : Les opérations sur les ressources sont effectuées à l'aide des méthodes standard HTTP, telles que les fonctions de base du stockage persistant appelé CRUD :
    - POST : Create → Création de données
    - GET : Read → Récupération des données
    - PUT / PATCH : Update → Modification des données
    - DELETE : Delete → Suppression des données
- Représentations : Les ressources peuvent avoir différentes représentations, telles que JSON, XML, HTML, etc. Le format JSON est le plus utilisé et le plus populaire pour représenter les données.

## La place de PHP et de Symfony dans le monde de l’informatique

À présent que nous avons exploré les fondements du framework Symfony, il est pertinent d'analyser la position de PHP et de Symfony dans le monde de l'informatique actuel.

PHP est l'un des langages de programmation les plus utilisés pour le développement web, avec une part de marché significative. Selon les statistiques, environ 77,5% des sites web dans le monde sont développés en PHP, soulignant ainsi son importance dans l'écosystème du web. Il faut tout de même préciser que PHP doit ce palmarès à son historique. En effet, historiquement, PHP est l’un des premiers outils de développement web gratuit, open-source et accessible. De plus, cette popularité n’est pas tellement surprenante lorsque l’on sait que WordPress, le CMS le plus populaire sur le web est écrit en PHP et qu’il équipe plus de 40% des sites Web.

Symfony fait encore partie des 15 frameworks backend les plus populaires sur la plateforme Github en 2023, et Laravel, un autre framework PHP inspiré de Symfony, se classe parmi les trois premiers.

Remarque : En général, on observe une tendance à la hausse des bibliothèques et frameworks JavaScript dans le backend, ce qui s'explique par la polyvalence du langage JavaScript permettant de créer des applications fullstack avec un seul langage. L'apparition de TypeScript, offrant une meilleure robustesse, ou encore les nouveaux créateurs de contenus modernes qui produisent beaucoup de contenus sur les frameworks JavaScript, contribuent également à cette tendance.

On observe alors que PHP et ses frameworks sont de moins en moins privilégiés par les développeurs, ce qui met en question leur popularité et leur utilisation à l'avenir. Cette tendance est perceptible sur des plateformes telles que LinkedIn, YouTube, ainsi que dans les fiches de poste. En effet, de nombreux développeurs préfèrent désormais s'orienter vers des technologies JavaScript et TypeScript, souvent perçues comme plus modernes et polyvalentes. Cependant, de mon point de vue, il y beaucoup de développeurs qui suivent seulement ces tendances et critiquent les framework PHP sans en avoir réellement connaissance.

En conclusion, il est raisonnable d'affirmer que Symfony est l’un des framework backend les plus populaires parmi plusieurs centaines, voire des milliers de frameworks backend disponibles. Cela démontre la confiance accordée à Symfony par la communauté des développeurs et sa popularité certaine dans l'industrie du développement web. Ainsi, PHP et Symfony continuent de jouer un rôle majeur dans le développement web, offrant aux développeurs des outils puissants et des frameworks robustes pour créer des applications web modernes et performantes.


# Tutoriel technique - Construire une API Pokémon avec PHP Symfony & API Platform

Ce tutoriel vous guidera à travers les étapes initiales pour configurer, lancer un projet et commencer le développement d’une API avec Symfony et API Platform. Le projet Pokémon est disponible à l'adresse suivante : https://github.com/Renan-D/PokemonAPI . Le README du projet couvre les prérequis et inclut quelques bonus. Vous y trouverez également suffisamment d'exemples de code pour pouvoir vous en inspirer en complétant ce projet ou en créant un nouveau projet.

Prérequis :
- PHP 8.2+
- Composer
- XAMPP : Apache - MySQL - PHP - phpMyAdmin

## Installation et configuration du framework Symfony

### Étape 1 : Installation de Symfony CLI

Symfony CLI (Command Line Interface) est un outil puissant conçu pour faciliter le développement et la gestion des projets Symfony.

#### Windows

```bash
$ Set-ExecutionPolicy RemoteSigned -scope CurrentUser
$ iex (new-object net.webclient).downloadstring('https://get.scoop.sh')
```

Cette commande permet à l'utilisateur actuel d'exécuter des scripts téléchargés depuis Internet, à condition qu'ils soient signés, tout en permettant l'exécution de scripts locaux non signés. Puis elle télécharge le script d'installation de Scoop et l'exécute immédiatement.

```bash
$ scoop install symfony-cli
```

Cette commande télécharge Symfony CLI

#### Linux

```bash
$ curl -sS https://get.symfony.com/cli/installer | bash
$ echo 'export PATH="$HOME/.symfony5/bin:$PATH"' >> ~/.bashrc
$ source ~/.bashrc
```

Cette commande permet d’installer et d’ajouter Symfony CLI au PATH pour pouvoir utiliser Symfony CLI globalement dans votre terminal

```bash
$ symfony check:requirements
```

Cette commande permet de vérifier que symfony CLI est correctement installé et si votre ordinateur répond à tous les prérequis pour commencer un projet symfony.

### Étape 2 : Créer un projet (API) Symfony

```bash
$ symfony new PokemonAPI --version="7.1.*"
$ composer require api
```

Cette commande permet de créer un projet Symfony 7+ dans le cas d’une API. La deuxième commande permet d’installer les dépendances d’API Platform.

```bash
$ cd PokemonAPI/
$ symfony server:start
```

Cette commande permet de lancer le serveur, par défaut vous pouvez accéder à votre application avec cette adresse : https://localhost:8000


### Étape 3 :  Installer un ORM : Doctrine & création de la base de données

```bash
$ composer require symfony/orm-pack
$ composer require --dev symfony/maker-bundle
```

Ces commandes permettent d’installer l’ORM Doctrine. C’est un outil puissant utilisé pour la gestion de bases de données dans les applications PHP.

### Fichier .env
```yaml
DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/PokemonAPI?serverVersion=5.7"
```

Dans votre fichier .env, gardez uniquement la ligne de DATABASE_URL correspondant à MySQL, pensez à modifier db_user par votre username et db_password par votre mot de passe. Par défaut le db_user est root et il n’y a pas de mot de passe.

```bash
$ php bin/console doctrine:database:create
```

Lancer cette commande pour créer votre database PokemonAPI. Vous pouvez lancer le serveur et phpMyAdmin (ou n’importe quel autre outil de gestion de base de données) pour voir apparaître votre base de données PokemonAPI.

## Création et gestion des entités de base de données

Une entité est une classe PHP qui représente une table dans une base de données. Chaque instance de cette classe correspond à une ligne (ou un enregistrement) dans cette table.

### Cas concret
Pour mon API Pokémon, je vais créer une entité Pokemon et une entité Move (les attaques). Avec la puissance de l’ORM, il suffit de répondre à quelques questions pour générer les tables dans la base de données. Doctrine se chargera alors de construire automatiquement le code de base, incluant une entité et un repository.

Nous devrons alors lier ces deux entités à l’aide du type relation. Il existe plusieurs relations possibles :
- ManyToOne : Plusieurs entités peuvent appartenir à une seule entité.
- ManyToMany : Plusieurs entités peuvent être liées à plusieurs autres entités.
- OneToOne : Une entité est associée à une seule autre entité.
- OneToMany : Une entité est associée à plusieurs autres entités.

```bash
$ php bin/console make:entity
```

Cette commande permet de créer une entité.

```bash
$ php bin/console make:entity

Class name of the entity to create or update:
> Pokemon

New property name (press <return> to stop adding fields):
> name

Field type (enter ? to see all types) [string]:
> string

Field length [255]:
> 255

Can this field be null in the database (nullable) (yes/no) [no]:
> no

New property name (press <return> to stop adding fields):
>
(press enter again to finish)

# Faites la même chose avec tous les champs de l’entité (level, types …)
```

```bash
$ php bin/console make:entity

Class name of the entity to create or update:
> Move

New property name (press <return> to stop adding fields):
> pokemons

Field type (enter ? to see all types) [string]:
> relation

What class should this entity be related to?:
> Pokemon

Relation type? [ManyToOne, OneToMany, ManyToMany, OneToOne]:
> ManyToMany
# Car un pokémon peut avoir plusieurs Moves et un Move peut être appris par plusieurs pokémon

Is the Move.pokemons property allowed to be null (nullable)? (yes/no) [yes]:
> yes

Do you want to add a new property to Pokemon so that you can access/update
Move objects from it - e.g. $pokemon->getMoves()? (yes/no) [yes]:
> yes

New field name inside Category [Moves]:
> moves

Do you want to automatically delete orphaned App\Entity\Move objects
(orphanRemoval)? (yes/no) [no]:
> no

New property name (press <return> to stop adding fields): (press enter again to finish)
# Faites la même chose avec tous les champs de l’entité (name, power, type…)
```

Après avoir créé une ou plusieurs entités, il est crucial de persister les modifications dans la base de données :

```bash
$ php bin/console make:migration
$ php bin/console doctrine:migrations:migrate
```

Cette 1ere commande est utilisée pour générer une nouvelle migration basée sur les modifications apportées à vos entités. Lorsque vous créez ou modifiez une entité, vous devez créer une migration pour refléter ces changements dans votre base de données. La migration contient les instructions SQL nécessaires pour mettre à jour la structure de la base de données.

Cette 2eme commande exécute toutes les migrations qui n'ont pas encore été exécutées dans votre base de données. Elle applique les modifications définies dans les migrations à la base de données, ce qui garantit que votre schéma de base de données est synchronisé avec vos entités.

```bash
$ php bin/console doctrine:schema:update --force
```

Cette commande est une alternative à l'utilisation de migrations. Elle met à jour directement la structure de votre base de données en fonction des métadonnées de vos entités. Cependant, son utilisation est déconseillée en production car elle peut entraîner la perte de données si des modifications sont apportées à la base de données sans passer par des migrations. N’utilisez cette commande qu’en phase de développement à la place des deux commandes ci-dessus si vous ne souhaitez pas faire de migrations.

## Création des routes API

Les routes API sont des points d'entrée définis dans une application web qui permettent à des clients (comme des applications front-end, des services tiers, ou même d'autres back-end) d'interagir avec le serveur en envoyant des requêtes HTTP et en recevant des réponses. Ces routes sont essentielles pour structurer l'API et définir comment les différentes fonctionnalités de l'application peuvent être accédées. Elles représentent les actions HTTP des services API RESTful.

### Routes non personnalisées

Pour définir des routes non personnalisées, nous utilisons des annotations dans nos classes d'entité, telles que l'exemple pour la classe Pokemon ci-dessous :

```php
#[ApiResource(
operations: [
new Get(
uriTemplate: '/{id}',
requirements: ['id' => '\d+'],
),
new GetCollection(
uriTemplate: '/',
),
new Patch(
uriTemplate: '/{id}',
requirements: ['id' => '\d+'],
),

       new Post(
           uriTemplate: '',
       )
],
routePrefix: '/pokemons',
normalizationContext: ["groups" => ["pokemons_read"]],
denormalizationContext: ["groups" => ["pokemons_write"]]
)]

class Pokemon {
...

// On veillera également à définir le contexte de normalisation ou de dénormalisation pour chaque champ
#[Groups(["pokemons_read", "pokemons_write"])]
private ?string $name = null;

...

}
```


Pour tester ces routes, vous pouvez utiliser des outils comme Postman en accédant aux URL correspondantes à vos routes, par exemple, /api/pokemons pour obtenir la liste des Pokémons.

Note 1 : Le /api est le préfixe par défaut dans la configuration des routes qu’on peut retrouver dans le fichier config/routes/api_platform.yaml

Note 2 : normalizationContext et denormalizationContext permettent de personnaliser la façon dont les données sont sérialisées et désérialisées lors des interactions avec l'API, offrant ainsi une flexibilité et un contrôle accrus sur le processus de transformation des données. Par exemple, en mettant #[Groups(["pokemons_read"])] sur le champs name, on autorise le champs name à être récupérer via la route GET et en mettant #[Groups(["pokemons_write"])] on autorise le champs name à être modifié ou créé avec les routes POST et PATCH dans l’exemple.

On pourrait également définir un normalizationContext ou un denormalizationContext spécifique à une seule action HTTP pour éviter de le mettre par défaut sur tous les champs :

```php
new Patch(
uriTemplate: '/{id}',
requirements: ['id' => '\d+'],
denormalizationContext: ["groups" => ["pokemons_patch"]]
),

...


#[Groups(["pokemons_read", "pokemons_write"])]
private ?string $name = null;
```

Dans cet exemple, le name ne sera pas modifiée lors d’un PATCH même si on met un nouveau name dans le body de la requête. Il faudrait ajouter le groups “pokemons_patch” pour que ce soit le cas.

### Routes personnalisées

Dans le cas où des interactions spécifiques sont nécessaires entre la réception de la requête HTTP et la génération de la réponse, nous pouvons créer des routes personnalisées à l'aide de contrôleurs (controller), de fournisseurs de données (provider) ou de processeurs de données (processor).

#### Contrôleur

```php
// Classe Entity/Pokemon.php

new Get(
uriTemplate: '/count',
controller: countPokemonController::class,
read: false // Empêche de récupérer automatiquement l'entité à partir de la base de données, permettant ainsi d'exécuter des contrôleurs personnalisés pour des tâches spécifiques.
),
```

```php
// Classe Controller/CountPokemonController.php
<?php

namespace App\Controller;

use App\Repository\PokemonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class CountPokemonController extends AbstractController
{
    public function __construct(private readonly PokemonRepository $pokemonRepository)
    {
    }

    public function __invoke(): JsonResponse
    {
        return $this->json(['count' => $this->pokemonRepository->count()]); // On note que plusieurs fonctions du  
                                                                               repository sont accessibles par défaut
    }
}
```



Ce contrôleur permet de récupérer le nombre total de pokemon enregistrer dans la base de données. On utilise un contrôleur plutôt qu’un fournisseur de données car la réponse n’est pas une instance de pokémon ou une liste de pokemon, ici les données des pokémons enregistrées en base de données ne sont pas utiles à la réponse.

#### Fournisseur de données (provider)

```php
// Classe Entity/Pokemon.php

 new GetCollection(
        uriTemplate: '/',
        provider: ReverseOrderPokemonProvider::class
       ),
```

```php
// Classe State/Provider/ReverseOrderPokemonProvider.php
<?php

namespace App\State\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Repository\PokemonRepository;

class ReverseOrderPokemonProvider extends ProviderInterface
{
    public function __construct(private readonly PokemonRepository $pokemonRepository)
    {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        return $this->pokemonRepository->findBy([], ['nationalNumber' => 'DESC']);
    }
}
```

Ce fournisseur de données permet de récupérer la collection de Pokémon dans l'ordre décroissant de leur numéro national.

Note : C’est aussi possible de trier une collection avec la propriété order de la librairie (bibliothèque) API Platform mais c’était juste pour faire un exemple simple du fournisseur de données.

```php
#[ApiResource(
   ...

   denormalizationContext: ["groups" => ["pokemons_write"]],
   order: ["nationalNumber" => "ASC"]
)]

class Pokemon {
...
}
```


#### Processeur de données (processor)

```php
// Classe Entity/Pokemon.php

 new Post(
           uriTemplate: '/',
           processor: CreatePokemonProcessor::class,
       ),
       
       ...

  #[ORM\Column(type: Types::TEXT, nullable: true)]
  #[Groups(["pokemons_read"])] // J’enlève le pokemon_write car je n’ai pas besoin que l’utilisateur me fournit l’URL de l’image,    je peux la générer automatiquement grâce au nationalNumero avec un processeur
  private ?string $sprite = null;
```

```php
// Classe State/Processor/CreatePokemonProcessor.php

<?php

namespace App\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Pokemon;
use Doctrine\ORM\EntityManagerInterface;

class CreatePokemonProcessor implements ProcessorInterface
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }


    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        /** @var Pokemon $data */ // Permet d'avoir de l'autocomplétion sur l'entité Pokemon

        $data->setCurrentHP($data->getMaxHP());

        $formattedNumero = sprintf('%03d', $data->getNationalNumber());
        $data->setSprite("https://assets.pokemon.com/assets/cms2/img/pokedex/full/$formattedNumero.png");

        $this->entityManager->persist($data);
        $this->entityManager->flush();

        return $data;
    }
}
```

Ce processeur de données permet de compléter automatiquement l’instance de pokémon qui est créée. Grâce à ce processeur, l’utilisateur n’a pas à donner le champ currentHP, puisque nous savons qu’à la création ce champ est égal au champ maxHP du pokémon. Ce processeur évite également à l’utilisateur de devoir fournir l’URL du sprite (une image) du pokémon car comme nous connaissons déjà un site internet qui fournit les images en fonction du numéro national du pokémon, nous pouvons générer automatiquement le lien avec le nationalNumber que l’utilisateur fournit. 

## Les contraintes de validation

```bash
$ composer require symfony/validator
```

Cette commande permet d’installer la librairie pour effectuer des contraintes de validation. 

Les contraintes de validation sont des règles que vous appliquez aux propriétés d'une entité pour garantir que les données respectent certaines conditions avant d'être traitées ou stockées. Elles assurent l'intégrité des données et aident à prévenir les erreurs en amont.  Il existe beaucoup de contraintes de validation différente, de la validation d’email en passant par la longueur d’une chaîne de caractère. 

Voici deux exemples : 

```php
#[Assert\Range(notInRangeMessage: "Only 1st generation pokemon 1-151", min: 1, max: 151)]
private ?int $nationalNumber = null;
```

Cette contrainte de validation permet de n’accepter que nationalNumber compris entre 1 et 151 à la création ou à la modification. 

```php
#[Assert\Count(min: 1, max: 2)]
#[Assert\NotBlank]
#[Assert\All([
   new Assert\Choice(['choices' => ['Fire', 'Water', 'Grass', 'Electric', 'Ice', 'Fighting', 'Poison', 'Ground', 'Flying', 'Psychic', 'Bug', 'Rock', 'Ghost', 'Dragon', 'Dark', 'Steel']], 
message: "Invalid type, types must be Fire, Water, Grass, Electric, Ice, Fighting, Poison, Ground, Flying, Psychic, Bug, Rock, Ghost, Dragon, Dark, Steel"),
])]
private array $types = [];
```

Ces contraintes de validation permettent : 
- De n’accepter que 1 ou 2 types à l’intérieur du tableau
- De ne pas accepter de tableau vide
- De n’accepter que les types existants et définis à l’intérieur de la contrainte de validation


## L’authentification

Actuellement, toute personne peut accéder à notre API. Cependant, nous pouvons envisager désormais de rendre les routes GET accessibles au public, tandis que la création et la modification des Pokémons seront réservées aux utilisateurs connectés.

```bash
$ composer require symfony/security-bundle
$ composer require "lexik/jwt-authentication-bundle" --ignore-platform-reqs
```

Ces commandes permettent d’installer les librairies pour mettre en place l’authentification sécurisée sur Symfony. 

```bash
$ scoop install openssl  
$ bin/console lexik:jwt:generate-keypair
```

Cette commande permet d’installer openssl nécessaire afin de  générer une paire de clés JWT utilisée pour l'authentification JWT dans l’application. 

```bash
$ php bin/console make:user
 The name of the security user class (e.g. User) [User]:
 > User

 Do you want to store user data in the database (via Doctrine)? (yes/no) [yes]:
 > yes

 Enter a property name that will be the unique "display" name for the user (e.g. email, username, uuid) [email]:
 > email

 Does this app need to hash/check user passwords? (yes/no) [yes]:
 > yes

 created: src/Entity/User.php
 created: src/Repository/UserRepository.php
 updated: src/Entity/User.php
 updated: config/packages/security.yaml
```

Cette commande permet de créer notre entité User (utilisateur). 

```yaml
...

firewalls:
   api:
       pattern: ^/api
       stateless: true
       provider: app_user_provider
       json_login:
           check_path: /api/login_check
           success_handler: lexik_jwt_authentication.handler.authentication_success
           failure_handler: lexik_jwt_authentication.handler.authentication_failure
       entry_point: jwt
       jwt: ~
...

access_control:
   - { path: ^/api, roles: PUBLIC_ACCESS }

role_hierarchy:
   ROLE_ADMIN: ROLE_USER
```

```yaml
# config/routes.yaml

api_login_check:
   path: /api/login_check
```

```txt
# .env
###> lexik/jwt-authentication-bundle ###
JWT_SECRET_KEY=%kernel.project_dir%/config/jwt/private.pem
JWT_PUBLIC_KEY=%kernel.project_dir%/config/jwt/public.pem
JWT_PASSPHRASE=890c371b1b9678a5e1552c246efbf8d946985bccdd3b21fd6ab35911a8b52375
###< lexik/jwt-authentication-bundle ###
```

```php
// src/Validator/ValidateRole.php

<?php
namespace App\Validator;
use Symfony\Component\Validator\Constraint;

#[\Attribute]
class ValidateRole extends Constraint
{
    public string $message = 'One of the roles entered is incorrect.';
    public string $mode = 'strict';
}
```

```php
// src/Validator/ValidateRoleValidator.php

<?php
namespace App\Validator;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class ValidateRoleValidator extends ConstraintValidator
{
    const ROLES = ['ROLE_ADMIN', 'ROLE_USER'];

    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof ValidateRole) {
            throw new UnexpectedTypeException($constraint, ValidateRole::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!is_array($value)) {
            throw new UnexpectedValueException($value, 'array');
        }

        foreach ($value as $role) {
            if (!in_array($role, self::ROLES)) {
                $this->context->buildViolation($constraint->message)
                    ->setCode('MET_UN_CODE_RANDOM')
                    ->addViolation();
            }
        }
    }
}
```
Ces deux classes : src/Validator/ValidateRoleValidator.php et  src/Validator/ValidateRoleValidator.php sont nécessaires pour déterminer les différents rôles possibles pour les utilisateurs. 


```php
#[ApiResource(
   operations: [
       ...
       new Patch(
           uriTemplate: '/{id}',
           requirements: ['id' => '\d+'],
           security: 'is_granted(“ROLE_ADMIN”) === true',
       ),
       new Post(
           uriTemplate: '',
           security: 'is_granted(“ROLE_USER”) === true',
           processor: CreatePokemonProcessor::class
       )
   ],
 ...
```
On peut maintenant ajouter l’attribut security pour permettre uniquement aux utilisateurs connectés et ayant le bon rôle d’effectuer certaines actions.

```php
// State/Processor/UserProcessor.php
<?php

namespace App\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserProcessor implements ProcessorInterface
{

    public function __construct(private readonly EntityManagerInterface $entityManager, 
                                private readonly UserPasswordHasherInterface $hasher)
    {
    }
    
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        /** @var User $data */

        $password = $data->getPassword();
        $data->setPassword($this->hasher->hashPassword($data, $password));

        $this->entityManager->persist($data);
        $this->entityManager->flush();

        return $data;
    }
}
```

On doit également créer un processeur pour la requête POST de user afin de hasher le mot de passe pour le stocker en base de données.


On peut maintenant se connecter avec la route login_check avec nos identifiants afin de recevoir un token 



Pour tester nos routes nécessitant une authentification, il faut mettre le token reçu à la connexion dans l’onglet “Authorization” en sélection Bearer Token. 
Dans une application web avec une interface utilisateur, c'est généralement le développeur frontend qui gère la gestion des tokens JWT. Après l'authentification réussie de l'utilisateur, le frontend reçoit un token JWT de l'API backend et le stocke localement, souvent dans le stockage local du navigateur ou dans un cookie sécurisé. Ensuite, à chaque requête nécessitant une authentification, le frontend inclura automatiquement ce token JWT dans l'en-tête "Authorization" de la requête HTTP. Cela garantit que l'utilisateur reste authentifié et peut accéder aux fonctionnalités restreintes de l'application.

© 2024 Tous droits réservés - DECLERCQ Renan
