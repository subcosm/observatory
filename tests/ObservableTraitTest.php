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
use Subcosm\Observatory\ObservableInterface;
use Subcosm\Observatory\ObservableTrait;
use PHPUnit\Framework\TestCase;
use Subcosm\Observatory\ObservationContainerInterface;
use Subcosm\Observatory\ObserverInterface;

class ObservableTraitTest extends TestCase
{
    /**
     * @var ObservableInterface
     */
    protected $instance;

    public function setUp()
    {
        $this->instance = new class implements ObservableInterface {
            use ObservableTrait;

            public function getObserverCount(): int
            {
                return count($this->observers);
            }

            public function doNotify()
            {
                $container = new class($this, 'doNotify') extends AbstractObservationContainer {

                };

                /** @var ObservationContainerInterface $container */

                return $this->notify($container);
            }
        };
    }

    /**
     * @test
     * @expectedException \Subcosm\Observatory\Exception\ObservatoryException
     */
    public function attachFailedTest()
    {
        $observer = new class implements ObserverInterface {
            public function update(ObservationContainerInterface $container): void
            {

            }
        };

        $this->instance->attach($observer);
        $this->instance->attach($observer);
    }

    /**
     * @test
     */
    public function attachDetachTest()
    {
        $observer = new class implements ObserverInterface {
            public function update(ObservationContainerInterface $container): void
            {

            }
        };

        $this->assertEquals(0, $this->instance->getObserverCount());

        $this->instance->attach($observer);

        $this->assertEquals(1, $this->instance->getObserverCount());

        $this->instance->detach($observer);

        $this->assertEquals(0, $this->instance->getObserverCount());
    }

    /**
     * @test
     */
    public function notifyTest()
    {
        $observer = new class implements ObserverInterface {
            public function update(ObservationContainerInterface $container): void
            {
                $container->message = 'doNotify';
            }
        };

        $this->instance->attach($observer);

        $container = $this->instance->doNotify();

        $this->assertEquals('doNotify', $container->message);
    }
}
