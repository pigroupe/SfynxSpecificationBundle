# v2.8.5 SfynxSpecificationBundle documentation

The Symfony provides a flexible framework that
allows you to compose with a DDD (Domain-driven design) applicative architecture.

So, if you need to work with an approach to software development for complex needs by connecting the implementation to an evolving mode, then you're in the right place.

The following documents are available:

- [Create your own specification class](#Create-your-own-specification-class)
- [ChangeLog](#changelog)
- [Todo](#todo)

## Create your own specification class

The goal of this bundle is to provide some ``Specification`` classes to your system.
Your first job, then, is to create the ``MySpecification`` class
for your application. This class implement ``InterfaceSpecification`` interface and have to extend the ``AbstractSpecification`` class.
This is *your* ``Specification`` class.

###### a) MySpecification class implementation

```php
class MySpecification extends AbstractSpecification
{
    public function isSatisfiedBy(\stdClass $object)
    {
        if (strlen($object->str) >= 3) {
            return true;
        }
        return false;
    }
}
```

###### b) Easy used

```php
$MySpecification = new MySpecification();
$object = new \stdClass();
$object->str = 'coincoin';
if ($MySpecification->isSatisfiedBy($object)) {
    /* TODO add your code ... */
    ...
}
```

###### c) Complex used

```php
$anyObject = new StdClass;
$specification = new MySpecification1()
  ->andSpec(new MySpecification2())
  ->andSpec(
      new MySpecification3()
      ->orSpec(new MySpecification4())
  );
;
$isOk = $specification->isSatisfedBy($anyObject);
```

###### d) Expert used
```php
$specs = new XorSpecification(
    new XorSpecification(
        new SpecIsRoleAdmin(),
        new SpecIsRoleAnonymous()
    ),
    new SpecIsRoleUser()
);

if (!$specs->isSatisfiedBy($this->object)) {
    throw new ValidationException($this->serializer->serialize($specs->getProfiler(), 'json'));
}
```

## ChangeLog

| Date | Version | Auteur | Description |
| ------ | ----------- | ---- | ----------- |
| 20/07/2018   | 1.0.0 | EDL | documentation initialization|

## Todo

- Finish profiling of Math specifications