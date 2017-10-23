<?php

namespace Pupper\Pupper;

use Pupper\Pupper\Constants\HttpProtocol;
use Pupper\Pupper\Constants\TCPPort;

class RequestOrigin
{
    /** @var string */
    private $protocol;
    /** @var string */
    private $host;
    /** @var int */
    private $port;

    /**
     * @return string
     */
    public function getProtocol(): string
    {
        return $this->protocol;
    }

    /**
     * @param string $protocol
     * @return RequestOrigin
     */
    public function setProtocol(string $protocol = HttpProtocol::HTTPS): RequestOrigin
    {
        $this->protocol = $protocol;
        return $this;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @param string $host
     * @return RequestOrigin
     */
    public function setHost(string $host = 'localhost'): RequestOrigin
    {
        $this->host = $host;
        return $this;
    }

    /**
     * @return int
     */
    public function getPort(): int
    {
        return $this->port;
    }

    /**
     * @param int $port
     * @return RequestOrigin
     */
    public function setPort(int $port = TCPPort::HTTPS): RequestOrigin
    {
        $this->port = $port;
        return $this;
    }
}
