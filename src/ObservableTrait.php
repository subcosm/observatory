<?php
/**
 * This file is part of the subcosm.
 *
 * (c)2017 Matthias Kaschubowski
 *
 * This code is licensed under the MIT license,
 * a copy of the license is stored at the project root.
 */

namespace Subcosm\Observatory;


use Subcosm\Observatory\Exception\ObservatoryException;

/**
 * Class ObservableTrait
 * @package Subcosm\Observatory
 */
trait ObservableTrait
{

    /**
     * @var ObserverInterface[]
     */
    protected $observers = [];

    /**
     * attaches an observer to the observable.
     *
     * @param ObserverInterface $observer
     * @throws ObservatoryException when the provided observer is already known
     * @return void
     */
    public function attach(ObserverInterface $observer): void
    {
        $key = spl_object_hash($observer);

        if ( array_key_exists($key, $this->observers) ) {
            throw new ObservatoryException(
                'Provided observer already known, hash: '.$key
            );
        }

        $this->observers[$key] = $observer;
    }

    /**
     * detaches an observer from the observable.
     *
     * @param ObserverInterface $observer
     * @return void
     */
    public function detach(ObserverInterface $observer): void
    {
        $key = spl_object_hash($observer);

        unset($this->observers[$key]);
    }

    /**
     * notifies all observers using a observation container implementation.
     *
     * @param ObservationContainerInterface $container
     * @return ObservationContainerInterface|null
     */
    protected function notify(ObservationContainerInterface $container): ? ObservationContainerInterface
    {
        foreach ( $this->observers as $current ) {
            $current->update($container);
        }

        return $container;
    }
}