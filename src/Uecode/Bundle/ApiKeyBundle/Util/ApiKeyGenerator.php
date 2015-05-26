<?php

namespace Uecode\Bundle\ApiKeyBundle\Util;

/**
 * @author Gennady Telegin <gtelegin@gmail.com>
 */
class ApiKeyGenerator implements ApiKeyGeneratorInterface
{
    private $characterSet = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    private $apiKeyLength = 64;

    public function generateApiKey()
    {
        return self::generate($this->characterSet, $this->apiKeyLength);
    }

    public static function generate($characterSet = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', $apiKeyLength = 64)
    {
        $characterSetLength = strlen($characterSet);

        $apikey     = '';
        for ($i = 0; $i < $apiKeyLength; ++$i) {
            $apikey .= $characterSet[rand(0, $characterSetLength - 1)];
        }

        return rtrim(base64_encode(sha1(uniqid('ue' . rand(rand(), rand())) . $apikey)), '=');
    }
}