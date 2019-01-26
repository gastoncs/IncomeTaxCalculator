<?php
/**
 *  * Created by PhpStorm.
 * User: Gastón Cortés
 * Date: 1/17/19
 * Time: 4:17 PM
 */

namespace IncomeTaxCalculator\Calculator\Calculators;

use IncomeTaxCalculator\Exception\ThereWhereNoCountiesInState;

/**
 * Class StateAverageTaxRate
 * Calculates the state average tax rate
 * @package IncomeTaxCalculator\Calculator\Calculators
 */
class StateAverageTaxRate implements CalculatorInterface
{
    private $data;

    /**
     * Sets the an array from where we are getting the data to compute
     *
     * @param array $data
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }

    /**
     * Start the calculation
     *
     * @return float|int
     * @throws ThereWhereNoCountiesInState
     * @throws \Exception
     */
    public function calculate()
    {
        if(count($this->data) == 0){
            throw new ThereWhereNoCountiesInState();
        }

        try{
            $total = 0;
            foreach ($this->data as $county){
                $total = $county->getIncomeTaxRate() + $total;
            }

            return $total/count($this->data);

        }catch (\Exception $exception){
            throw $exception;
        }
    }
}