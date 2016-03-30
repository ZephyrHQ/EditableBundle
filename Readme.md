Installation
------------

Add the vendor

```bash
composer require zephyr/editable-bundle
```

Add in AppKernel

```php
<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [
            // ...
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            // ...
         ];
         // ...
    }
    // ...
}
```

Use Cases
-----------

### Custom formtype for administration

Use the formtype. Save process is included in the submit action.

```php
<?php
//...
        $builder
            ->add('a_virtual_field', EditableType::class_name, ['reference'=>'nom_reference', 'page'=>'nom_page']
//...
```

### ESI render for front

```twig
{{ render_esi(controller('ZephyrEditableBundle:Content:show', {'reference'=>'nom_reference', 'page'=>'page'})) }}
```

Media management
----------------

### Add dependants bundles

vichuploader

Administration
--------------

Administration pages are availables :

 - /content: content edition
 - /media: media edition

### Installation

#### Add dependants bundles
jsrouting
sgdatatables

#### Add routes

Routes are prefixables and importables : 

```yaml
zephyr_editable:
    resource: "@ZephyrEditableBundle/Resources/config/routing.yml"
    prefix: /admin/editable
```

#### Override the layout

Create a file in :

    app/Resources/ZephyrUserBundle/views/layout.html.twig

#### Security

 - Authorize edition with access control
 - Implements your own voter : 

    The attribute is 'EDITABLE' on the modified object
    Documentation: https://symfony.com/doc/current/cookbook/security/voters.html