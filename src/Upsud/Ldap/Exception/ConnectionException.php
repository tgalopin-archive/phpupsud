<?php

/*
 * This file is part of the Upsud library.
 *
 * Titouan Galopin <galopintitouan@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Upsud\Ldap\Exception;

/**
 * Exception thrown on connection error
 */
class ConnectionException extends \RuntimeException
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
     * @param string $host
     * @param integer $port
     * @param integer $code
     * @param \Exception $previous
     */
    public function __construct($host, $port, $code = 0, \Exception $previous = null)
    {
        parent::__construct(
            sprintf('LDAP connection to "%s:%s" failed : %s', $host, $port, ldap_err2str($code)),
            $code,
            $previous
        );

        $this->host = $host;
        $this->port = $port;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @return integer
     */
    public function getPort()
    {
        return $this->port;
    }
}
