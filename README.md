# Laravel Phone

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

## Support

Supported PHP versions are from ^7.2.5 till ^8.2
Supported Laravel versions are from 8+

## Installation

Run the following command at the root directory of your project to install the the pin-generator package:

```bash
composer require ajaydev/pin-generator dev-main
```

And after succesfully downloading this package add service provider to your

<project_root>/config/app.php

```php
'AjayDev\PinGenerator\PinGeneratorServiceProvider::class,'
```

## Usage

After completion the above mentioned steps you just need to use this facade [Usage]

```php
'use AjayDev\PinGenerator\PinGeneratorFacade;'
```

and after this simple 

```php
'$pin = PinGeneratorFacade::generatePin(2);  #at the place of two you can pass your length as per your requirement by default it will be 4 if you remove 2'
```

That's it you are are good to go.