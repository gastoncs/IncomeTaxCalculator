<?php
/**
 *  * Created by PhpStorm.
 * User: Gastón Cortés
 * Date: 1/18/19
 * Time: 3:00 PM
 */

namespace IncomeTaxCalculator\Exception;


use MB2\ATRBundle\Exception\BaseException;

class ThereWhereNoCountiesInState extends BaseException
{
    public function __construct()
    {
        $errorMessage = sprintf("There are no counties in the state");
        $proposedSolution = sprintf('');

        parent::__construct($errorMessage, $proposedSolution, 0);
    }
}