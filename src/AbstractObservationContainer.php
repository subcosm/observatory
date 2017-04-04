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
 * Class ObservationContainer
 * @package Subcosm\Observatory
 */
abstract class AbstractObservationContainer implements ObservationContainerInterface
{
    /**
     * @var object
     */
    protected $origin;

    /**
     * @var string
     */
    protected $stage;

    /**
     * AbstractObservationContainer constructor.
     * @param $object
     * @param string $stage
     * @throws ObservatoryException
     */
    public function __construct($object, string $stage)
    {
        if ( ! is_object($object) ) {
            throw new ObservatoryException('Object parameter must be an object, '.gettype($object).' given');
        }

        $this->origin = $object;
        $this->stage = $stage;
    }

    /**
     * checks whether the current container was send by the provided interface.
     *
     * @param string $interface
     * @return bool
     */
    public function isOrigin(string $interface): bool
    {
        return is_a($this->origin, $interface);
    }

    /**
     * checks whether the current container was send for the provided case-insensitive stage (method).
     *
     * @param string $stage
     * @return bool
     */
    public function isStage(string $stage): bool
    {
        return strtolower($this->stage) === strtolower($stage);
    }

}