# PHPUpsud

PHP U-PSUD est un set de composants écrits en PHP (PHP 5.3+) facilitant l'utilisation de ressources mises
à disposition des étudiants par l'Université Paris-Sud (11) pour le développement de sites internet.

## Installation

L'installation est très simple car PHPUpsud ne nécessite aucune dépendance.

### Téléchargement

Il y a deux méthodes de téléchargement :

1. **Fichier ZIP**
   Téléchargez le fichier ZIP de la librairie : https://github.com/tgalopin/phpupsud/archive/master.zip
   Puis extrayez ce fichier dans votre application

2. **Git**
   Lancez la commande `git clone https://github.com/tgalopin/phpupsud` dans votre applciation
   
   
### Mise en place

Une fois téléchargée, la librairie ne nécessite que l'inclusion de son fichier `src/autoload.php` pour
fonctionner :

``` php
<?php

require '/path/to/phpupsud/src/autoload.php';
```

## Utilisation

### Exemple simple d'utilisation : connexion à CAS et récupération des informations depuis LDAP

La connexion à CAS ne retourne qu'un identifiant utilisateur, en utilisant LDAP on peut retrouver les
données associées à cet identifiant.

``` php
<?php

require __DIR__ . '/../src/autoload.php';

$securityLayer = new \Upsud\Cas\SecurityLayer();

$username = $securityLayer->login();

$ldapConnection = new \Upsud\Ldap\Connection('uid=<login>,ou=people,dc=u-psud,dc=fr', '<mot_de_passe>');
$ldapRepository = new \Upsud\Ldap\Repository($ldapConnection);

var_dump($ldapRepository->findByUsername($username)); // Affiche les données de l'utilisateur connecté
```

### CAS

L'utilisation de CAS passe par la classe `\Upsud\Cas\SecurityLayer` qui propose deux méthodes :

-   `login()` connecte l'utilisateur en le redirigeant vers CAS si nécessaire
-   `logout()` déconnecte l'utilsiateur aussi bien côté CAS que côté application (**attention** : cette
    méthode supprime toutes les sessions de l'utilisateur)

### LDAP

L'utilisation de LDAP passe par les classes `\Upsud\Ldap\Connection` qui représente une connexion LDAP
et `\Upsud\Ldap\Repository` qui représente une classe de recherche dans le LDAP.
 
La connexion s'établit simplement en utilisant le constructeur de `\Upsud\Ldap\Connection` :

``` php
<?php
$ldapConnection = new \Upsud\Ldap\Connection('uid=<login>,ou=people,dc=u-psud,dc=fr', '<mot_de_passe>');
```

Cette classe de connexion n'essaie pas de se connecter au serveur directement : elle attend une première requête
pour se connecter.

Il est possible de ne pas utiliser le repository pour rechercher dans LDAP (cela offre plus de possibilités) :

``` php
<?php
$ldapConnection = new \Upsud\Ldap\Connection('uid=<login>,ou=people,dc=u-psud,dc=fr', '<mot_de_passe>');
var_dump($ldapConnection->request('uid=titouan.galopin'));
```

Cependant, le repository renvoie des objets de type `\Upsud\Ldap\Model\User` qui sont plus facilement utilisables
que les tableaux renvoyés par la `\Upsud\Ldap\Connection`:

``` php
<?php
$ldapConnection = new \Upsud\Ldap\Connection('uid=<login>,ou=people,dc=u-psud,dc=fr', '<mot_de_passe>');
$ldapRepository = new \Upsud\Ldap\Repository($ldapConnection);

var_dump($ldapRepository->findByUsername('titouan.galopin')); // Affiche les données de l'utilisateur
```

La classe `\Upsud\Ldap\Repository` propose deux méthodes pour le moment :

- `findByUsername($username)` pour trouver un utilisateur par son identifiant
- `findByEntity($entity)` pour trouver tous les utilisateurs appartenant à une entité donnée (IUT d'Orsay, etc.)
