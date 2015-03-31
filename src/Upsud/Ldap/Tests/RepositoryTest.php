<?php

namespace Component\Ldap\Tests;

use Upsud\Ldap\Connection;
use Upsud\Ldap\Mapper;
use Upsud\Ldap\Model\User;
use Upsud\Ldap\Repository;

class RepositoryTest extends \PHPUnit_Framework_TestCase
{
    public function testFindByUsername()
    {
        $registry = new Repository($this->createMockedConnection(), $this->createMockedMapper(), 'dn');

        /** @var \Component\Ldap\Model\User $user */
        $user = $registry->findByUsername('titouan.galopin');

        $this->assertInstanceOf(
            'Upsud\Ldap\Model\User',
            $user,
            'Registry::findByUsername should return a single user'
        );

        $this->assertEquals(
            'titouan.galopin',
            $user->uid,
            'UID should be "titouan.galopin"'
        );
    }

    public function testFindByUsernameNull()
    {
        $registry = new Repository($this->createMockedConnection(), $this->createMockedMapper(), 'dn');

        $this->assertNull(
            $registry->findByUsername('not.exists'),
            'Registry::findByUsername should return null if no user is found'
        );
    }

    public function testFindByEntity()
    {
        $registry = new Repository($this->createMockedConnection(), $this->createMockedMapper(), 'dn');

        /** @var User $user */
        $user = $registry->findByEntity('IUT Orsay');

        $this->assertInternalType(
            'array',
            $user,
            'Registry::findByEntity should return an array'
        );

        $this->assertInstanceOf(
            'Upsud\Ldap\Model\User',
            $user[0],
            'Registry::findByEntity should return a collection of users'
        );
    }

    public function testFindByEntityNull()
    {
        $registry = new Repository($this->createMockedConnection(), $this->createMockedMapper(), 'dn');

        $this->assertEmpty(
            $registry->findByEntity('not.exists'),
            'Registry::findByEntity should return an empty array if no user is found'
        );
    }

