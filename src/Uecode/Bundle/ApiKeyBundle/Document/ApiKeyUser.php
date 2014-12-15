<?php

namespace Uecode\Bundle\ApiKeyBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use Uecode\Bundle\ApiKeyBundle\Model\ApiKeyUser as BaseUser;

class ApiKeyUser extends BaseUser
{
    /**
     * @MongoDB\String
     */
    protected $apiKey;
}
