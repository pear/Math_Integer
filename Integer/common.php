<?php

include_once 'PEAR.php';

class Math_Integer_Common {

	var $_value;
	
	function Math_Integer_Common($value) {
		$this->setValue($value);
	}

	function toString() {
		return strval($this->_value);
	}

	function clone() {
		return new Math_Integer_Common($this->toString());
	}

	function setValue($value) {
		$this->_value = $value;
	}

	function getValue() {
		return $this->_value;
	}

	function negate() {
		return $this->_noImplemented('negate');
	}

	function abs() {
		return $this->_noImplemented('abs');
	}

	function add(&$int) {
		return $this->_noImplemented('add');
	}

	function inc() {
		return $this->_noImplemented('inc');
	}

	function sub(&$int) {
		return $this->_noImplemented('sub');
	}

	function dec() {
		return $this->_noImplemented('dec');
	}

	function mul(&$int) {
		return $this->_noImplemented('mul');
	}

	function div(&$int) {
		return $this->_noImplemented('div');
	}

	function pow(&$int) {
		return $this->_noImplemented('pow');
	}

	function powmod(&$int) {
		return $this->_noImplemented('pow');
	}

	function sqrt(&$int) {
		return $this->_noImplemented('sqrt');
	}

	function mod(&$int) {
		return $this->_noImplemented('mod');
	}

	function compare(&$int) {
		return $this->_noImplemented('compare');
	}

	function sign(&$int) {
		return $this->_noImplemented('sign');
	}

	function isOdd() {
		return $this->_noImplemented('isOdd');
	}

	function isEven() {
		return $this->_noImplemented('isEven');
	}

	function isPositive() {
		return $this->_noImplemented('isPositive');
	}

	function isNegative() {
		return $this->_noImplemented('isNegative');
	}

	function isZero() {
		return $this->_noImplemented('isZero');
	}

	function _is(&$obj, $classname) {
		if (!is_object($obj)) {
			return false;
		}
		if (function_exists('is_a')) {
			return is_a($obj, $classname);
		} else {
			return get_class($obj) == strtolower($classname);
		}
	}

	function _notImplemented($func) {
		return PEAR::raiseError("Method $func not implemented");
	}
}

?>