    /**
     * @return Connection
     */
    private function createMockedConnection()
    {
        $stub = $this->getMock('Upsud\Ldap\Connection', [ 'request' ], [ 'host', 389, '', '' ]);

        $stub->method('request')->will($this->returnCallback(function ($filter) {
            $userData = [
                'objectclass' =>
                    array (
                        'count' => 8,
                        0 => 'top',
                        1 => 'person',
                        2 => 'organizationalPerson',
                        3 => 'inetOrgPerson',
                        4 => 'eduPerson',
                        5 => 'supannPerson',
                        6 => 'posixAccount',
                        7 => 'upsPerson',
                    ),
                0 => 'objectclass',
                'sn' =>
                    array (
                        'count' => 1,
                        0 => 'Galopin',
                    ),
                1 => 'sn',
                'givenname' =>
                    array (
                        'count' => 1,
                        0 => 'Titouan',
                    ),
                2 => 'givenname',
                'cn' =>
                    array (
                        'count' => 1,
                        0 => 'Galopin Titouan',
                    ),
                3 => 'cn',
                'displayname' =>
                    array (
                        'count' => 1,
                        0 => 'Titouan Galopin',
                    ),
                4 => 'displayname',
                'uid' =>
                    array (
                        'count' => 1,
                        0 => 'titouan.galopin',
                    ),
                5 => 'uid',
                'mail' =>
                    array (
                        'count' => 1,
                        0 => 'titouan.galopin@u-psud.fr',
                    ),
                6 => 'mail',
                'edupersonprincipalname' =>
                    array (
                        'count' => 1,
                        0 => 'titouan.galopin@u-psud.fr',
                    ),
                7 => 'edupersonprincipalname',
                'supannaliaslogin' =>
                    array (
                        'count' => 1,
                        0 => 'tgalopi',
                    ),
                8 => 'supannaliaslogin',
                'supannetablissement' =>
                    array (
                        'count' => 1,
                        0 => '{UAI}0911101C',
                    ),
                9 => 'supannetablissement',
                'supanncivilite' =>
                    array (
                        'count' => 1,
                        0 => 'M.',
                    ),
                10 => 'supanncivilite',
                'supannlisterouge' =>
                    array (
                        'count' => 1,
                        0 => 'FALSE',
                    ),
                11 => 'supannlisterouge',
                'edupersonaffiliation' =>
                    array (
                        'count' => 2,
                        0 => 'student',
                        1 => 'member',
                    ),
                12 => 'edupersonaffiliation',
                'edupersonprimaryaffiliation' =>
                    array (
                        'count' => 1,
                        0 => 'student',
                    ),
                13 => 'edupersonprimaryaffiliation',
                'title' =>
                    array (
                        'count' => 1,
                        0 => 'étudiant',
                    ),
                14 => 'title',
                'supannentiteaffectation' =>
                    array (
                        'count' => 1,
                        0 => '5453',
                    ),
                15 => 'supannentiteaffectation',
                'supanntypeentiteaffectation' =>
                    array (
                        'count' => 1,
                        0 => 'A010',
                    ),
                16 => 'supanntypeentiteaffectation',
                'departmentnumber' =>
                    array (
                        'count' => 3,
                        0 => '5453',
                        1 => '3085',
                        2 => '2212',
                    ),
                17 => 'departmentnumber',
                'o' =>
                    array (
                        'count' => 1,
                        0 => 'IUT Orsay',
                    ),
                18 => 'o',
                'supannrefid' =>
                    array (
                        'count' => 2,
                        0 => '{APOGEE}276685',
                        1 => '{ADONIS}177645',
                    ),
                19 => 'supannrefid',
                'supannetuid' =>
                    array (
                        'count' => 1,
                        0 => '276685',
                    ),
                20 => 'supannetuid',
                'upsuid' =>
                    array (
                        'count' => 1,
                        0 => '177645',
                    ),
                21 => 'upsuid',
                'supanncodeine' =>
                    array (
                        'count' => 1,
                        0 => '1405000848',
                    ),
                22 => 'supanncodeine',
                'upscodeetu' =>
                    array (
                        'count' => 1,
                        0 => '21405574',
                    ),
                23 => 'upscodeetu',
                'uidnumber' =>
                    array (
                        'count' => 1,
                        0 => '30038',
                    ),
                24 => 'uidnumber',
                'gidnumber' =>
                    array (
                        'count' => 1,
                        0 => '1999',
                    ),
                25 => 'gidnumber',
                'homedirectory' =>
                    array (
                        'count' => 1,
                        0 => '/dev/null',
                    ),
                26 => 'homedirectory',
                'gecos' =>
                    array (
                        'count' => 1,
                        0 => 'Titouan Galopin',
                    ),
                27 => 'gecos',
                'upsurlphoto' =>
                    array (
                        'count' => 1,
                        0 => 'http://adonis.u-psud.fr/users/sl1/t/titouan.galopin/6d0382e561ae5c06a96ce5495bbda897.jpg',
                    ),
                28 => 'upsurlphoto',
                'upsautorisationphoto' =>
                    array (
                        'count' => 1,
                        0 => '1',
                    ),
                29 => 'upsautorisationphoto',
                'upscodebarrebu' =>
                    array (
                        'count' => 1,
                        0 => '11117423',
                    ),
                30 => 'upscodebarrebu',
                'upsdateexpiration' =>
                    array (
                        'count' => 1,
                        0 => '2015-12-31 00:00:00',
                    ),
                31 => 'upsdateexpiration',
                'upsauthpublipostage' =>
                    array (
                        'count' => 1,
                        0 => 'TRUE',
                    ),
                32 => 'upsauthpublipostage',
                'count' => 33,
                'dn' => 'uid=titouan.galopin,ou=people,dc=u-psud,dc=fr',
            ];

            if (in_array($filter, [ 'uid=titouan.galopin', 'o=IUT Orsay' ])) {
                return [
                    'count' => 1,
                    0 => $userData
                ];
            }

            return [
                'count' => 0
            ];
        }));

        return $stub;
    }

    /**
     * @return Mapper
     */
    private function createMockedMapper()
    {
        $user = new User();
        $user->civility = 'M.';
        $user->lastName = 'Galopin';
        $user->firstName = 'Titouan';
        $user->fullName = 'Titouan Galopin';
        $user->uid = 'titouan.galopin';
        $user->email = 'titouan.galopin@u-psud.fr';
        $user->title = 'étudiant';
        $user->photo = 'http://adonis.u-psud.fr/users/sl1/t/titouan.galopin/6d0382e561ae5c06a96ce5495bbda897.jpg';
        $user->groups = [ 0 => 'student', 1 => 'member' ];
        $user->departements = [ 0 => '5453', 1 => '3085', 2 => '2212' ];
        $user->entities = [ 0 => 'IUT Orsay' ];

        $stub = $this->getMock('Upsud\Ldap\Mapper');
        $stub->method('map')->willReturn($user);

        return $stub;
    }
}
