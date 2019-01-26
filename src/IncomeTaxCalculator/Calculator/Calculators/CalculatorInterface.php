<?php
/**
 *  * Created by PhpStorm.
 * User: Gastón Cortés
 * Date: 1/17/19
 * Time: 3:06 PM
 */

namespace IncomeTaxCalculator\Calculator\Calculators;


interface CalculatorInterface
{
    public function setData(array $data);
    public function calculate();

}