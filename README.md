# Pin-Generator

This composer package is for Laravel to create a unique identifier, In this instance, a PIN (personal identification number), suitable for use with door locks, etc. Each time the code executes, it return at least one PIN, that has adhered to the following:
    
    • The initial intention is that each PIN comprises of four numeric digits (e.g. “2845”),
    • This package will not generate “obvious” numbers. This can be handled

programmatically to account for the following restrictions, but allow for additional to be added later
    
    -> Palindromes
        • Invalid examples include : 2332,5555 etc.

    -> Sequential numbers
        • Invalid examples Include : 0123,1234,1235etc.

    -> Repeating numbers
        • Invalid examples Include : 1115,7377 etc.

    -> As an example, 4942 would be a PIN that passes these 3 restrictions.
        • This package will provide the PINs in an apparently random order.
        • This package will not repeat a PIN until all the preceding valid PINs have been utilised - even if the solution is stopped and started between PINs being returned.
        • You can specify the lenght of the pin e.g. 4, 6, 7, 12-digit pins. But the recommendation will be to not use a very big number. 
        
## Table of Contents

- [Support](#Support)
- [Installation](#installation)
- [Usage](#Usage)
- [Unit Test cases](#UnitTestCases)

## Support

Supported PHP versions are from ^7.2.5 till ^8.2 <br>
Supported Laravel versions are from 8+

## Installation

Run the following command at the root directory of your project to install the the pin-generator package:

```bash
composer require ajaydev/pin-generator dev-main
```

And after succesfully downloading this package add service provider to your

<project_root>/config/app.php

in this array of providers 

```php
'providers' => [
    // add this line in your providers array
    AjayDev\PinGenerator\PinGeneratorServiceProvider::class,
],
```
this line

```php
AjayDev\PinGenerator\PinGeneratorServiceProvider::class,
```

## Usage

After completion the above mentioned steps you just need to use this facade in your controller

```php
use AjayDev\PinGenerator\PinGeneratorFacade;
```

and after this simply 

```php
$pin = PinGeneratorFacade::generatePin(2);  #at the place of two you can pass your length as per your requirement by default it will be 4 if you remove 2
```

## UnitTestCases ( Optional )

If you want you can run and see all the test cases working perfectly or not with this command in you root project directory.

```php
php artisan test vendor/ajaydev/pin-generator/tests/PinGeneratorTest.php
```

That's it you are are good to go.