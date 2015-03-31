<?php

/*
 * This file is part of the Upsud library.
 *
 * Titouan Galopin <galopintitouan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Upsud\Ldap\Model;

/**
 * Model representing a LDAP user
 */
class User
{
    /**
     * @var string
     */
    public $civility;

    /**
     * @var string
     */
    public $lastName;

    /**
     * @var string
     */
    public $firstName;

    /**
     * @var string
     */
    public $fullName;

    /**
     * @var string
     */
    public $uid;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $photo;

    /**
     * @var bool
     */
    public $isStudent;

    /**
     * @var string
     */
    public $studentNumber;

    /**
     * @var string
     */
    public $barCode;

    /**
     * @var array
     */
    public $groups;

    /**
     * @var array
     */
    public $departements;

    /**
     * @var array
     */
    public $entities;

    /**
     * @var array
     */
    public $raw;
}
