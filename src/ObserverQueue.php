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

class ObserverQueue implements \Countable
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
     * queue invoker.
     */
    public function __invoke(ObservationContainerInterface $container)
    {
        foreach ( $this->observers as $current ) {
            $current->update($container);
        }

        return $container;
    }

    /**
     * Count elements of an object
     * @link http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     * @since 5.1.0
     */
    public function count()
    {
        return count($this->observers);
    }
}
