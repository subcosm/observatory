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


interface ObserverInterface
{
    /**
     * method that will be invoked when an update has occurred at the observable.
     *
     * @param ObservationContainerInterface $container
     * @return void
     */
    public function update(ObservationContainerInterface $container): void;
}