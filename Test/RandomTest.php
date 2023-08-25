<?php

namespace Ketut\RandomString\Test;

use Ketut\RandomString\Random;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class RandomTest extends TestCase
{
    public function testGenerate()
    {
        $random = new Random();

        // Test generating a random string
        $result = $random->generate();
        $this->assertIsString($result);
        $this->assertEquals(Random::LENGTH, strlen($result)); // Assuming LENGTH is 12
    }

    public function testGenerateBlock()
    {
        $random = new Random();

        // Test generating a block of random strings
        $result = $random->generateBlock();
        $this->assertIsArray($result);
        $this->assertCount(Random::COUNT, $result); // Assuming COUNT is 5

        foreach ($result as $item) {
            $this->assertIsString($item);
            $this->assertEquals(Random::LENGTH, strlen($item)); // Assuming LENGTH is 12
        }
    }

    public function testLowerCase()
    {
        $random = new Random();
        $random->lowercase();

        $this->assertStringContainsString("abcdefghijklmnopqrstuvwxyz", $this->getObjectAttribute('char', $random));
    }

    public function testUpperCase()
    {
        $random = new Random();
        $random->uppercase();

        $this->assertStringContainsString("ABCDEFGHIJKLMNOPQRSTUVWXYZ", $this->getObjectAttribute('char', $random));
    }

    public function testNumeric()
    {
        $random = new Random();
        $random->numeric();

        $this->assertStringContainsString("0123456789", $this->getObjectAttribute('char', $random));
    }

    public function testLength()
    {
        $random = new Random();
        $length = 15;

        $random->length($length);
        $this->assertEquals($length, $this->getObjectAttribute('length', $random));
    }

    public function testBlock()
    {
        $random = new Random();
        $count = 8;

        $randomStrings = $random->block($count);

        $this->assertEquals($count, $this->getObjectAttribute('count', $random));
    }

    protected function getObjectAttribute($attribute, $object)
    {
        $reflection = new ReflectionClass(get_class($object));
        $property = $reflection->getProperty($attribute);
        $property->setAccessible(true);

        return $property->getValue($object);
    }

    public function testAccessPrivateProperties()
    {
        $random = new Random();

        // Example of accessing private properties using the custom method
        $char = $this->getObjectAttribute('char', $random);
        $length = $this->getObjectAttribute('length', $random);
        $count = $this->getObjectAttribute('count', $random);

        $this->assertNull($char);
        $this->assertNull($length);
        $this->assertNull($count);
    }
}
