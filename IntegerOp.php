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

include_once 'Math/Integer.php';

/**
 * Class implementing operations on Math_Integer objects. If available it
 * will use the GMP or BCMATH libraries. Will default to the standard PHP
 * integer representation otherwise.
 * 
 * The operations are implemented as static methods of the class.
 *
 * @author  Jesus M. Castagnetto <jmcastagnetto@php.net>
 * @version 0.9
 * @access  public
 * @package Math_Integer
 */
class Math_IntegerOp {/*{{{*/

    /**
     * Checks if the given parameter is a Math_Integer object
     *
     * @param object Math_Integer $int1
     * @return boolean TRUE if parameter is an instance of Math_Integer, FALSE otherwise
     * @access public
     */
    function isInteger(&$int) {/*{{{*/
        return get_class($int) != 'math_integer_common' 
                && is_subclass_of($int, 'math_integer_common');
    }/*}}}*/

    /**
     * Checks if the Math_Integer object is Odd
     *
     * @param object Math_Integer $int1
     * @return mixed TRUE if Math_Integer object is odd, FALSE if it is not, PEAR_Error on error.
     * @access public
     */
    function isOdd(&$int) {/*{{{*/
        $err = Math_IntegerOp::_validInt($int);
        if (PEAR::isError($err)) {
            return $err;
        }
        return $int->isOdd();
    }/*}}}*/

    /**
     * Checks if the Math_Integer object is even
     *
     * @param object Math_Integer $int1
     * @return mixed TRUE if Math_Integer object is even, FALSE if it is not, PEAR_Error on error.
     * @access public
     */
    function isEven(&$int) {/*{{{*/
        $err = Math_IntegerOp::_validInt($int);
        if (PEAR::isError($err)) {
            return $err;
        }
        return $int->isEven();
    }/*}}}*/

    /**
     * Checks if the Math_Integer object is positive
     *
     * @param object Math_Integer $int1
     * @return mixed TRUE if Math_Integer object is positive, FALSE if it is not, PEAR_Error on error.
     * @access public
     */
    function isPositive(&$int) {/*{{{*/
        $err = Math_IntegerOp::_validInt($int);
        if (PEAR::isError($err)) {
            return $err;
        }
        return $int->isPositive();
    }/*}}}*/

    /**
     * Checks if the Math_Integer object is negative
     *
     * @param object Math_Integer $int1
     * @return mixed TRUE if Math_Integer object is negative, FALSE if it is not, PEAR_Error on error.
     * @access public
     */
    function isNegative(&$int) {/*{{{*/
        $err = Math_IntegerOp::_validInt($int);
        if (PEAR::isError($err)) {
            return $err;
        }
        return $int->isNegative();
    }/*}}}*/

    /**
     * Checks if the Math_Integer object is zero
     *
     * @param object Math_Integer $int1
     * @return mixed TRUE if Math_Integer object is zero, FALSE if it is not, PEAR_Error on error.
     * @access public
     */
    function isZero(&$int) {/*{{{*/
        $err = Math_IntegerOp::_validInt($int);
        if (PEAR::isError($err)) {
            return $err;
        }
        return $int->isZero();
    }/*}}}*/

    /**
     * Add two Math_Integer objects: $i1 + $i2
     *
     * @param object Math_Integer $int1
     * @param object Math_Integer $int2
     * @return object Math_Integer on success, PEAR_Error otherwise
     * @access public
     */
    function &add(&$int1, &$int2) {/*{{{*/
        if (PEAR::isError($err = Math_IntegerOp::_validInts($int1, $int2))) {
            return $err;
        }
        $res = $int1->clone();
        $err = $res->add($int2);
        if (PEAR::isError($err)) {
            return $err;
        }
        return $res;
    }/*}}}*/

