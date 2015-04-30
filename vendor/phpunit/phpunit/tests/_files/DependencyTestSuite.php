<?php
class DependencyTestSuite
{
    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('Tests Dependencies');

        $suite->addTestSuite('DependencySuccessTest');
        $suite->addTestSuite('DependencyFailureTest');

        return $suite;
    }
}
