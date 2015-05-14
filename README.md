ApiKey Bundle
=============

Creates an avenue for using ApiKey authentication for Symfony2. Requires FOSUserBundle.

## Installation

Requires composer, install as follows

```sh
composer require uecode/api-key-bundle dev-master
```

#### Enable Bundle

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

#### Entities

Assuming you already have a `User` class that extends the `FOSUserBundle`'s base user model,
change that extend, so its extending `Uecode\Bundle\ApiKeyBundle\Model\ApiKeyUser`

Then update your schema.

#### Set up security

In your security, change your provider to the service `uecode.api_key.provider.user_provider`

```yml
security:
    providers:
        db:
            id: uecode.api_key.provider.user_provider

    # Or

    providers:
        chain_provider:
            chain:
                providers: [db, memory]
        memory: # .....
        db:
            id: uecode.api_key.provider.user_provider
```

After adding that, you can now add `api_key: true`, and `stateless: true` to any of your firewalls. 

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
