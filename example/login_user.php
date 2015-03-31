<?php

require __DIR__ . '/../src/autoload.php';

$securityLayer = new \Upsud\Cas\SecurityLayer();

$username = $securityLayer->login();

$ldapConnection = new \Upsud\Ldap\Connection('uid=titouan.galopin,ou=people,dc=u-psud,dc=fr', 'ER45DF12#');
$ldapRepository = new \Upsud\Ldap\Repository($ldapConnection);

var_dump($ldapRepository->findByUsername($username)); // Affiche les données de l'utilisateur
