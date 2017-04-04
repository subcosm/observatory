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


interface ObservableInterface
{
    /**
     * attaches an observer to the observable.
     *
     * @param ObserverInterface $observer
     * @return void
     */
    public function attach(ObserverInterface $observer): void;

    /**
     * detaches an observer from the observable.
     *
     * @param ObserverInterface $observer
     * @return void
     */
    public function detach(ObserverInterface $observer): void;
}