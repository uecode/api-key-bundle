<?php

namespace Uecode\Bundle\ApiKeyBundle\Extractor;

use Symfony\Component\HttpFoundation\Request;

use Uecode\Bundle\ApiKeyBundle\Extractor\QueryExtractor;
use Uecode\Bundle\ApiKeyBundle\Extractor\RequestExtractor;

/**
 * Extracts API keys from a request query or a request request string.
 *
 * @author Felix Kopp <f.kopp@reidl.de>
 */
class QueryOrRequestExtractor implements KeyExtractor
{
    private $parameterName;

    private $QueryExtractor;
    private $RequestExtractor;

    /**
     * @param string $parameterName The name of the URL parameter containing the API key.
     */
    public function __construct($parameterName)
    {
        $this->parameterName    = $parameterName;

        $this->QueryExtractor   = new QueryExtractor($parameterName);
        $this->RequestExtractor = new RequestExtractor($parameterName);
    }

    /**
     * {@inheritDoc}
     */
    public function hasKey(Request $request)
    {
        if($this->hasQueryKey($request) OR $this->hasRequestKey($request)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Tells if the given requests carries an API key as GET / Query variable.
     *
     * @param Request $request
     *
     * @return bool
     */
    public function hasQueryKey(Request $request)
    {   
        return $this->QueryExtractor->hasKey($request);
    }

    /**
     * Tells if the given requests carries an API key as POST / Request variable.
     *
     * @param Request $request
     *
     * @return bool
     */
    public function hasRequestKey(Request $request)
    {   
        return $this->RequestExtractor->hasKey($request);
    }

    /**
     * {@inheritDoc}
     */
    public function extractKey(Request $request)
    {
        if($this->hasQueryKey($request)) {
            return $this->QueryExtractor->extractKey($request);
        } elseif($this->hasRequestKey($request)) {
            return $this->RequestExtractor->extractKey($request);
        }
    }
}
