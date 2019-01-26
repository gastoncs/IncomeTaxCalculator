<?php
/**
 *  * Created by PhpStorm.
 * User: Gastón Cortés
 * Date: 1/17/19
 * Time: 6:02 PM
 */

namespace IncomeTaxCalculator\County\California;

use IncomeTaxCalculator\County\County;
use IncomeTaxCalculator\IncomeTaxRate\IncomeTaxRate;

class Lake  extends County
{
    public function __construct($income, IncomeTaxRate $incomeTaxRate)
    {
        parent::__construct($income, $incomeTaxRate);
    }
}