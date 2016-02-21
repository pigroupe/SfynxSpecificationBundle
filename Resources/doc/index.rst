Getting Started With SfynxSpecificationBundle
==================================

The Symfony provides a flexible framework that
allows you to compose with a DDD (Domain-driven design) applicative architecture.

So, if you need to work with an approach to software development for complex needs by connecting the implementation to an evolving mode, then you're in the right place.

Prerequisites
-------------

This version of the bundle requires Symfony 2.3+.

Installation
------------

Installation is a quick (I promise!) 7 step process:

1. Download SfynxSpecificationBundle using composer
2. Enable the Bundle

Step 1: Download SfynxSpecificationBundle using composer
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Require the bundle with composer:

.. code-block:: bash

    $ composer require sfynx-project/specification-bundle "~2.8@dev"

Composer will install the bundle to your project's ``vendor/sfynx-project/specification-bundle`` directory.

Step 2: Enable the bundle
~~~~~~~~~~~~~~~~~~~~~~~~~

Enable the bundle in the kernel::

    <?php
    // app/AppKernel.php

    public function registerBundles()
    {
        $bundles = array(
            // ...
            new Sfynx\SpecificationBundle\SfynxSpecificationBundle(),
            // ...
        );
    }

Step 3: Create your own specification class
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

The goal of this bundle is to provide some ``Specification`` classes to your system.
Your first job, then, is to create the ``MySpecification`` class
for your application. This class implement ``InterfaceSpecification`` interface and have to extend the ``AbstractSpecification`` class.
This is *your* ``Specification`` class.

a) MySpecification class implementation
..........................

.. configuration-block::

    .. code-block:: php-annotations

        <?php

        class MySpecification extends AbstractSpecification
        {
            public function isSatisfiedBy(\stdClass $object)
            {
                if (strlen($object->str) >= 3) {
                    return true;
                } else {
                    return false;
                }
            }
        }


b) Easy used
.....................

.. configuration-block::

    .. code-block:: php-annotations

        <?php

        $MySpecification = new MySpecification();
        $object = new \stdClass();
        $object->str = 'coincoin';
        if ($MySpecification->isSatisfiedBy($object)) {
            /* TODO add your code ... */
            ...
        }

b) Complex used
.....................

.. configuration-block::

    .. code-block:: php-annotations

        <?php

        $anyObject = new StdClass;
        $specification =
        new MySpecification1()
          ->andSpec(new MySpecification2())
          ->andSpec(
              new MySpecification3()
              ->orSpec(new MySpecification4())
          );
        ;
        $isOk = $specification->isSatisfedBy($anyObject);


b) Expert used
.....................

.. configuration-block::

    .. code-block:: php-annotations

        <?php

        class TrueSpecification implements InterfaceSpecification
        {
            public function isSatisfiedBy(\stdClass $object)
            {
                return true;
            }
        }


        <?php

        $MySpecification = new XorSpecification(
            new XorSpecification(
                new SpecIsRoleAdmin("authenticate permission denied, you must have admin role"),
                new SpecIsRoleAnonymous("authenticate permission denied, you must have anonymous role")
            ),
            new SpecIsRoleUser("authenticate permission denied, you must have user role")
        );

        $specs = new AndSpecification(new TrueSpecification(), $MySpecification);

        if (!$specs->isSatisfiedBy($this->object)) {
            throw new ValidationException($this->serializer->serialize($specs->getErrorMessages(), 'json'));
        }
