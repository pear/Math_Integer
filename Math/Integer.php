<?php
//
// +----------------------------------------------------------------------+
// | PHP Version 4                                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997-2003 The PHP Group                                |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the PHP license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available at through the world-wide-web at                           |
// | http://www.php.net/license/2_02.txt.                                 |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Authors: Jesus M. Castagnetto <jmcastagnetto@php.net>                |
// +----------------------------------------------------------------------+
//
// $Id$
//

include_once 'PEAR.php';

define ('HAS_GMP', (boolean) extension_loaded('gmp'));
define ('HAS_BCMATH', (boolean) extension_loaded('bcmath'));

define ('MATH_INTEGER_AUTO', 'auto');
define ('MATH_INTEGER_STANDARD', 'standard');
define ('MATH_INTEGER_BCMATH', 'BCMATH');
define ('MATH_INTEGER_GMP', 'GMP');

$_math_integer_types = array(
                MATH_INTEGER_STANDARD,
                MATH_INTEGER_BCMATH,
                MATH_INTEGER_GMP
            );

require_once 'Math/Integer/GMP.php';
class Math_Integer {

    function create($val, $type=MATH_INTEGER_AUTO, $truncate=false) {
        if ($type == MATH_INTEGER_AUTO || $type == null) { 
            // decide what object to instantiate
            $type = Math_Integer::_selectType();
        } elseif (in_array($type, $GLOBALS['_math_integer_types'])) {
            // make sure that the lib is available
            if ($type == MATH_INTEGER_GMP && !HAS_GMP) {
                return PEAR::raiseError('GMP libary missing, cannot create object');
            } elseif ($type == MATH_INTEGER_BCMATH && !HAS_BCMATH) {
                return PEAR::raiseError('BCMATH libary missing, cannot create object');
            }
        } else { // wrong type requested
            return PEAR::raiseError('Invalid type. Expecting one of: auto, '.
                         implode(', ', $GLOBALS['_math_integer_valid_types']));
        }
        $classFile = "Math/Integer/{$type}.php";
        $className = 'Math_Integer_'. $type;
        // convert to a string representing an integer
        $value = Math_Integer::_toIntegerString($val, $type, $truncate);
        if (PEAR::isError($value)) {
            $value->addUserInfo(array(
                        'class' => 'Math_Integer',
                        'method' => 'create',
                        'params' => array(
                                'val' => $val,
                                'type' => 'MATH_INTEGER_'.strtoupper($type),
                                'truncate' => ($truncate == false) ? 'false' : 'true'
                            )
                    ));
            return $value;
        }
        // load the appropriate class file and instantiate the object
        if (include_once($classFile)) {
            $object = new $className($value);
            return $object;
        } else {
            return PEAR::raiseError("Error: could not find $classFile. Cannot ".
                                    "instantiate $className object");
        }
    }

    function createGMP($val, $truncate=false) {
        return Math_Integer::create($val, MATH_INTEGER_GMP, $truncate);
    }

    function createBCMATH($val, $truncate=false) {
        return Math_Integer::create($val, MATH_INTEGER_BCMATH, $truncate);
    }

    function createStandard($val, $truncate=false) {
        return Math_Integer::create($val, MATH_INTEGER_STANDARD, $truncate);
    }

    function _toIntegerString($val, $type=MATH_INTEGER_AUTO, $truncate=false) {
        $integerRE = '/^[[:digit:]]+$/';
        $floatRE = '/^([[:digit:]]+)\.[[:digit:]]+$/';
        $hexRE = '/^[[:xdigit:]]+$/';

        if (preg_match($integerRE, $val)) { // integer
            return strval($val);
        } elseif (preg_match($hexRE, $val)) { // hexadecimal
            // if automatic selection, set correct type
            if ($type == MATH_INTEGER_AUTO) {
                $type = Math_Integer::_selectType();
            }
            $len = strlen(trim($val));
            $value = 0;
            if ($type == MATH_INTEGER_GMP) {
                for ($i = 0; $i < $len; $i++) {
                    $c = substr($val, ($len - 1 - $i), 1);
                    $value = gmp_add($value, gmp_mul(hexdec($c),gmp_pow(16,$i)));
                }
                return gmp_strval($value);
            } elseif ($type == MATH_INTEGER_BCMATH) { 
                for ($i = 0; $i < $len; $i++) {
                    $c = substr($val, ($len - 1 - $i), 1);
                    $value = bcadd($value, bcmul(hexdec($c),bcpow(16,$i)));
                }
                return $value;
            } else { // return PEAR_Error for now
                return PEAR::raiseError('GMP or BCMATH support needed to '.
                                        'process hexadecimal integers');
            }
        } elseif (preg_match($floatRE, $val, $reg)) { // float
            if ($truncate) {
                return strval($reg[1]);
            } else {
                return PEAR::raiseError('Not an integer. For truncation '.
                            'of a floating point number set $truncate=true');
            }
        } else {
            return PEAR::raiseError("Invalid value: $val does not represent an integer");
        }
    }

    function _selectType() {
        if (HAS_GMP) {
            $selectedType = MATH_INTEGER_GMP;
        } elseif (HAS_BCMATH) {
            $selectedType = MATH_INTEGER_BCMATH;
        } else {
            $selectedType = MATH_INTEGER_STANDARD;
        }
        return $selectedType;
    }
    
}/* end of Math_Integer }}}*/

// vim: ts=4:sw=4:et:
// vim6: fdl=1:
?>
