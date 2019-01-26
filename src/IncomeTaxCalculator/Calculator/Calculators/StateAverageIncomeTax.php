<?php
/**
 *  * Created by PhpStorm.
 * User: Gastón Cortés
 * Date: 1/17/19
 * Time: 4:04 PM
 */

namespace IncomeTaxCalculator\Calculator\Calculators;

/**
 * Class StateAverageIncomeTax
 * Calculates the state average income tax
 * @package IncomeTaxCalculator\Calculator\Calculators
 */
class StateAverageIncomeTax  implements CalculatorInterface
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

            return $total/count($this->data);

        }catch (\Exception $exception){
            throw $exception;
        }
    }
}