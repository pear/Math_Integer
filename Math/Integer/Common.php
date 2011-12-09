<?php

include_once 'PEAR.php';

class Math_Integer_Common {

    var $_value;
    
    function __construct($value) {
        $this->setValue($value);
    }

    function toString() {
        return strval($this->_value);
    }

    function makeClone() {
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

    function fact() {
        return $this->_noImplemented('fact');
    }

    function add(Math_Integer $int) {
        return $this->_noImplemented('add');
    }

    function inc() {
        return $this->_noImplemented('inc');
    }

    function sub(Math_Integer $int) {
        return $this->_noImplemented('sub');
    }

    function dec() {
        return $this->_noImplemented('dec');
    }

    function mul(Math_Integer $int) {
        return $this->_noImplemented('mul');
    }

    function div(Math_Integer $int) {
        return $this->_noImplemented('div');
    }

    function pow(Math_Integer $int) {
        return $this->_noImplemented('pow');
    }

    function powmod(Math_Integer $int) {
        return $this->_noImplemented('pow');
    }

    function sqrt() {
        return $this->_noImplemented('sqrt');
    }

    function mod(Math_Integer $int) {
        return $this->_noImplemented('mod');
    }

    function compare(Math_Integer $int) {
        return $this->_noImplemented('compare');
    }

    function sign(Math_Integer $int) {
        return $this->_noImplemented('sign');
    }

    function gcd(Math_Integer $int) {
        return $this->_noImplemented('gcd');
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

    function isPrime($reps) {
        return $this->_noImplemented('probPrime');
    }

    function _is($obj, $classname) {
        if (!is_object($obj)) {
            return false;
        }
        if (function_exists('is_a')) {
            return is_a($obj, $classname);
        } else {
            return strtolower(get_class($obj)) == strtolower($classname);
        }
    }

    function _notImplemented($func) {
        return PEAR::raiseError("Method $func not implemented");
    }
}

?>
