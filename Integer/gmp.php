<?php

//include_once 'Math/Integer/common.php';
include_once 'common.php';

class Math_Integer_GMP extends Math_Integer_Common {
	
	function Math_Integer_GMP($value) {
		$this->setValue($value);
	}

	function toString() {
		return gmp_strval($this->_value);
	}

	function clone() {
		return new Math_Integer_GMP($this->toString());
	}

	function setValue($value) {
		$this->_value = gmp_init($value);
	}

	function getValue() {
		return $this->_value;
	}

	function negate() {
		$val = gmp_mul($this->getValue(), gmp_init(-1));
		if (is_resource($val)) {
			$this->_value = $val;
			return true;
		} else {
			return PEAR::raiseError('Error while negating Math_Integer_GMP '.
									'object: '.$this->toString());
		}
	}

	function add(&$int) {
		if (!$this->_is(&$int, 'Math_Integer_GMP')) {
			return PEAR::raiseError('Parameter is not a Math_Integer_GMP object');
		}
		$val = gmp_add($this->getValue(), $int->getValue());
		if (is_resource($val)) {
			$this->_value = $val;
			return true;
		} else {
			return PEAR::raiseError('Error while adding Math_Integer_GMP '.
									'objects: '.$this->toString().' and '.
									$int->toString());
		}
	}

	function inc() {
		return $this->_noImplemented('inc');
	}

	function sub($int) {
		return $this->_noImplemented('sub');
	}

	function dec() {
		return $this->_noImplemented('dec');
	}

	function mul($int) {
		return $this->_noImplemented('mul');
	}

	function div($int) {
		return $this->_noImplemented('div');
	}

	function pow($int) {
		return $this->_noImplemented('pow');
	}

	function sqrt($int) {
		return $this->_noImplemented('sqrt');
	}

	function mod($int) {
		return $this->_noImplemented('mod');
	}

	function compare($int) {
		return $this->_noImplemented('compare');
	}
}

?>
