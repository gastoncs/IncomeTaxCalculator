<?php
/**
 * Created by PhpStorm.
 * User: Gaston Cortes
 * Date: 1/16/19
 * Time: 6:59 PM
 */

namespace Unit;

use IncomeTaxCalculator\County\Texas\Anderson;
use IncomeTaxCalculator\IncomeTaxRate\IncomeTaxRate25;
use PHPUnit\Framework\TestCase;

class CountyIncomeTaxTest  extends TestCase
{
    public function testNoneParameters()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Please set the income");

        $incomeTaxRate = new IncomeTaxRate25();
        new Anderson(null, $incomeTaxRate);
    }
}