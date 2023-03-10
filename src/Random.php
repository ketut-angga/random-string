<?php

namespace Ketut\RandomString;

use Exception;

class Random
{
    private const CHAR = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    private const LENGTH = 12;
    private const COUNT = 5;

    private ?string $char = null;
    private ?int $length = null;
    private ?int $count = null;

    /**
     * Generate block of random string.
     *
     * @return array
     *
     * @throws Exception
     */
    public function generateBlock(): array
    {
        $count = $this->count ?: self::COUNT;

        $block = [];
        for ($i = 0; $i < $count; $i++) {
            $block [] = self::generate();
        }

        return $block;
    }

    /**
     * Generate random string.
     *
     * @return string
     *
     * @throws Exception
     */
    public function generate(): string
    {
        $char = $this->char ?: self::CHAR;
        $length = $this->length ?: self::LENGTH;

        $pieces = [];
        $max = mb_strlen($char, '8bit') - 1;

        for ($i = 0; $i < $length; ++$i) {
            $pieces [] = $char[random_int(0, $max)];
        }

        return implode('', $pieces);
    }

    /**
     * Set lowercase character to this char.
     *
     * @return $this
     */
    public function lowercase(): self
    {
        $this->char = $this->char . "abcdefghijklmnopqrstuvwxyz";

        return $this;
    }

    /**
     * Set uppercase character to this char.
     *
     * @return $this
     */
    public function uppercase(): self
    {
        $this->char = $this->char . "ABCDEFGHIJKLMNOPQRSTUVWXYZ";

        return $this;
    }

    /**
     * Set numeric character to this char.
     *
     * @return $this
     */
    public function numeric(): self
    {
        $this->char = $this->char . "0123456789";

        return $this;
    }

    /**
     * Set length result of generate random string.
     *
     * @return $this
     *
     * @throws Exception
     */
    public function length(int $length): self
    {
        if (1 > $length)
            throw new Exception("Length of random string must be a positive integer");

        $this->length = $length;

        return $this;
    }

    /**
     * Set count of random string in a block.
     *
     * @return $this
     *
     * @throws Exception
     */
    public function block(int $count): self
    {
        if (1 > $count)
            throw new Exception("Count of block must be a positive integer");

        $this->count = $count;

        return $this;
    }
}