<?php
/**
 *  * Created by PhpStorm.
 * User: Gastón Cortés
 * Date: 1/16/19
 * Time: 8:29 PM
 */

namespace IncomeTaxCalculator\Country;


use IncomeTaxCalculator\Calculator\CalculatorFactoryInterface;
use IncomeTaxCalculator\Exception\ThereWhereNoStatesInCountry;
use IncomeTaxCalculator\State\State;

/**
 * Class Country
 * Holds the country share functionality
 * @package IncomeTaxCalculator\Country
 */
abstract class Country
{
    private $states = [];
    private $calculatorFactory;

    /**
     * Adds a state to the country
     * @param State $state
     */
    public function addState(State $state)
    {
        $this->states[] = $state;
    }

    /**
     * Adds the Tax Calculator Factory
     * @param CalculatorFactoryInterface $calculatorFactory
     */
    public function addTaxCalculatorFactory(CalculatorFactoryInterface $calculatorFactory)
    {
        $this->calculatorFactory = $calculatorFactory;
    }

    /**
     * Gets the factory by type sets the data to calculate and run the tax calculation
     *
     * @param $type
     * @return float|int
     * @throws ThereWhereNoStatesInCountry
     */
    public function calculate($type)
    {
        if(count($this->states) == 0){
            throw new ThereWhereNoStatesInCountry();
        }

        $calculator = $this->calculatorFactory->createCalculator($type);
        $calculator->setData($this->states);
        return $calculator->calculate();
    }
}