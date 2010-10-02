<?php

if (!defined('PHPUnit_MAIN_METHOD')) {
    define('PHPUnit_MAIN_METHOD', 'Math_Integer_AllTests::main');
}

require_once 'PHPUnit/TextUI/TestRunner.php';

require_once 'Math_IntegerTest.php';

class Math_Integer_AllTests
{
    public static function main()
    {
        PHPUnit_TextUI_TestRunner::run(self::suite());
    }

    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('PEAR - Math_Integer');

        $suite->addTestSuite('Math_IntegerTest');

        return $suite;
    }
}

if (PHPUnit_MAIN_METHOD == 'Math_Integer_AllTests::main') {
    Math_Integer_AllTests::main();
}
