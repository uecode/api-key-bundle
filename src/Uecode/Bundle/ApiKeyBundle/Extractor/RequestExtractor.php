<?php

namespace Uecode\Bundle\ApiKeyBundle\Extractor;

use Symfony\Component\HttpFoundation\Request;


/**
 * Extracts API keys from a request request string.
 *
 * @author Felix Kopp <f.kopp@reidl.de>
 */
class RequestExtractor implements KeyExtractor
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
        return $request->request->has($this->parameterName);
    }

    /**
     * {@inheritDoc}
     */
    public function extractKey(Request $request)
    {
        return $request->request->get($this->parameterName);
    }
}
