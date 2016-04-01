# pathwell-bundle
Symfony Bundle implementing PathWell Topology password policy

# Installing a custom Topology Blacklist

To use your own custom blacklist just implement `PathWellTopologiesInterface`
and override the `pathwell.topology.class` parameter. Example:

```php
<?php
// src/AppBundle/Security/MyPathWellTopologies.php

namespace AppBundle\Security;

use Donato\PathWellBundle\Validator\PathWellTopologiesInterface;

class MyPathWellTopologies implements PathWellTopologiesInterface
{
    public function getBlacklist() {
        return [
            'ssssssss', // blacklists a password that contains only 'special' characters
            'lddddddd', // blacklists a password that consists of a lowercase letter followed by 7 numbers
        ];
    }
}
```

```yaml
# config.yml or parameters.yml
parameters:
    pathwell.topology.class: AppBundle\Security\MyPathWellTopologies
```

# TODO
1. Separate actual validation from Symfony-specific code

    The "core" validation could become a separate lib.
