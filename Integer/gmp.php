<?php

include_once 'Math/Integer/common.php';

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
		return $this->_noImplemented('negate');
	}

	function add($int) {
		return $this->_noImplemented('add');
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
