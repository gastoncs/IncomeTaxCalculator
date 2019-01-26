<?php
/**
 *  * Created by PhpStorm.
 * User: Gastón Cortés
 * Date: 1/18/19
 * Time: 1:44 PM
 */

namespace IncomeTaxCalculator\Exception;


use MB2\ATRBundle\Exception\BaseException;

class TaxRateWasNotValid extends BaseException
{
    public function __construct()
    {
        $errorMessage = sprintf("The tax rate should be a decimal");
        $proposedSolution = sprintf('');

        parent::__construct($errorMessage, $proposedSolution, 0);
    }
}