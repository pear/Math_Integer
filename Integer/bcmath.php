<?php

include_once 'Math/Integer/common.php';

bcscale(0);

class Math_Integer_BCMATH extends Math_Integer_Common {
	
	function Math_Integer_BCMATH($value) {
		$this->setValue($value);
	}

	function &clone() {
		return new Math_Integer_BCMATH($this->toString());
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
