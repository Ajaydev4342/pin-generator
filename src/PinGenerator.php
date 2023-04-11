<?php

namespace AjayDev\PinGenerator;

use Illuminate\Support\Facades\Cache;
use Illuminate\Cache\CacheManager;
use Illuminate\Container\Container;
use Illuminate\Config\Repository;

class PinGenerator
{

    protected $cache;
    protected $usedPins = [];

    public function __construct()
    {
        $this->setUp();
    }

    protected function setUp(): void
    {
        $container = new Container();
        $config = new Repository([
            'cache.default' => 'array',
            'cache.stores.array' => [
                'driver' => 'array',
            ],
        ]);
        $container->instance('config', $config);
        $this->cache = new CacheManager($container);
        $this->usedPins = $this->cache->store('array')->get('used_pins', []);
    }

    public function tearDown() {
        unset($this->whatever);
    }

    public function generatePin($length = 4)
    {
        
        // Get all possible PINs for the given length
        $min = pow(10, $length - 1);
        $max = pow(10, $length) - 1;
        // $pins = range($min, $max);
        $pins = $this->getNumbersInRange($min, $max);

        // Filter out invalid PINs
        $pins = array_filter($pins, function ($pin) {
            return $this->isPinValid($pin);
        });
        
        // Filter out used PINs
        $usedPins = $this->getUsedPins();
        $pins = array_diff($pins, $usedPins);
        
        // Shuffle the remaining PINs and return the first one
        shuffle($pins);
        $pin = array_shift($pins);

        // Add the PIN to the list of used PINs
        if(!empty($pin)){
            array_push($usedPins, $pin);
            $this->cache->put('used_pins', $usedPins);
        }else{
            $pin = array_shift($usedPins);
            $usedPins = [];
            $this->cache->put('used_pins', $usedPins);
        }
        
        return strval($pin);
    }

    public function getNumbersInRange($min, $max) {
        if ($min > $max) {
            return [];
        }
        $count = $max - $min + 1;
        $numbers = array_fill(0, $count, null);
        for ($i = 0; $i < $count; $i++) {
            $numbers[$i] = $min + $i;
        }
        return $numbers;
    }

    public function getUsedPins()
    {
        $usedPins = $this->cache->get('used_pins');
        if(!is_null($usedPins)){
            return $usedPins;
        }else{
            $usedPins = [];
        }
        return $usedPins;
    }

    public function isPinValid($pin)
    {
        if ($this->isPalindrome($pin) || $this->isSequential($pin) || $this->isRepeating($pin)) {
            return false;
        }

        return true;
    }

    public function isPalindrome($number)
    {
        return $number == strrev($number);
    }

    public function isSequential($number)
    {
        $digits = str_split($number);
        $prevDigit = null;

        foreach ($digits as $digit) {
            if ($prevDigit !== null && intval($digit) !== intval($prevDigit) + 1) {
                return false;
            }

            $prevDigit = $digit;
        }

        return true;
    }

    public function isRepeating(string $number): bool
    {
        for ($i = 0; $i < strlen($number) - 1; $i++) {
            if ($number[$i] === $number[$i + 1]) {
                return true;
            }
        }
        return false;
    }

}
