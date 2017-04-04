<?php
/**
 * This file is part of the subcosm.
 *
 * (c)2017 Matthias Kaschubowski
 *
 * This code is licensed under the MIT license,
 * a copy of the license is stored at the project root.
 */

namespace Subcosm\Tests\Observatory;

use Subcosm\Observatory\AbstractObservationContainer;
use PHPUnit\Framework\TestCase;
use Subcosm\Observatory\ObservableInterface;
use Subcosm\Observatory\ObservableTrait;
use Subcosm\Observatory\ObservationContainerInterface;

class AbstractObservationContainerTest extends TestCase
{
    /**
     * @var ObservationContainerInterface
     */
    protected $concreteContainer;

    public function setUp()
    {
        $observable = new class implements ObservableInterface {
            use ObservableTrait;
        };

        $this->concreteContainer = new class($observable, 'something') extends AbstractObservationContainer {
            public function getObservable(): ObservableInterface
            {
                return $this->origin;
            }
        };
    }

    /**
     * @test
     * @expectedException \Subcosm\Observatory\Exception\ObservatoryException
     */
    public function WrongParameterTest()
    {
        $instance = new class('wrong type', 'something') extends AbstractObservationContainer {};
    }

    /**
     * @test
     */
    public function returnTest()
    {
        $this->assertTrue($this->concreteContainer->isOrigin(ObservableInterface::class));
        $this->assertfalse($this->concreteContainer->isOrigin(\stdClass::class));
        $this->assertTrue($this->concreteContainer->isStage('something'));
        $this->assertFalse($this->concreteContainer->isStage('anything'));
    }
}
