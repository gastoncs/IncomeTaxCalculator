<?php
/**
 *  * Created by PhpStorm.
 * User: Gastón Cortés
 * Date: 1/17/19
 * Time: 3:12 PM
 */

namespace IncomeTaxCalculator\Calculator;


interface CalculatorFactoryInterface
{
    public function addCalculatorFactory($type, callable $factory);
    public function createCalculator($type);
}