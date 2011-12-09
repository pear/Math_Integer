<?php

require_once 'Math/Integer/Common.php';

class Math_Integer_GMP extends Math_Integer_Common {
    
    function __construct($value) {
        $this->setValue($value);
    }

    function toString() {
        return gmp_strval($this->_value);
    }

    function makeClone() {
        return new Math_Integer_GMP($this->toString());
    }

    function setValue($value) {
        if ($this->_is($value, 'Math_Integer_GMP')) {
            $this->setValue($value->toString());
        } elseif (is_resource($value) && get_resource_type($value) == 'GMP integer') {
            $this->_value = $value;
        } elseif (is_scalar($value)) {
            $this->_value = gmp_init($value);
        } else {
            $this->_value = null;
        }
    }

    function getValue() {
        return $this->_value;
    }

    function negate() {
        $newval = gmp_neg($this->getValue());
        if (is_resource($newval)) {
            $this->setValue($newval);
            return true;
        } else {
            return PEAR::raiseError('Error while negating Math_Integer_GMP '.
                                    'object: '.$this->toString());
        }
    }

    function abs() {
        $newval = gmp_abs($this->getValue());
        if (is_resource($newval)) {
            $this->setValue($newval);
            return true;
        } else {
            return PEAR::raiseError('Error while doing Math_Integer_GMP::abs() '.
                                    'object: '.$this->toString());
        }
    }

    function fact() {
        $newval = gmp_fact($this->toString());
        if (is_resource($newval)) {
            $this->setValue($newval);
            return true;
        } else {
            return PEAR::raiseError('Error while doing Math_Integer_GMP::fact() '.
                                    'object: '.$this->toString());
        }
    }

    function add(Math_Integer_GMP $int) {
        if (!$this->_is($int, 'Math_Integer_GMP')) {
            return PEAR::raiseError('Parameter is not a Math_Integer_GMP object');
        }
        $newval = gmp_add($this->getValue(), $int->getValue());
        if (is_resource($newval)) {
            $this->setValue($newval);
            return true;
        } else {
            return PEAR::raiseError('Error while adding Math_Integer_GMP '.
                                    'objects: '.$this->toString().' and '.
                                    $int->toString());
        }
    }

    function inc() {
        $newval = gmp_add($this->getValue(), gmp_init(1));
        if (is_resource($newval)) {
            $this->setValue($newval);
            return true;
        } else {
            return PEAR::raiseError('Error while incrementing Math_Integer_GMP '.
                                    'object: '.$this->toString());
        }
    }

    function sub(Math_Integer_GMP $int) {
        if (!$this->_is($int, 'Math_Integer_GMP')) {
            return PEAR::raiseError('Parameter is not a Math_Integer_GMP object');
        }
        $newval = gmp_sub($this->getValue(), $int->getValue());
        if (is_resource($newval)) {
            $this->setValue($newval);
            return true;
        } else {
            return PEAR::raiseError('Error while substracting Math_Integer_GMP '.
                                    'objects: '.$this->toString().' and '.
                                    $int->toString());
        }
    }

    function dec() {
        $newval = gmp_sub($this->getValue(), gmp_init(1));
        if (is_resource($newval)) {
            $this->setValue($newval);
            return true;
        } else {
            return PEAR::raiseError('Error while decrementing Math_Integer_GMP '.
                                    'object: '.$this->toString());
        }
    }

    function mul(Math_Integer_GMP $int) {
        if (!$this->_is($int, 'Math_Integer_GMP')) {
            return PEAR::raiseError('Parameter is not a Math_Integer_GMP object');
        }
        $newval = gmp_mul($this->getValue(), $int->getValue());
        if (is_resource($newval)) {
            $this->setValue($newval);
            return true;
        } else {
            return PEAR::raiseError('Error while multiplying Math_Integer_GMP '.
                                    'objects: '.$this->toString().' and '.
                                    $int->toString());
        }
    }

    function div(Math_Integer_GMP $int) {
        if (!$this->_is($int, 'Math_Integer_GMP')) {
            return PEAR::raiseError('Parameter is not a Math_Integer_GMP object');
        }
        if ($int->isZero()) {
            return PEAR::raiseError('Division by zero is undefined');
        }
        $newval = gmp_div($this->getValue(), $int->getValue());
        if (is_resource($newval)) {
            $this->setValue($newval);
            return true;
        } else {
            return PEAR::raiseError('Error while dividing Math_Integer_GMP '.
                                    'objects: '.$this->toString().' and '.
                                    $int->toString());
        }
        return $this->_noImplemented('div');
    }

