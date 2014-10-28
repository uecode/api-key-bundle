<?php

namespace Uecode\Bundle\ApiKeyBundle\Security\Firewall;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Http\Firewall\ListenerInterface;
use Uecode\Bundle\ApiKeyBundle\Security\Authentication\Token\ApiKeyUserToken;

/**
 * @author Aaron Scherer <aequasi@gmail.com>
 */
class ApiKeyListener implements ListenerInterface
{
    /**
     * @var SecurityContextInterface
     */
    protected $securityContext;

    /**
     * @var AuthenticationManagerInterface
     */
    protected $authenticationManager;

    public function __construct(SecurityContextInterface $context, AuthenticationManagerInterface $manager)
    {
        $this->securityContext       = $context;
        $this->authenticationManager = $manager;
    }

    /**
     * This interface must be implemented by firewall listeners.
     *
     * @param GetResponseEvent $event
     */
    public function handle(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        $apiKey = $request->headers->get('X-Api-Key', $request->query->get('api_key'));
        if (!$apiKey) {
            $response = new Response();
            $response->setStatusCode(401);
            $event->setResponse($response);
            return ;
        }

        $token = new ApiKeyUserToken();
        $token->setApiKey($apiKey);

        try {
            $authToken = $this->authenticationManager->authenticate($token);
            $this->securityContext->setToken($authToken);

            return;
        } catch (AuthenticationException $failed) {
            $token = $this->securityContext->getToken();
            if ($token instanceof ApiKeyUserToken && $token->getCredentials() == $apiKey) {
                $this->securityContext->setToken(null);
            }

            $message = $failed->getMessage();
        }

        $response = new Response();
        $response->setContent($message);
        $response->setStatusCode(403);
        $event->setResponse($response);
    }
}
