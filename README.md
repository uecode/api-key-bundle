ApiKey Bundle
=============

Creates an avenue for using ApiKey authentication for Symfony2. Requires FOSUserBundle.

# Installation

Requires composer, install as follows

```sh
composer require uecode/api-key-bundle dev-master
```

## Enable Bundle

Place in your `AppKernel.php` to enable the bundle

```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Uecode\Bundle\ApiKeyBundle\UecodeApiKeyBundle(),
    );
}
```
#### Configuration
You can change how the API key should be delivered and the name of the parameter its sent as.  By default, this bundle looks for `api_key` in the query string.

```yaml
uecode_api_key:
    delivery: query #or header
    parameter_name: some_value # defaults to `api_key`
```

### Update user provider

This bundle provides two ways to work with User model:

1. use model and user provider provided by this bundle
2. use custom user provider

### Use model provided by this bundle

#### Entities

Assuming you already have a `User` class that extends the `FOSUserBundle`'s base user model,
change that extend, so its extending `Uecode\Bundle\ApiKeyBundle\Model\ApiKeyUser`

Then update your schema.

#### Change used user provider

In your security, change your provider to the service `uecode.api_key.provider.user_provider` or
`uecode.api_key.provider.email_user_provider` if you use logging in by email instead of username
ie. using fos_user.user_provider.username_email instead of fos_user.user_provider.username
(see https://symfony.com/doc/current/bundles/FOSUserBundle/logging_by_username_or_email.html)

```yml
security:
    providers:
        db:
            id: uecode.api_key.provider.user_provider
    # Or    id: uecode.api_key.provider.user_email_provider

    # Or

    providers:
        chain_provider:
            chain:
                providers: [db, memory]
        memory: # .....
        db:
            id: uecode.api_key.provider.user_provider
    # Or    id: uecode.api_key.provider.user_email_provider
```


### Use custom user provider

To work with this bundle your user provider should implement ```ApiKeyUserProviderInterface```.
It consist of one method for loading user by their apiKey.
You should implement this interface for user provider which used in your api firewall:

```php
use Uecode\Bundle\ApiKeyBundle\Security\Authentication\Provider\ApiKeyUserProviderInterface;

class MyCustomUserProvider implements ApiKeyUserProviderInterface {
// ...

public function loadUserByApiKey($apiKey)
{
    return $this->userManager->findUserBy(array('apiKey' => $apiKey));
}

}
```

## Change security settings

You can now add `api_key: true`, and `stateless: true` to any of your firewalls. 

For Example:

```yml
security:
    firewalls:
        auth:
            pattern: ^/api/*
            api_key: true
            stateless: true
            provider: db # Required if you have multiple providers and firewalls

```
