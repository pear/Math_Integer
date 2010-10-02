<?php
require_once 'PHPUnit/Framework.php';
require_once 'Math/Integer.php';


class Math_IntegerTest extends PHPUnit_Framework_TestCase {
    
    public function setUp() {
        if (!extension_loaded('gmp')) {
            $this->markTestSkipped( "Missing gmp extension");
        }
    }


    public function test() {
        // Old test coverage - who knows what the expected results are.
        $h = '012346789abcdef';
        echo "INPUT: $h\n";
        echo Math_Integer::_toIntegerString($h)."\n\n"; 

        $h = 'efaaffadadfadad11234dfaed9002123346678878';
        echo "INPUT: $h\n";
        echo Math_Integer::_toIntegerString($h)."\n\n"; 

        $f = '22331242343213222231423234234234234234234111232123.0000000';
        echo "INPUT: $f\n";
        echo Math_Integer::_toIntegerString($f, MATH_INTEGER_AUTO, true)."\n\n"; 

        $f = '22331242343213222231423234234234234234234111232123.1';
        echo "INPUT: $f\n";
        print_r(Math_Integer::_toIntegerString($f)); 
        echo Math_Integer::_toIntegerString($f, MATH_INTEGER_AUTO, true)."\n"; 

        $int = Math_Integer::create($f, MATH_INTEGER_GMP, true);
        $hint = Math_Integer::create($h, MATH_INTEGER_GMP, true);
        print_r($int);
        echo 'Math_Integer_GMP: '.$int->toString()."\n";
        print_r($hint);
        echo 'Math_Integer_GMP: '.$hint->toString()."\n";
        $foo = $int->add($hint);
        var_dump($foo);
        echo 'Adding int to hint: '.$int->toString()."\n";
        $bad  = 1234;
        $foo = $int->add($bad);
        var_dump($foo);
  
        $gcd = '12341123342312422313245';
        echo "Fixed gcd: $gcd\n";
        $tmp1 = Math_Integer::create($gcd);
        $tmp2 = $tmp1->makeClone();
        $tmp1->mul(Math_Integer::create(3));
        $tmp2->mul(Math_Integer::create(5));
        $v1 = $tmp1->toString();
        $v2 = $tmp2->toString();

        $i1 = Math_Integer::create($v1, MATH_INTEGER_GMP);
        $i2 = Math_Integer::create($v2, MATH_INTEGER_GMP);
        $i3 = $i1->gcd($i2);
        echo "GMP gcd($v1, $v2): ".$i3->toString()."\n";
        $i3 = $i2->gcd($i1);
        echo "GMP gcd($v2, $v1): ".$i3->toString()."\n";

        $i1 = Math_Integer::create($v1, MATH_INTEGER_BCMATH);
        $i2 = Math_Integer::create($v2, MATH_INTEGER_BCMATH);
        $i3 = $i1->gcd($i2);
        echo "BCMATH gcd($v1, $v2): ".$i3->toString()."\n";
        $i3 = $i2->gcd($i1);
        echo "BCMATH gcd($v2, $v1): ".$i3->toString()."\n";

        $val = '30';
        $i1 = Math_Integer::create($val, MATH_INTEGER_GMP);
        echo "GMP int = ".$i1->toString()."\n";
        $err = $i1->fact();
        if($err == true) {
            $fact1 = $i1->toString();
            echo "GMP int! = $fact1\n";
        } else {
            print_r($err);
        }
        $i1 = Math_Integer::create($val, MATH_INTEGER_GMP);
        echo "BCMATH int = ".$i1->toString()."\n";
        $err = $i1->fact();
        if($err == true) {
            $fact2 = $i1->toString();
            echo "BCMATH int! = $fact2\n";
        } else {
            print_r($err);
        }

        $this->assertSame($fact1, $fact2, "GMP and BCMATH gave different results");
    }
}
?>
