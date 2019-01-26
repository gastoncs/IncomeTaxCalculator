<?php
/**
 *  * Created by PhpStorm.
 * User: Gastón Cortés
 * Date: 1/17/19
 * Time: 3:05 PM
 */

namespace IncomeTaxCalculator\Calculator\Calculators;

/**
 * Class StateTotalIncomeTax
 * Calculates the state total income from income tax
 * @package IncomeTaxCalculator\Calculator\Calculators
 */
class StateTotalIncomeTax implements CalculatorInterface
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
     * @throws \Exception
     */
    public function calculate()
    {
        try{

            $total = 0;
            foreach ($this->data as $county){
                $total = $county->getTotalIncomeTaxes() + $total;
            }
            return $total;

        }catch (\Exception $exception){
            throw $exception;
        }
    }
}