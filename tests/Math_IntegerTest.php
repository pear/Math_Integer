<?php
require_once 'PHPUnit/Framework.php';
require_once 'Math/Integer.php';


class Math_IntegerTest extends PHPUnit_Framework_TestCase {
    
    public function setUp() {
        if (!extension_loaded('gmp')) {
            $this->markTestSkipped( "Missing gmp extension");
        }

        $this->int = Math_Integer::create('22331242343213222231423234234234234234234111232123.1', MATH_INTEGER_GMP, true);
        $this->hint = Math_Integer::create('efaaffadadfadad11234dfaed9002123346678878', MATH_INTEGER_GMP, true);
    }

    public function testToIntegerString1() {
        $this->assertSame("5124168876805615", Math_Integer::_toIntegerString('012346789abcdef')); 
    }

    public function testToIntegerString2() {
        $this->assertSame("21892195098298702144417118276090206103627679369336", Math_Integer::_toIntegerString('efaaffadadfadad11234dfaed9002123346678878')); 
    }

    public function testToIntegerString3() {
        $this->assertSame('22331242343213222231423234234234234234234111232123', Math_Integer::_toIntegerString('22331242343213222231423234234234234234234111232123.0000000', MATH_INTEGER_AUTO, true)); 

    }

    public function testToIntegerString4() {
        $result = Math_Integer::_toIntegerString('22331242343213222231423234234234234234234111232123.1'); 

        $this->assertTrue(PEAR::isError($result));
    }

    public function testToIntegerString5() {
        $this->assertSame('22331242343213222231423234234234234234234111232123', Math_Integer::_toIntegerString('22331242343213222231423234234234234234234111232123.1', MATH_INTEGER_AUTO, true)); 
    }

    public function testToString1() {
        $this->assertSame('22331242343213222231423234234234234234234111232123', $this->int->toString());
    }

    public function testToString2() {
        $this->assertSame('21892195098298702144417118276090206103627679369336', $this->hint->toString());
    }

    public function testAdd1() {
        $this->int->add($this->hint);

        $this->assertSame("44223437441511924375840352510324440337861790601459", $this->int->toString(), "Failed to correctly add");
    }

    public function testAdd2() {
        $result = $this->int->add($foo = "1234");

        $this->assertTrue(PEAR::isError($result));
    }


    public function testGcd() {
        $gcd = '12341123342312422313245';

        $tmp1 = Math_Integer::create($gcd);
        $tmp2 = $tmp1->makeClone();
        $tmp1->mul(Math_Integer::create(3));
        $tmp2->mul(Math_Integer::create(5));
        $v1 = $tmp1->toString();
        $v2 = $tmp2->toString();

        $i1 = Math_Integer::create($v1, MATH_INTEGER_GMP);
        $i2 = Math_Integer::create($v2, MATH_INTEGER_GMP);

        $i3 = $i1->gcd($i2);
        $this->assertSame("12341123342312422313245", $i3->toString(), "GMP gcd($v1, $v2)");

        $i3 = $i2->gcd($i1);
        $this->assertSame("12341123342312422313245", $i3->toString(), "GMP gcd($v2, $v1)");


        $i1 = Math_Integer::create($v1, MATH_INTEGER_BCMATH);
        $i2 = Math_Integer::create($v2, MATH_INTEGER_BCMATH);
        $i3 = $i1->gcd($i2);
        $this->assertSame("12341123342312422313245", $i3->toString(), "BCMATH gcd($v1, $v2)");
        $i3 = $i2->gcd($i1);
        $this->assertSame("12341123342312422313245", $i3->toString(), "BCMATH gcd($v2, $v1)");

    }

    public function testFact() {

        $val = '30';
        $i1 = Math_Integer::create($val, MATH_INTEGER_GMP);
        $this->assertSame('30', $i1->toString());

        $err = $i1->fact();
        $this->assertTrue($err);
        $fact1 = $i1->toString();
        $this->assertSame("265252859812191058636308480000000", $fact1);


        $i1 = Math_Integer::create($val, MATH_INTEGER_BCMATH);
        $this->assertSame('30', $i1->toString());
        $err = $i1->fact();
        $this->assertTrue($err);
        $fact2 = $i1->toString();
        $this->assertSame("265252859812191058636308480000000", $fact2);

        $this->assertSame($fact1, $fact2, "GMP and BCMATH gave different results");
    }
}
?>
