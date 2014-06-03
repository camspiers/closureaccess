<?php

namespace Camspiers;

/**
 * @package Camspiers
 */
class ClosureAccessTest extends \PHPUnit_Framework_TestCase
{
    public function testMethodCanBeAccessedAsProperty()
    {
        $mock = $this->getMockBuilder(__NAMESPACE__.'\ClosureAccess')
            ->setMethods(['multiply'])
            ->getMockForTrait();
        
        $mock->expects($this->once())
            ->method('multiply')
            ->with($this->equalTo(2), $this->equalTo(2))
            ->willReturn(4);
        
        $fn = $mock->multiply;
        
        $this->assertEquals(4, $fn(2, 2));
    }


    public function testPropertyOnObjectCanBeExecutedAsPublicMethod()
    {
        $mock = $this->getMockForTrait(__NAMESPACE__.'\ClosureAccess');
        
        $called = false;

        $mock->test = function () use (&$called) {
            $called = true;
            return func_get_args();
        };
        
        $args = $mock->test(2, 2);
        
        $this->assertTrue($called);
        $this->assertEquals(array(2, 2), $args);
    }
}