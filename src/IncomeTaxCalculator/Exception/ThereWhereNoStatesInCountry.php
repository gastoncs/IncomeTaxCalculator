<?php
/**
 *  * Created by PhpStorm.
 * User: Gastón Cortés
 * Date: 1/18/19
 * Time: 3:04 PM
 */

namespace IncomeTaxCalculator\Exception;

use MB2\ATRBundle\Exception\BaseException;

class ThereWhereNoStatesInCountry extends BaseException
{
    public function __construct()
    {
        $errorMessage = sprintf("There are no states in the country");
        $proposedSolution = sprintf('');

        parent::__construct($errorMessage, $proposedSolution, 0);
    }
}