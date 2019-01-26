<?php
/**
 *  * Created by PhpStorm.
 * User: Gastón Cortés
 * Date: 1/17/19
 * Time: 4:04 PM
 */

namespace IncomeTaxCalculator\Calculator\Calculators;

/**
 * Class CountryAverageTaxRate
 * Calculates the country average tax rate
 * @package IncomeTaxCalculator\Calculator\Calculators
 */
class CountryAverageTaxRate  implements CalculatorInterface
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
            $i = 0;
            foreach ($this->data as $states){
                foreach ($states->getCounties() as $county){
                    $total = $county->getIncomeTaxRate() + $total;
                    $i++;
                }
            }

            return $total/$i;

        }catch (\Exception $exception){
            throw $exception;
        }
    }
}