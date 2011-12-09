<?php

include_once 'common.php';
//include_once 'Math/Integer/common.php';
bcscale(0);

class Math_Integer_BCMATH extends Math_Integer_Common {
    
        $this->setValue($value);
    }

    function makeClone() {
        return new Math_Integer_BCMATH($this->toString());
    }

    function setValue($value) {
        if ($this->_is($value, 'Math_Integer_BCMATH')) {
            $this->setValue($value->toString());
        } elseif (is_scalar($value)) {
            $this->_value = $value;
        } else {
            $this->_value = null;
        }
    }

    function negate() {
        $newval = bcmul($this->getValue(), -1);
        $this->setValue($newval);
        return true;
    }

    function abs() {
        if ($this->isNegative()) {
            return $this->negate();
        }
        return true;
    }

    function fact() {
        if ($this->isNegative()) {
            return PEAR::raiseError('Factorial of a negative number is undefined');
        }
        if ($this->isZero()) {
            $this->setValue(1);
            return true;
        } else {
            $fact = 1;
            $val = $this->getValue();
            while (bccomp($val, 1) != 0) {
                $fact = bcmul($fact, $val);
                $val = bcsub($val, 1);
            }
            $this->setValue($fact);
            return true;
        }
    }

    function add(Math_Integer $int) {
        if (!$this->_is($int, 'Math_Integer_BCMATH')) {
            return PEAR::raiseError('Paramater is not a Math_Integer_BCMATH object');
        }
        $newval = bcadd($this->getValue(), $int->getValue());
        $this->setValue($newval);
        return true;
    }

    function inc() {
        $newval = bcadd($this->getValue(), 1);
        $this->setValue($newval);
        return true;
    }

    function sub(Math_Integer $int) {
        if (!$this->_is($int, 'Math_Integer_BCMATH')) {
            return PEAR::raiseError('Paramater is not a Math_Integer_BCMATH object');
        }
        $newval = bcsub($this->getValue(), $int->getValue());
        $this->setValue($newval);
        return true;
    }

    function dec() {
        $newval = bcsub($this->getValue(), 1);
        $this->setValue($newval);
        return true;
    }

    function mul(Math_Integer $int) {
        if (!$this->_is($int, 'Math_Integer_BCMATH')) {
            return PEAR::raiseError('Paramater is not a Math_Integer_BCMATH object');
        }
        $newval = bcmul($this->getValue(), $int->getValue());
        $this->setValue($newval);
        return true;
    }

    function div(Math_Integer $int) {
        if (!$this->_is($int, 'Math_Integer_BCMATH')) {
            return PEAR::raiseError('Paramater is not a Math_Integer_BCMATH object');
        }
        if ($int->isZero()) {
            return PEAR::raiseError('Division by zero is undefined');
        }
        $newval = bcdiv($this->getValue(), $int->getValue());
        $this->setValue($newval);
        return true;
    }

    function pow(Math_Integer $int) {
        if (!$this->_is($int, 'Math_Integer_BCMATH')) {
            return PEAR::raiseError('Exponent is not a Math_Integer_BCMATH object');
        }
        $newval = bcpow($this->getValue(), $int->getValue());
        $this->setValue($newval);
        return true;
    }

    function powmod(Math_Integer $int, Math_Integer $mod) {
        $err = '';
        if (!$this->_is(Math_Integer $int, 'Math_Integer_BCMATH')) {
            $err .= 'Exponent is not a Math_Integer_BCMATH object.';
        }
        if (!empty($err)) {
            $err .= ' ';
        }
        if (!$this->_is(Math_Integer $mod, 'Math_Integer_BCMATH')) {
            $err .= 'Modulus is not a Math_Integer_BCMATH object.';
        } else {
            if ($mod->isZero() || $mod->isNegative()) {
                $err .= 'Modulus object must be positive.';
            }
        }
        if (!empty($err)) {
            return PEAR::raiseError($err);
        }
        $newval = bcpowmod($this->getValue(), $int->getValue(), $mod->getValue());
        $this->setValue($newval);
        return true;
    }

    function sqrt() {
        if ($this->isZero()) {
            return true;
        } elseif ($this->isNegative()) {
            return PEAR::raiseError('Cannot take square root of a negative number');
        } else {
            $newval = bcsqrt($this->getValue(), $int->getValue(), $mod->getValue());
            $this->setValue($newval);
            return true;
        }
    }

    function mod(Math_Integer $int) {
        if (!$this->_is($int, 'Math_Integer_BCMATH')) {
            $err = 'Modulus is not a Math_Integer_BCMATH object.';
        } else {
            if ($int->isZero() || $int->isNegative()) {
                $err = 'Modulus object must be positive.';
            }
        }
        if (!empty($err)) {
            return PEAR::raiseError($err);
        }
        $newval = bcmod($this->getValue(), $int->getValue());
        $this->setValue($newval);
        return true;
    }

    function compare(Math_Integer $int) {
        if (!$this->_is($int, 'Math_Integer_BCMATH')) {
            return PEAR::raiseError('Paramater is not a Math_Integer_BCMATH object');
        }
        return bccomp($this->getValue(), $int->getValue());
    }

    function sign() {
        if ($this->isNegative()) {
            return -1;
        } elseif ($this->isZero()) {
            return 0;
        } else {
            return 1;
        }
    }

    function gcd(Math_Integer $int) {
        if (!$this->_is($int, 'Math_Integer_BCMATH')) {
            $err = 'Modulus is not a Math_Integer_BCMATH object.';
        }
        // if both are the same, return either
        if ($this->compare($int) == 0) {
            return new Math_Integer_GMP($int);
        }
        $int1 = $this->makeClone();
        $int2 = $int->makeClone();
        // make sure both are positive
        if ($int1->isNegative()) {
            $int1->negate();
        }
        if ($int2->isNegative()) {
            $int2->negate();
        }
        if ($int1->compare($int2) == -1) {
            $tmp = $int1;
            $int1 = $int2;
            $int2 = $tmp;
        }
        $mod = $int1->mod($int2);
        if (PEAR::isError($mod)) {
            return $mod;
        } elseif (!$int1->isZero()) {
            return $int2->gcd($int1);
        } else {
            return $int2;
        }
    }

    function isOdd() {
        return bcmod($this->getValue(), 2) != 0;
    }

    function isEven() {
        return bcmod($this->getValue(), 2) == 0;
    }

    function isPositive() {
        return bccomp($this->getValue(), 0) == 1;
    }

    function isNegative() {
        return bccomp($this->getValue(), 0) == -1;
    }

    function isZero() {
        return bccomp($this->getValue(), 0) == 0;
    }

}

?>
