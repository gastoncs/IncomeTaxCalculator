<?php
/**
 * Created by PhpStorm.
 * User: Gaston Cortes
 * Date: 1/16/19
 * Time: 2:16 PM
 */

namespace IncomeTaxCalculator\IncomeTaxRate;


interface IncomeTaxRate
{
    public function getRate();
}