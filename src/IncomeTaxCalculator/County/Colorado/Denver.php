<?php
/**
 *  * Created by PhpStorm.
 * User: Gastón Cortés
 * Date: 1/18/19
 * Time: 10:45 AM
 */

namespace IncomeTaxCalculator\County\Colorado;

use IncomeTaxCalculator\County\County;
use IncomeTaxCalculator\IncomeTaxRate\IncomeTaxRate;

class Denver extends County
{
    public function __construct($income, IncomeTaxRate $incomeTaxRate)
    {
        parent::__construct($income, $incomeTaxRate);
    }

}