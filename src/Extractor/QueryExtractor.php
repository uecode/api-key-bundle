<?php

namespace Uecode\Bundle\ApiKeyBundle\Extractor;

use Symfony\Component\HttpFoundation\Request;

/**
 * Extracts API keys from a request query string.
 *
 * @author Kévin Gomez <contact@kevingomez.fr>
 */
class QueryExtractor implements KeyExtractor
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
        return $request->query->has($this->parameterName);
    }

    /**
     * {@inheritDoc}
     */
    public function extractKey(Request $request)
    {
        return $request->query->get($this->parameterName);
    }
}