    /**
     * Substract two Math_Integer objects: $i1 - $i2
     *
     * @param object Math_Integer $int1
     * @param object Math_Integer $int2
     * @return object Math_Integer on success, PEAR_Error otherwise
     * @access public
     */
    function &sub(&$int1, &$int2) {/*{{{*/
        if (PEAR::isError($err = Math_IntegerOp::_validInts($int1, $int2))) {
            return $err;
        }
        $res = $int1->clone();
        $err = $res->sub($int2);
        if (PEAR::isError($err)) {
            return $err;
        }
        return $res;
    }/*}}}*/

    /**
     * Multiply two Math_Integer objects: $i1 * $i2
     *
     * @param object Math_Integer $int1
     * @param object Math_Integer $int2
     * @return object Math_Integer on success, PEAR_Error otherwise
     * @access public
     */
    function &mul(&$int1, &$int2) {/*{{{*/
        if (PEAR::isError($err = Math_IntegerOp::_validInts($int1, $int2))) {
            return $err;
        }
        $res = $int1->clone();
        $err = $res->mul($int2);
        if (PEAR::isError($err)) {
            return $err;
        }
        return $res;
    }/*}}}*/

    /**
     * Divide two Math_Integer objects: $i1 / $i2
     *
     * @param object Math_Integer $int1
     * @param object Math_Integer $int2
     * @return object Math_Integer on success, PEAR_Error otherwise
     * @access public
     */
    function &div(&$int1, &$int2) {/*{{{*/
        if (PEAR::isError($err = Math_IntegerOp::_validInts($int1, $int2))) {
            return $err;
        }
        $res = $int1->clone();
        $err = $res->div($int2);
        if (PEAR::isError($err)) {
            return $err;
        }
        return $res;
    }/*}}}*/

    /**
     * Calculate the modulus of $i1 and $i2: $i1 % $i2
     *
     * @param object Math_Integer $int1
     * @param object Math_Integer $int2
     * @return object Math_Integer on success, PEAR_Error otherwise
     * @access public
     */
    function &mod(&$int1, &$int2) {/*{{{*/
        if (PEAR::isError($err = Math_IntegerOp::_validInts($int1, $int2))) {
            return $err;
        }
        $res = $int1->clone();
        $err = $res->mod($int2);
        if (PEAR::isError($err)) {
            return $err;
        }
        return $res;
    }/*}}}*/

    /**
     * Raise $i1 to the $i2 exponent: $i1^$i2
     *
     * @param object Math_Integer $int1
     * @param object Math_Integer $int2
     * @return object Math_Integer on success, PEAR_Error otherwise
     * @access public
     */
    function &pow(&$int1, &$int2) {/*{{{*/
        if (PEAR::isError($err = Math_IntegerOp::_validInts($int1, $int2))) {
            return $err;
        }
        $res = $int1->clone();
        $err = $res->pow($int2);
        if (PEAR::isError($err)) {
            return $err;
        }
        return $res;
    }/*}}}*/

    /**
     * Calculates the GCD of 2 Math_Integer objects
     *
     * @param object Math_Integer $int1
     * @param object Math_Integer $int2
     * @return mixed and integer on success, PEAR_Error otherwise
     * @access public
     * @see Math_IntegerOp::sign
     */
    function &gcd(&$int1, &$int2) {/*{{{*/
        if (PEAR::isError($err = Math_IntegerOp::_validInts($int1, $int2))) {
            return $err;
        }
        return $int1->gcd($int2);
    }/*}}}*/

    /**
     * Compare two Math_Integer objects.
     * if $i1 > $i2, returns +1,
     * if $i1 == $i2, returns +0,
     * if $i1 < $i2, returns -1,
     *
     * @param object Math_Integer $int1
     * @param object Math_Integer $int2
     * @return mixed and integer on success, PEAR_Error otherwise
     * @access public
     * @see Math_IntegerOp::sign
     */
    function &compare(&$int1, &$int2) {/*{{{*/
        if (PEAR::isError($err = Math_IntegerOp::_validInts($int1, $int2))) {
            return $err;
        }
        return $int1->compare($int2);
    }/*}}}*/

