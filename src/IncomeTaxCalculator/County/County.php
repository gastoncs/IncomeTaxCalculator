<?php
/**
 *  * Created by PhpStorm.
 * User: Gastón Cortés
 * Date: 1/16/19
 * Time: 8:02 PM
 */

namespace IncomeTaxCalculator\County;

use IncomeTaxCalculator\Exception\TaxRateWasNotValid;
use IncomeTaxCalculator\IncomeTaxRate\IncomeTaxRate;

/**
 * Class County
 * Holds the county share functionality
 * @package IncomeTaxCalculator\County
 */
abstract class County
{
    private $income;
    private $incomeTaxRate;

    /**
     * County constructor.
     * @param $income
     * @param IncomeTaxRate $incomeTaxRate
     * @throws \Exception
     */
    protected function __construct($income, IncomeTaxRate $incomeTaxRate)
    {
        if(is_null($income) || !is_numeric($income) ){
            throw new \Exception("Please set the income");
        }

        $this->income = $income;
        $this->incomeTaxRate = $incomeTaxRate;
    }

    /**
     * Returns the Income tax rate from the county
     *
     * @return float
     * @throws TaxRateWasNotValid
     */
    public function getIncomeTaxRate()
    {
        $taxRate = $this->incomeTaxRate->getRate();

        if($taxRate > 1){
            throw new TaxRateWasNotValid();
        }

        return $taxRate;
    }

    /**
     * Returns the total income from tax income of the county
     *
     * @return float|int
     * @throws TaxRateWasNotValid
     */
    public function getTotalIncomeTaxes()
    {
        $taxRate = $this->incomeTaxRate->getRate();

        if($taxRate > 1){
            throw new TaxRateWasNotValid();
        }

        return $this->income * $this->incomeTaxRate->getRate();
    }
}