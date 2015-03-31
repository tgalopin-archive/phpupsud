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
 * LDAP lazy-loading driver
 */
class Connection
{
    /**
     * @var string
     */
    protected $host;

    /**
     * @var integer
     */
    protected $port;

    /**
     * @var string
     */
    protected $domain;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var resource
     */
    protected $ldap;

    /**
     * @param string $domain
     * @param string $password
     * @param string $host
     * @param integer $port
     */
    public function __construct($domain, $password, $host = 'ldaps://ldaps.u-psud.fr', $port = 389)
    {
        $this->host = $host;
        $this->port = $port;
        $this->domain = $domain;
        $this->password = $password;
    }

    /**
     * @param string $constraints
     * @return array
     * @throws Exception\ConnectionException
     */
    public function request($constraints)
    {
        if (! $this->ldap) {
            $this->boot();
        }

        $results = @ldap_list($this->ldap, 'ou=people,dc=u-psud,dc=fr', $constraints, [], null, 500);
        $entries = ldap_get_entries($this->ldap, $results);

        return $entries;
    }

    /**
     * @return resource
     */
    public function getResource()
    {
        return $this->ldap;
    }

    /**
     * Boot the connection only if needed (before the first request)
     *
     * @throws Exception\ConnectionException
     */
    public function boot()
    {
        $this->ldap = ldap_connect($this->host, $this->port);

        if (! $this->ldap
            || ! ldap_set_option($this->ldap, LDAP_OPT_PROTOCOL_VERSION, 3)
            || ! ldap_bind($this->ldap, $this->domain, $this->password)) {
            throw new Exception\ConnectionException($this->host, $this->port, ldap_errno($this->ldap));
        }

        // Restore default errors handler
        restore_error_handler();
    }
}
