<?php

/*
 * This file is part of the Upsud library.
 *
 * Titouan Galopin <galopintitouan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Upsud\Ldap\Tests;

use Upsud\Ldap\Mapper;
use Upsud\Ldap\Model\User;

class MapperTest extends \PHPUnit_Framework_TestCase
{
    public function testMap()
    {
        $mapper = new Mapper();

        /** @var $user User */

        $this->assertInstanceOf(
            'Upsud\Ldap\Model\User',
            $user = $mapper->map(self::$userData),
            'LDAP mapper should return a User model'
        );

        $this->assertEquals(
            self::$userData['supanncivilite'][0],
            $user->civility,
            'Civility should be set'
        );

        $this->assertEquals(
            self::$userData['sn'][0],
            $user->lastName,
            'Last name should be set'
        );

        $this->assertEquals(
            self::$userData['givenname'][0],
            $user->firstName,
            'First name should be set'
        );

        $this->assertEquals(
            self::$userData['displayname'][0],
            $user->fullName,
            'Full name should be set'
        );

        $this->assertEquals(
            self::$userData['uid'][0],
            $user->uid,
            'Identifier should be set'
        );

        $this->assertEquals(
            self::$userData['mail'][0],
            $user->email,
            'Email should be set'
        );

        $this->assertEquals(
            self::$userData['title'][0],
            $user->title,
            'Title should be set'
        );

        $this->assertEquals(
            (isset(self::$userData['upsurlphoto'][0]) ? self::$userData['upsurlphoto'][0] : null),
            $user->photo,
            'Domain name should be set'
        );

        $groups = self::$userData['edupersonaffiliation'];
        array_shift($groups);

        $this->assertEquals(
            $groups,
            $user->groups,
            'Groups should be set'
        );

        $departments = self::$userData['departmentnumber'];
        array_shift($departments);

        $this->assertEquals(
            $departments,
            $user->departements,
            'Departments should be set'
        );

        $entities = self::$userData['o'];
        array_shift($entities);

        $this->assertEquals(
            $entities,
            $user->entities
        );
    }

    public static $userData = [
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
}
