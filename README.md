# Very short description of the package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/thibaultvanc/facturation-regie.svg?style=flat-square)](https://packagist.org/packages/thibaultvanc/facturation-regie)
[![Build Status](https://img.shields.io/travis/thibaultvanc/facturation-regie/master.svg?style=flat-square)](https://travis-ci.org/thibaultvanc/facturation-regie)
[![Quality Score](https://img.shields.io/scrutinizer/g/thibaultvanc/facturation-regie.svg?style=flat-square)](https://scrutinizer-ci.com/g/thibaultvanc/facturation-regie)
[![Total Downloads](https://img.shields.io/packagist/dt/thibaultvanc/facturation-regie.svg?style=flat-square)](https://packagist.org/packages/thibaultvanc/facturation-regie)

This is where your description should go. Try and limit it to a paragraph or two, and maybe throw in a mention of what PSRs you support to avoid any confusion with users and contributors.

## Installation

You can install the package via composer:

```bash
composer require thibaultvanc/facturation-regie
```

## Usage

To use this package you Need 
- User model
- Project Model
- pointables Models (Task & Meeting)
- Invoice (planified)


Need to associate your Models with traits

User    => FacturationRegie\Traits\RegieInvoicable\RegieUser 
Invoice => FacturationRegie\Traits\RegieInvoicable\RegieInvoice
<!-- Order   => FacturationRegie\Traits\RegieInvoicable\RegieOrder -->
Pointage  => FacturationRegie\Traits\RegieInvoicable\RegiePointage     
Project =>  FacturationRegie\Traits\RegieInvoicable\RegieProject
Task/Meeting => FacturationRegie\Traits\RegieInvoicable


exemple =>add RegieInvoicable trait on the table like Task / Meeting / Deplacement

``` php

class Task extends Model
{
    use \FacturationRegie\Traits\RegieInvoicable
}

```
Default forign key to determine the responsable is "responsable_id"
Note : overwite the method to set a différent : 

```php
public function regie_responsable()
    {
        return $this->belongsTo(\App\User::class, 'user_id');
    }
```



##trasform a pointable (task / taskStatus / meeting)


#adjust the date

overwrite the getPointageDate() method. Return a Carbon Instance. if this method does not exists, it take the current time
```php
public function getPointageDate() :Carbon
    {
        return $this->done_at
    }
```

#adjust the name

overwrite the getPointageName() method. Return a Carbon Instance. if this method does not exists, it take the current time
```php
public function getPointageName() :Carbon
    {
        return $this->task_title
    }
```


#adjust the date

overwrite the getPointageDescription() method. Return a Carbon Instance. if this method does not exists, it take the current time
```php
public function getPointageDescription() :Carbon
    {
        return $this->body
    }
```


### pointage scopes
```php

Pointage::between($date1, $date2); (carbon date or string)

Pointage::forDay($date); (carbon date or carbon)
Pointage::forMonth($date);  (prend le mois en cours)
Pointage::forYeay('2019');  (carbon)
Pointage::forUser($user); (user object or user_id) 

Pointage::facturable();
Pointage::noFacturable();

```

You can combine like this : 

```php
Pointage::forMonth(now())
            ->forUser($user)
            ->facturable();
```




### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email info@organit.fr instead of using the issue tracker.

## Credits

- [Thibault Van Campenhoudt](https://github.com/thibaultvanc)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).