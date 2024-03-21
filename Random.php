<?php

namespace Ketut\RandomString;

use Exception;

class Random
{
    public const CHAR = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    public const LENGTH = 12;
    public const COUNT = 5;

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

        $pieces = self::strBaseTime($char, 6);
        $max = mb_strlen($char, '8bit') - 1;

        for ($i = 0; $i < $length; ++$i) {
            $pieces .= $char[random_int(0, $max)];
        }

        return substr($pieces, 0, $length);
    }

    /**
     * @throws Exception
     */
    private function strBaseTime(string $char, int $length): string
    {
        $grpInt = self::grpIntBaseTime($length);
        $result = '';

        for ($i = 0; $i < $length; ++$i) {
            $result .= $char[(int)$grpInt[$i]] ?? '';
        }

        return $result;
    }

    /**
     * @throws Exception
     */
    private function grpIntBaseTime(int $length): string
    {
        $timecodes = time() - 60;
        $result = [];

        while ($timecodes !== 0) {
            $result[] = chr($timecodes & 0xFF);
            $timecodes >>= 8;
        }

        $data= str_pad(implode('', array_reverse($result)), 8, "\000", STR_PAD_LEFT);
        $hash = hash_hmac('sha256', $data, $data, true);
        $unpacked = unpack('C*', $hash);
        $unpacked !== false || throw new \Exception('Invalid data.');
        $hmac = array_values($unpacked);

        $offset = ($hmac[count($hmac) - 1] & 0xF);
        $code = ($hmac[$offset] & 0x7F) << 24 | ($hmac[$offset + 1] & 0xFF) << 16 | ($hmac[$offset + 2] & 0xFF) << 8 | ($hmac[$offset + 3] & 0xFF);
        $otp = $code % (10 ** $length);

        return str_pad((string) $otp, $length, '0', STR_PAD_LEFT);
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