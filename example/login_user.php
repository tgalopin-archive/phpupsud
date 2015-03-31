<?php

require __DIR__ . '/../src/autoload.php';

$securityLayer = new \Upsud\Cas\SecurityLayer();

$username = $securityLayer->login();

$ldapConnection = new \Upsud\Ldap\Connection('uid=<login>,ou=people,dc=u-psud,dc=fr', '<mot_de_passe>');
$ldapRepository = new \Upsud\Ldap\Repository($ldapConnection);

var_dump($ldapRepository->findByUsername($username)); // Affiche les données de l'utilisateur
