# Netgen Ibexa Search and Filter module

Installation steps
------------------

### Use Composer

Run the following from your website root folder to install Netgen Ibexa Search Filter:

```shell
    $ composer require netgen/ibexa-search-filter
```

Once the added dependency is installed, activate the bundle in ``config/bundles.php`` file by adding it to the returned array, together with other required bundles:
```php
    <?php

    return [
        //...
        Netgen\Bundle\IbexaSearchFilter\NetgenIbexaSearchFilterBundle::class => ['all' => true],
    }
```

### Add routing configuration

Add the file `config/routes/netgen_ibexa_search_filter.yaml` with the following content to activate Netgen Ibexa Search Filter routes:

```yml
netgen_ibexa_search_filter:
    resource: "@NetgenIbexaSearchFilterBundle/Resources/config/routing.yaml"
```

### Clear app caches

```shell
    $ php bin/console cache:clear
```
