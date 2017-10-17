<?php

namespace Pupper\Pupper;

use Aerys\Request;
use Aerys\Response;
use Aerys\Websocket as AerysWebsocket;

class WebSocket implements AerysWebsocket
{
    /** @var AerysWebsocket\Endpoint $endpoint */
    public $endpoint;
    /** @var array $listeners */
    private $listeners = [];

    /**
     * Invoked when starting the server.
     *
     * All messages are sent to connected clients by calling methods on the
     * Endpoint instance passed in onStart(). Applications must store
     * the endpoint instance for use once the server starts.
     *
     * If the websocket application has external resources it needs to initialize
     * (like database connections) this is the place to do it.
     *
     * If this method is a Generator it will be resolved as a coroutine before
     * the server is allowed to start. Additionally, this method returns a
     * Promise the server will not start until that Promise resolves.
     *
     * @param \Aerys\Websocket\Endpoint $endpoint
     */
    public function onStart(AerysWebsocket\Endpoint $endpoint)
    {
        $this->endpoint = $endpoint;
    }

    /**
     * Respond to websocket handshake requests.
     *
     * If a websocket application doesn't wish to impose any special constraints on the
     * handshake it doesn't have to do anything in this method and all handshakes will
     * be automatically accepted.
     *
     * The return value from onHandshake() invocation (which may be the eventual generator
     * return expression) is passed as the second parameter to onOpen().
     *
     * @param \Aerys\Request $request The HTTP request that instigated the handshake
     * @param \Aerys\Response $response Used to set headers and/or reject the handshake
     * @return null
     */
    public function onHandshake(Request $request, Response $response)
    {
        // During handshakes, you should always check the origin header,
        // otherwise any site will be able to connect to your endpoint.
        // Websockets are not restricted by the same-origin-policy!
        $origin = $request->getHeader('origin');
        if ($origin !== 'http://localhost:1337') {
            $response->setStatus(403);
            $response->end('<h1>origin not allowed</h1>');
            return null;
        }
        // Returned values will be passed to onOpen.
        // That way you can pass cookie values or the whole request object.
        return $request->getConnectionInfo()['client_addr'];
    }

    /**
     * Invoked when data messages arrive from the client.
     *
     * @param int $clientId A unique (to the current process) identifier for this client
     * @param \Aerys\Websocket\Message $msg A stream of data received from the client
     * @throws \RuntimeException
     */
    public function onData(int $clientId, AerysWebsocket\Message $msg)
    {
        // yielding $msg buffers the complete payload into a single string.
        // For very large payloads, you may want to stream those
        // instead of buffering all content.

        // $msg implements Amp\Promise which updates on new content and finally
        // resolves to the full contents. Yielding an Amp\Promise in an Amp context
        // interrupts the execution and continues as soon as the promise is resolved.
        // For more information, please read the "Getting Started with Amp" post
        // mentioned earlier.
        $body = yield $msg;

        $reactEvent = ReactEvent::parse($body);

        foreach ($this->listeners[$reactEvent->getName()] as $callback) {
            $this->endpoint->send($callback($reactEvent), $clientId);
        }

    }

    /**
     * Invoked when the full two-way websocket upgrade completes.
     *
     * @param int $clientId A unique (to the current process) identifier for this client
     * @param mixed $handshakeData The return value from onHandshake() for this client
     */
    public function onOpen(int $clientId, $handshakeData)
    {
        // TODO: Implement onOpen() method.
    }

    /**
     * Invoked when the close handshake completes.
     *
     * @param int $clientId A unique (to the current process) identifier for this client
     * @param int $code The websocket code describing the close
     * @param string $reason The reason for the close (may be empty)
     */
    public function onClose(int $clientId, int $code, string $reason)
    {
        // TODO: Implement onClose() method.
    }

    /**
     * Invoked when the server is stopping.
     *
     * If the application initialized resources in Websocket::onStart() this is the
     * place to free them.
     *
     * This method is called right before the clients will be all automatically closed.
     * There is no need to call Endpoint::close() manually in this method.
     *
     * If this method is a Generator it will be resolved as a coroutine before the server
     * is allowed to fully shutdown. Additionally, if this method returns a Promise the
     * server will not shutdown until that Promise resolves.
     */
    public function onStop()
    {
        // TODO: Implement onStop() method.
    }

    /**
     * @param string $eventName
     * @param callable $callback
     * @return WebSocket
     */
    public function addEventListener(string $eventName, callable $callback): WebSocket
    {
        if (!array_key_exists($eventName, $this->listeners)) {
            $this->listeners[$eventName] = [];
        }
        $this->listeners[$eventName][] = $callback;
        return $this;
    }
}