    function pow(Math_Integer_GMP $int) {
        if (!$this->_is($int, 'Math_Integer_GMP')) {
            return PEAR::raiseError('Parameter is not a Math_Integer_GMP object');
        }
        if ($int->isNegative()) {
            return PEAR::raiseError('Exponent cannot be negative');
        } elseif ($int->isZero()) {
            $this->setValue(1);
        } else {
            $newval = gmp_pow($this->getValue(), $int->toString());
            if (is_resource($newval)) {
                $this->setValue($newval);
                return true;
            } else {
                return PEAR::raiseError('Error while doing pow($n, $e) Math_Integer_GMP '.
                                        'objects: '.$this->toString().' and '.
                                        $int->toString());
            }
        }
    }

    function powmod(Math_Integer $int, Math_Integer $mod) {
        $err = '';
        if (!$this->_is($int, 'Math_Integer_GMP')) {
            $err .= 'Exponent is not a Math_Integer_GMP object.';
        } elseif ($int->isNegative()) {
            $err .= 'Exponent cannot be negative';
        }
        if (!is_empty($err)) {
            $err .= ' ';
        }
        if (!$this->_is($mod, 'Math_Integer_GMP')) {
            $err .= 'Modulus is not a Math_Integer_GMP object.';
        } elseif ($mod->isZero() || $mod->isNegative()) {
            $err .= 'Modulus must be positive and greater than zero';
        }
        if (!empty($err)) {
            return PEAR::raiseError($err);
        }
        $newval = gmp_powm($this->getValue(), $int->getValue(), $mod->getValue());
        if (is_resource($newval)) {
            $this->setValue($newval);
            return true;
        } else {
            return PEAR::raiseError('Error while doing pow(n, e, m) Math_Integer_GMP '.
                                    'objects: '.$this->toString().', '.
                                    $int->toString().', and '.$mod->toString());
        }
    }

    function sqrt() {
        if ($this->isZero()) {
            return true;
        } elseif ($this->isNegative()) {
            return PEAR::raiseError('Cannot take square root of a negative number');
        } else {
            $newval = gmp_add($this->getValue(), $int->getValue());
            if (is_resource($newval)) {
                $this->setValue($newval);
                return true;
            } else {
                return PEAR::raiseError('Error while taking a square root of: '.
                                        $this->toString());
            }
        }
    }

    function mod(Math_Integer_GMP $int) {
        if (!$this->_is($int, 'Math_Integer_GMP')) {
            return PEAR::raiseError('Modulus is not a Math_Integer_GMP object');
        } elseif ($int->isZero() || $int->isNegative()) {
            return PEAR::raiseError('Modulus must be positive and greater than zero');
        }
        $newval = gmp_mod($this->getValue(), $int->getValue());
        if (is_resource($newval)) {
            $this->setValue($newval);
            return true;
        } else {
            return PEAR::raiseError('Error while doing mod(i, m) using the '.
                                    'objects: '.$this->toString().' and '.
                                    $int->toString());
        }
    }

    function compare(Math_Integer_GMP $int) {
        if (!$this->_is($int, 'Math_Integer_GMP')) {
            return PEAR::raiseError('Parameter is not a Math_Integer_GMP object');
        }
        $cmp = gmp_cmp($this->getValue(), $int->getValue());
        if ($cmp > 0) {
            return 1; 
        } elseif ($cmp == 0) {
            return 0;
        } else {
            return -1;
        }
    }

    function sign() {
        return gmp_sign($this->getValue());
    }

    function gcd(Math_Integer_GMP $int) {
        if (!$this->_is($int, 'Math_Integer_GMP')) {
            return PEAR::raiseError('Parameter is not a Math_Integer_GMP object');
        }
        $gcd = gmp_gcd($this->getValue(), $int->getValue());
        if (!is_resource($gcd) || get_resource_type($gcd) != 'GMP integer') {
            return PEAR::raiseError('Unkown error calculating GCD');
        }
        return new Math_Integer_GMP($gcd);
    }

    function isOdd() {
        return gmp_mod($this->getValue(), gmp_init(2)) != 0;
    }

    function isEven() {
        return gmp_mod($this->getValue(), gmp_init(2)) == 0;
    }

    function isPositive() {
        return gmp_sign($this->getValue()) == 1;
    }

    function isNegative() {
        return gmp_sign($this->getValue()) == -1;
    }

    function isZero() {
        return gmp_sign($this->getValue()) == 0;
    }

    function isPrime($reps=10) {
        if (!is_int($reps)) {
            return PEAR::raiseError('Expecting an integer for the number of repeats');
        }
        if ($reps < 5 || $reps > 10) {
            return PEAR::raiseError("Number of repeats for algorithm must be between 5 ".
                                    "and 10 (default). You requested $reps repreats");
        }
        return gmp_prob_prime($this->getValue(), $reps);
    }

}
