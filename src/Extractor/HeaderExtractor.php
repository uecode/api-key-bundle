<?php

namespace Uecode\Bundle\ApiKeyBundle\Extractor;

use Symfony\Component\HttpFoundation\Request;

/**
 * Extracts API keys from request headers.
 *
 * @author Kévin Gomez <contact@kevingomez.fr>
 */
class HeaderExtractor implements KeyExtractor
{
    private $parameterName;

    /**
     * @param string $parameterName The name of the URL parameter containing the API key.
     */
    public function __construct($parameterName)
    {
        $this->parameterName = $parameterName;
    }

    /**
     * {@inheritDoc}
     */
    public function hasKey(Request $request)
    {
        return $request->headers->has($this->parameterName);
    }

    /**
     * {@inheritDoc}
     */
    public function extractKey(Request $request)
    {
        return $request->headers->get($this->parameterName);
    }
}
