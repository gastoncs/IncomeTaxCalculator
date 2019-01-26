<?php
/**
 * Created by PhpStorm.
 * User: Gaston Cortes
 * Date: 1/16/19
 * Time: 2:18 PM
 */

namespace IncomeTaxCalculator\IncomeTaxRate;


class IncomeTaxRate40 implements IncomeTaxRate
{
    public function getRate()
    {
        return 40;
    }
}