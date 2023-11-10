<?php

namespace Uecode\Bundle\ApiKeyBundle\Extractor;

use Symfony\Component\HttpFoundation\Request;

/**
 * @author Kévin Gomez <contact@kevingomez.fr>
 */
interface KeyExtractor
{
    /**
     * Tells if the given requests carries an API key.
     *
     * @param Request $request
     *
     * @return bool
     */
    function hasKey(Request $request);

    /**
     * Extract the API key from thhe given request
     *
     * @param Request $request
     *
     * @return string
     */
    function extractKey(Request $request);
}
