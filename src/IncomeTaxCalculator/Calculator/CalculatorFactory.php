<?php
/**
 *  * Created by PhpStorm.
 * User: Gastón Cortés
 * Date: 1/17/19
 * Time: 3:08 PM
 */

namespace IncomeTaxCalculator\Calculator;

/**
 * Class CalculatorFactory
 *
 * @package IncomeTaxCalculator\Calculator
 */
class CalculatorFactory implements CalculatorFactoryInterface
{
    private $factories = [];

    public function addCalculatorFactory($type, callable $factory)
    {
        $this->factories[$type] = $factory;
    }

    public function createCalculator($type)
    {
        $factory = $this->factories[$type];
        return $factory();
    }
}