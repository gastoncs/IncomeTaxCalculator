<?php
/**
 *  * Created by PhpStorm.
 * User: Gastón Cortés
 * Date: 1/18/19
 * Time: 10:30 AM
 */

namespace IncomeTaxCalculator\County\NewMexico;


use IncomeTaxCalculator\County\County;
use IncomeTaxCalculator\IncomeTaxRate\IncomeTaxRate;

class RioArriba  extends County
{
    public function __construct($income, IncomeTaxRate $incomeTaxRate)
    {
        parent::__construct($income, $incomeTaxRate);
    }
}