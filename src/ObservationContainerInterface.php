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


interface ObservationContainerInterface
{
    /**
     * checks whether the current container was send by the provided interface.
     *
     * @param string $interface
     * @return bool
     */
    public function isOrigin(string $interface): bool;

    /**
     * checks whether the current container was send for the provided case-insensitive stage (method).
     *
     * @param string $stage
     * @return bool
     */
    public function isStage(string $stage): bool;
}