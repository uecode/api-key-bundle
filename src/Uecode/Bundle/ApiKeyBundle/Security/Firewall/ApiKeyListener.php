<?php

namespace Uecode\Bundle\ApiKeyBundle\Security\Firewall;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Http\Firewall\ListenerInterface;
use Uecode\Bundle\ApiKeyBundle\Security\Authentication\Token\ApiKeyUserToken;
use Uecode\Bundle\ApiKeyBundle\Extractor\KeyExtractor;

/**
 * @author Aaron Scherer <aequasi@gmail.com>
 */
class ApiKeyListener implements ListenerInterface
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var AuthenticationManagerInterface
     */
    private $authenticationManager;

    /**
     * @var KeyExtractor
     */
    private $keyExtractor;

    public function __construct(TokenStorageInterface $tokenStorage, AuthenticationManagerInterface $manager, KeyExtractor $keyExtractor)
    {
        $this->tokenStorage          = $tokenStorage;
        $this->authenticationManager = $manager;
        $this->keyExtractor          = $keyExtractor;
    }

    /**
     * This interface must be implemented by firewall listeners.
     *
     * @param GetResponseEvent $event
     */
    public function handle(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        if (!$this->keyExtractor->hasKey($request)) {
            return ;
        }

        $apiKey = $this->keyExtractor->extractKey($request);

        $token = new ApiKeyUserToken();
        $token->setApiKey($apiKey);

        try {
            $authToken = $this->authenticationManager->authenticate($token);
            $this->tokenStorage->setToken($authToken);

            return;
        } catch (AuthenticationException $failed) {
            $token = $this->tokenStorage->getToken();
            if ($token instanceof ApiKeyUserToken && $token->getCredentials() == $apiKey) {
                $this->tokenStorage->setToken(null);
            }

            $message = $failed->getMessage();
        }

        $response = new Response();
        $response->setContent($message);
        $response->setStatusCode(403);
        $event->setResponse($response);
    }
}
