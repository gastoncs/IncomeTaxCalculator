<?php
/**
 * Created by PhpStorm.
 * User: Gaston Cortes
 * Date: 1/16/19
 * Time: 2:11 PM
 */

namespace IncomeTaxCalculator\County\Texas;


use IncomeTaxCalculator\County\County;
use IncomeTaxCalculator\IncomeTaxRate\IncomeTaxRate;

class Andrews extends County
{
    public function __construct($income, IncomeTaxRate $incomeTaxRate)
    {
        parent::__construct($income, $incomeTaxRate);
    }
}