    /**
     * Returns the sign of a Math_Integer number
     * if $i1 > 0, returns +1,
     * if $i1 == 0, returns +0,
     * if $i1 < 0, returns -1,
     *
     * @param object Math_Integer $int1
     * @return mixed and integer on success, PEAR_Error otherwise
     * @access public
     */
    function &sign(&$int1) {/*{{{*/
        if (PEAR::isError($err = Math_IntegerOp::_validInt($int1))) {
            return $err;
        }
        return $int1->sign();
    }/*}}}*/

    /**
     * Returns the negative of a Math_Integer number: -1 * $i1
     *
     * @param object Math_Integer $int1
     * @return object Math_Integer on success, PEAR_Error otherwise
     * @access public
     */
    function &negate(&$int1) {/*{{{*/
        if (PEAR::isError($err = Math_IntegerOp::_validInt($int1))) {
            return $err;
        }
        $res = $int1->clone();
        $err = $res->negate();
        if (PEAR::isError($err)) {
            return $err;
        }
        return $res;
    }/*}}}*/

    /**
     * Returns the (integer) square root of a Math_Integer number
     *
     * @param object Math_Integer $int1
     * @return object Math_Integer on success, PEAR_Error otherwise
     * @access public
     */
    function &sqrt(&$int1) {/*{{{*/
        if (PEAR::isError($err = Math_IntegerOp::_validInt($int1))) {
            return $err;
        }
        $res = $int1->clone();
        $err = $res->sqrt();
        if (PEAR::isError($err)) {
            return $err;
        }
        return $res;
    }/*}}}*/

    /**
     * Returns the absolute value of a Math_Integer number
     *
     * @param object Math_Integer $int1
     * @return object Math_Integer on success, PEAR_Error otherwise
     * @access public
     */
    function &abs(&$int1) {/*{{{*/
        if (PEAR::isError($err = Math_IntegerOp::_validInt($int1))) {
            return $err;
        }
        $res = $int1->clone();
        $err = $res->abs();
        if (PEAR::isError($err)) {
            return $err;
        }
        return $res;
    }/*}}}*/

    /**
     * Checks that the 2 passed objects are valid Math_Integer numbers.
     * The objects must be instances of Math_Integer and have been properly
     * initialized.
     *
     * @param object Math_Integer $int1
     * @param object Math_Integer $int2
     * @return mixed TRUE if both are Math_Integer objects, PEAR_Error otherwise
     * @access private
     */
    function _validInts(&$int1, &$int2) {/*{{{*/
        $err1 = Math_IntegerOp::_validInt($int1);
        $err2 = Math_IntegerOp::_validInt($int2);
        $error = '';
        if (PEAR::isError($err1)) {
            $error .= 'First parameter: '.$err1->getMessage();
        }
        if (PEAR::isError($err2)) {
            $error .= ' Second parameter: '.$err2->getMessage();
        }
        if (!empty($error)) {
            return PEAR::raiseError($error);
        } else {
            return true;
        }
    }/*}}}*/

    /**
     * Checks that the passed object is a valid Math_Integer number.
     * The object must be an instance of Math_Integer and have been properly
     * initialized.
     *
     * @param object Math_Integer $int1
     * @return mixed TRUE if is a Math_Integer object, PEAR_Error otherwise
     * @access private
     */
    function _validInt(&$int1) {/*{{{*/
        $error = '';
        if (!Math_IntegerOp::isInteger($int1)) {
            $error = 'Is not an Integer object.';
        } elseif (is_null($int1->getValue())) {
            $error = 'Integer object is uninitalized.';
        }
        if (!empty($error)) {
            return PEAR::raiseError($error);
        } else {
            return true;
        }
    }/*}}}*/
}/*}}} end of Math_IntegerOp */

// vim: ts=4:sw=4:et:
// vim6: fdl=1:
?>
