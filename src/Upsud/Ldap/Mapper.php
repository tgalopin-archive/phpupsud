<?php

/*
 * This file is part of the Upsud library.
 *
 * Titouan Galopin <galopintitouan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Upsud\Ldap;

/**
 * The mapper tranform the array results of the LDAP native functions in objects
 * (for auto-completion, clarity and usability)
 */
class Mapper
{
    /**
     * @param array $userData
     * @return Model\User
     */
    public function map(array $userData)
    {
        $user = new Model\User();

        $user->uid = $userData['uid'][0];
        $user->civility = (isset($userData['supanncivilite'][0])) ? $userData['supanncivilite'][0] : '';
        $user->lastName = $userData['sn'][0];
        $user->firstName = $userData['givenname'][0];
        $user->fullName = $userData['displayname'][0];
        $user->email = (isset($userData['mail'][0])) ? $userData['mail'][0] : '';
        $user->title = $userData['title'][0];
        $user->photo = isset($userData['upsurlphoto'][0]) ? $userData['upsurlphoto'][0] : null;
        $user->barCode = isset($userData['upscodebarrebu'][0]) ? $userData['upscodebarrebu'][0] : null;
        $user->studentNumber = isset($userData['upscodeetu'][0]) ? $userData['upscodeetu'][0] : null;

        // Groups
        $groups = (isset($userData['edupersonaffiliation'])) ? $userData['edupersonaffiliation'] : [];
        array_shift($groups);

        $user->groups = $groups;
        
        // User might be a student, but we can not be sure.
        if (in_array('student', $groups)) {

            if (in_array('employee', $groups) || (in_array('researcher', $groups))) {
                // Doctorant
                $user->isStudent = false;
            } else {
                // Student
                $user->isStudent = true;
            }

        } else {
            // Employee
            $user->isStudent = false;
        }

        // Departments
        $departments = $userData['departmentnumber'];
        array_shift($departments);

        $user->departements = array_map('intval', $departments);

        // Entites
        $entities = $userData['o'];
        array_shift($entities);

        $user->entities = $entities;
        $user->raw = $userData;

        return $user;
    }
}
