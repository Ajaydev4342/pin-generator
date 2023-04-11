<?php

namespace Tests;

use AjayDev\PinGenerator\PinGenerator;
use Illuminate\Cache\CacheManager;
use PHPUnit\Framework\TestCase;
use Illuminate\Container\Container;
use Illuminate\Config\Repository;

class PinGeneratorTest extends TestCase
{
    protected $cache;
    protected $pin_generate;
    protected $usedPins = [];

    protected function setUp(): void
    {
        parent::setUp();

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
        $this->pin_generate = new PinGenerator();
    }

    public function testGeneratePinLengthCheck()
    {
        //generate pin 4 digit long
        $pin = $this->pin_generate->generatePin(4);
        $this->assertIsString($pin);
        $this->assertEquals(4, strlen($pin));
    }

    public function testGeneratePinIsNotPalindromes()
    {
        //pin should not be Palindromes 2332, 5555, 4942
        $this->assertEquals(true, $this->pin_generate->isPalindrome('2332'));
        $this->assertEquals(true, $this->pin_generate->isPalindrome('5555'));
        $this->assertEquals(false, $this->pin_generate->isPalindrome('4942'));
    }

    public function testGeneratePinIsNotSequentialNumber()
    {
        //pin should not be generated in sequentail form 0123, 1234, 2345
        $this->assertTrue($this->pin_generate->isSequential('0123'));
        $this->assertTrue($this->pin_generate->isSequential('1234'));
        $this->assertTrue($this->pin_generate->isSequential('2345'));
    }

    public function testGeneratePinIsNotRepeatingNumber()
    {
        //no repeating digits in the number
        $this->assertEquals(true, $this->pin_generate->isRepeating('1115'));
        $this->assertEquals(true, $this->pin_generate->isRepeating('7377'));
        $this->assertEquals(false, $this->pin_generate->isRepeating('4942'));
    }

    public function testPackageShouldNotRepeatPinUntilAllPreceedingPinsAreUsed()
    {
        $generated_numbers = [];
        for ($i=1; $i <= 73; $i++) { 
            $pin = $this->pin_generate->generatePin(2);
            array_push($generated_numbers, $pin);
        } 
        $this->assertEquals(count($generated_numbers), count(array_unique($generated_numbers)));
    }

    public function testPinLengthCanBeDefined()
    {
        $pin = $this->pin_generate->generatePin(8);
        $this->assertIsString($pin);
        $this->assertEquals(8, strlen($pin));
    }

}