<?php

include_once 'common.php';
//include_once 'Math/Integer/common.php';
bcscale(0);

class Math_Integer_BCMATH extends Math_Integer_Common {
	
	function Math_Integer_BCMATH($value) {
		$this->setValue($value);
	}

	function &clone() {
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

	function add(&$int) {
		if (!$this->_is(&$int, 'Math_Integer_BCMATH')) {
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

	function sub(&$int) {
		if (!$this->_is(&$int, 'Math_Integer_BCMATH')) {
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

	function mul(&$int) {
		if (!$this->_is(&$int, 'Math_Integer_BCMATH')) {
			return PEAR::raiseError('Paramater is not a Math_Integer_BCMATH object');
		}
		$newval = bcmul($this->getValue(), $int->getValue());
		$this->setValue($newval);
		return true;
	}

	function div(&$int) {
		if (!$this->_is(&$int, 'Math_Integer_BCMATH')) {
			return PEAR::raiseError('Paramater is not a Math_Integer_BCMATH object');
		}
		if ($int->isZero()) {
			return PEAR::raiseError('Division by zero is undefined');
		}
		$newval = bcdiv($this->getValue(), $int->getValue());
		$this->setValue($newval);
		return true;
	}

	function pow(&$int) {
		if (!$this->_is(&$int, 'Math_Integer_BCMATH')) {
			return PEAR::raiseError('Exponent is not a Math_Integer_BCMATH object');
		}
		$newval = bcpow($this->getValue(), $int->getValue());
		$this->setValue($newval);
		return true;
	}

	function powmod(&$int, &$mod) {
		$err = '';
		if (!$this->_is(&$int, 'Math_Integer_BCMATH')) {
			$err .= 'Exponent is not a Math_Integer_BCMATH object.';
		}
		if (!empty($err)) {
			$err .= ' ';
		}
		if (!$this->_is(&$mod, 'Math_Integer_BCMATH')) {
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

	function mod(&$int) {
		if (!$this->_is(&$int, 'Math_Integer_BCMATH')) {
			$err = 'Modulus is not a Math_Integer_BCMATH object.';
		} else {
			if ($mod->isZero() || $int->isNegative()) {
				$err = 'Modulus object must be positive.';
			}
		}
		if (!empty($err)) {
			return PEAR::raiseError($err);
		}
		$newval = bcmod($this->getValue(), $int->getValue(), $mod->getValue());
		$this->setValue($newval);
		return true;
	}

	function compare(&$int) {
		if (!$this->_is(&$int, 'Math_Integer_BCMATH')) {
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
