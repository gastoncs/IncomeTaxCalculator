<?php
/**
 *  * Created by PhpStorm.
 * User: Gastón Cortés
 * Date: 1/16/19
 * Time: 7:47 PM
 */

namespace IncomeTaxCalculator\State;

use IncomeTaxCalculator\Calculator\CalculatorFactoryInterface;
use IncomeTaxCalculator\County\County;
use IncomeTaxCalculator\Exception\ThereWhereNoCountiesInState;

/**
 * Class State
 * Holds the state share functionality
 * @package IncomeTaxCalculator\State
 */
abstract class State
{
    private $counties = [];
    private $calculatorFactory;

    /**
     * Adds a county to the country
     * @param County $county
     */
    public function addCounty(County $county)
    {
        $this->counties[] = $county;
    }

    /**
     * Gets all counties
     * @return array
     */
    public function getCounties()
    {
        return $this->counties;
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
     * @param $type string
     * @return float|int
     * @throws \Exception
     */
    public function calculate($type)
    {
        try{

            if(count($this->counties) == 0){
                throw new ThereWhereNoCountiesInState();
            }

            $calculator = $this->calculatorFactory->createCalculator($type);
            $calculator->setData($this->counties);

            return $calculator->calculate();

        }catch (\Exception $exception){
            throw $exception;
        }
    }
}