<?php
/**
 *  * Created by PhpStorm.
 * User: Gastón Cortés
 * Date: 1/17/19
 * Time: 3:05 PM
 */

namespace IncomeTaxCalculator\Calculator\Calculators;

use IncomeTaxCalculator\Exception\ThereWhereNoCountiesInState;

/**
 * Class CountryTotalIncomeTax
 * Calculates the country total income from income tax
 * @package IncomeTaxCalculator\Calculator\Calculators
 */
class CountryTotalIncomeTax implements CalculatorInterface
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
     */
    public function calculate()
    {
        $total = 0;
        $i = 0;
        foreach ($this->data as $states){
            foreach ($states->getCounties() as $county){
                $total = $county->getTotalIncomeTaxes() + $total;
                $i++;
            }
        }

        if($i == 0){
            throw new ThereWhereNoCountiesInState();
        }

        return $total;
    }
}