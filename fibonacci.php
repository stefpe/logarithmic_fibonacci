<?php

/**
 * Class Matrix
 */
class Matrix
{


    /**
     * Multiply two given matrices if they are compatible with each other.
     * @param array $a
     * @param array $b
     * @return array
     * @throws Exception
     */
    public static function multiply(array $a, array $b): array
    {
        $cntA = count($a);
        $cntBCol = count($b[0]);
        $cntB = count($b);
        if (count($a[0]) != $cntB) {
            throw new \Exception('Incompatible matrices');
        }
        $result = [];
        for ($i = 0; $i < $cntA; $i++) {
            for ($j = 0; $j < $cntBCol; $j++) {
                $result[$i][$j] = 0;
                for ($k = 0; $k < $cntB; $k++) {
                    $result[$i][$j] += $a[$i][$k] * $b[$k][$j];
                }
            }
        }
        return $result;
    }

    /**
     * Multiply a given matrix with itself -> square.
     * @param array $a
     * @return array
     * @throws Exception
     */
    public static function square(array $a): array
    {
        return self::multiply($a, $a);
    }

    /**
     * Calculate the exponents of the first operand for the fibonacci matrix multiplication
     * and multiply it based binary 1's found via a logarithmic approach.
     * @param int $n
     * @param array $exponents
     * @return array
     * @throws Exception
     */
    public static function binaryExponentation(int $n): array
    {
        //pre calculate the exponents of 2
        $exponents = [];
        $exponents[0] = [[1, 1], [1, 0]];
        for ($i = 1; $i < 64; $i++) {
            $exponents[$i] = Matrix::square($exponents[$i - 1]);
        }

        $result = [[1, 0], [0, 1]];

        for ($i = 31; $i >= 0; $i--) {
            if (($n & (1 << $i)) != 0) {
                $result = self::multiply($result, $exponents[$i]);
            }
        }
        return $result;
    }
}

/**
 * Ca
 * @param int $a
 * @return int
 * @throws Exception
 */
function fibonacci(int $a)
{
    if ($a === 1 || $a === 0) {
        return 1;
    }

    $result = Matrix::binaryExponentation($a - 1);
    return $result[0][0] + $result[0][1];
}


var_dump(fibonacci(14));