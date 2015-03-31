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
 * The LDAP registry is the main entry-point from external code. It aggregates the Connection and the Mapper
 * to create a flexible system to query users into the LDAP.
 */
class Repository
{
    /**
     * @var Connection
     */
    protected $connection;

    /**
     * @var Mapper
     */
    protected $mapper;

    /**
     * @param Connection $connection
     * @param Mapper $mapper
     */
    public function __construct(Connection $connection, Mapper $mapper = null)
    {
        $this->connection = $connection;
        $this->mapper = ($mapper) ? $mapper : new Mapper();
    }

    /**
     * @param string $username
     * @return Model\User|null
     */
    public function findByUsername($username)
    {
        $data = $this->connection->request('uid=' . $username);

        if (! is_array($data) || ! isset($data['count']) || $data['count'] == 0) {
            return null;
        }

        return $this->mapper->map($data[0]);
    }

    /**
     * @param string $entity
     * @return Model\User[]
     */
    public function findByEntity($entity)
    {
        $data = $this->connection->request('o=' . $entity);

        if (! is_array($data) || ! isset($data['count']) || (int) $data['count'] == 0) {
            return [];
        }

        $mapped = [];

        for ($i = 0; $i < $data['count']; $i++) {
            $mapped[] = $this->mapper->map($data[$i]);
        }

        return $mapped;
    }

    /**
     * @return Connection
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @return Mapper
     */
    public function getMapper()
    {
        return $this->mapper;
    }
}
