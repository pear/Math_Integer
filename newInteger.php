<?php
include_once 'PEAR.php';

// allow for user override of the integer library to use
if (!defined('MATH_INTLIB')) {
    if (extension_loaded('gmp')) {
        define ('MATH_INTLIB', 'gmp');
    } elseif (extension_loaded('bcmath')) {
        define ('MATH_INTLIB', 'bcmath');
        bcscale(0);
    } else {
        define ('MATH_INTLIB', 'standard');
    }
}

$_math_integer_valid_types = array('standard', 'gmp', 'bcmath');

class Math_Integer {

	function &create($val, $type='auto') {
		$value = Math_Integer::_toDecimalString($val);
		if (PEAR::isError($value)) {
			return $value;
		}
		if ($type == 'auto') {
			$classFile = 'Math/Integer/'.MATH_INTLIB.'php';
			$className = 'Math_Integer_'.ucfirst(MATH_INTLIB);
		} elseif (in_array($type, $GLOBALS['_math_integer_valid_types'])) {
			$classFile = "Math/Integer/{$type}.php";
			$className = 'Math_Integer_'.ucfirst($type);
			if(@include_once($classFile)) {
				return new $className($value);
			}
		} else {
			return PEAR::raiseError('Invalid type. Expecting one of: auto, '.
						 implode(', ', $GLOBALS['_math_integer_valid_types']));
		}
		// load the appropriate class file
		if(@include_once($classFile)) {
			return new $className($value);
		} else {
			return PEAR::raiseError("Error: could not find $classFile. Cannot ".
									"instantiate $className object");
		}
	}

	function &createGMP() {
		return Math_Integer::create($val, 'gmp');
	}

	function &createBCMATH() {
		return Math_Integer::create($val, 'bcmath');
	}

	function &createStandard() {
		return Math_Integer::create($val, 'standard');
	}

	function _toDecimalString($val) {
		$integerRE = '/^[[:digit:]]+$/';
		$hexRE = '/^[[:xdigit:]]+$/';
		$validFloatRE = '/^[[:digit:]]+\.0+$/';

		if (preg_match($integerRE, $val)) {
			return strval($val);
		} elseif (preg_match($validFloatRE, $val)) {
			return strval(floor($val));
		} elseif (preg_match($hexRE, $val)) {
			// this is kludgy but sure to work
			$hexs = explode("\n", chunk_split($val, 2, "\n"));
			$value = 0.0;
			foreach ($hexs as $hex) {
				$value += floatval(hexdec($hex));
			}
			return strval(floor($value));
		} else {
			return PEAR::raisError("Invalid value: $val does not represent an integer");
		}
	}
}


?>
