<?php
/**
 *  * Created by PhpStorm.
 * User: Gastón Cortés
 * Date: 1/17/19
 * Time: 3:42 PM
 */

namespace Unit;

use IncomeTaxCalculator\County\Colorado\Chafee;
use IncomeTaxCalculator\County\Colorado\Denver;
use IncomeTaxCalculator\Exception\TaxRateWasNotValid;
use IncomeTaxCalculator\Exception\ThereWhereNoCountiesInState;
use IncomeTaxCalculator\Exception\ThereWhereNoStatesInCountry;
use IncomeTaxCalculator\IncomeTaxRate\IncomeTaxRate15;
use IncomeTaxCalculator\IncomeTaxRate\IncomeTaxRate40;
use IncomeTaxCalculator\State\Colorado;
use IncomeTaxCalculator\State\State;
use PHPUnit\Framework\TestCase;

use IncomeTaxCalculator\Calculator\CalculatorFactory;
use IncomeTaxCalculator\Calculator\Calculators\StateAverageIncomeTax;
use IncomeTaxCalculator\Calculator\Calculators\StateAverageTaxRate;
use IncomeTaxCalculator\Calculator\Calculators\StateTotalIncomeTax;
use IncomeTaxCalculator\County\Texas\Anderson;
use IncomeTaxCalculator\County\Texas\Andrews;
use IncomeTaxCalculator\IncomeTaxRate\IncomeTaxRate25;
use IncomeTaxCalculator\IncomeTaxRate\IncomeTaxRate32;
use IncomeTaxCalculator\State\Texas;

class StateCalculatorTest  extends TestCase
{
    /**
     * Test Total Tax Income Collected Per State
     *
     * @param $state State
     * @param array
     * @dataProvider providerStateCountyTotalIncomeTax
     */
    public function testTotalAmountOfIncomeTaxCollectedPerState($state, $counties, $expected)
    {
        foreach ($counties as $county){
            $state->addCounty($county);
        }

        $calculatorFactory = new CalculatorFactory();

        $calculatorFactory->addCalculatorFactory(
            "stateTotalIncomeTax",
            function () {
                return new StateTotalIncomeTax();
            }
        );

        $state->addTaxCalculatorFactory($calculatorFactory);

        $totalIncome = $state->calculate("stateTotalIncomeTax");

        $this->assertEquals($expected, $totalIncome);
    }

    public function providerStateCountyTotalIncomeTax()
    {
        return array(
            array(
                new Texas(),
                array(
                    new Anderson(1000, new IncomeTaxRate32()),
                    new Andrews(200,new IncomeTaxRate25())
                ),
                370
            ),
        );
    }

    /**
     * Test Average Amount of Income Tax Collected Per State
     *
     * @param $state State
     * @param array
     * @dataProvider providerStateCountyAverageIncomeTax
     */
    public function testAverageAmountOfIncomeTaxCollectedPerState($state, $counties, $expected)
    {
        foreach ($counties as $county){
            $state->addCounty($county);
        }

        $calculatorFactory = new CalculatorFactory();

        $state->addTaxCalculatorFactory($calculatorFactory);

        $calculatorFactory->addCalculatorFactory(
            "stateAverageIncomeTax",
            function () {
                return new StateAverageIncomeTax();
            }
        );

        $averageIncomeTaxes = $state->calculate("stateAverageIncomeTax");

        $this->assertEquals($expected, $averageIncomeTaxes);
    }

    public function providerStateCountyAverageIncomeTax()
    {
        return array(
            array(
                new Texas(),
                array(
                    new Anderson(1000, new IncomeTaxRate32()),
                    new Andrews(200,new IncomeTaxRate25())
                ),
                185
            ),
        );
    }

    /**
     * Test Average County Tax Rate Per State
     *
     * @param $state State
     * @param array
     * @dataProvider providerStateCountyAverageTaxRate
     */
    public function testAverageCountyTaxRatePerState($state, $counties, $expected)
    {
        foreach ($counties as $county){
            $state->addCounty($county);
        }

        $calculatorFactory = new CalculatorFactory();

        $state->addTaxCalculatorFactory($calculatorFactory);

        $calculatorFactory->addCalculatorFactory(
            "stateAverageTaxRate",
            function () {
                return new StateAverageTaxRate();
            }
        );

        $averageIncomeTaxRate = $state->calculate("stateAverageTaxRate");

        $this->assertEquals($expected, bcdiv($averageIncomeTaxRate,1,2));
    }

    public function providerStateCountyAverageTaxRate()
    {
        return array(
            array(
                new Texas(),
                array(
                    new Anderson(1000, new IncomeTaxRate32()),
                    new Andrews(200,new IncomeTaxRate25())
                ),
                .28
            ),
        );
    }

    /**
     * Exception Tests
     */
    public function testNoAssignedCountiesAverageTaxRateException()
    {
        $this->expectException(ThereWhereNoCountiesInState::class);
        $this->expectExceptionMessage("There are no counties in the state");

        $state = new Texas();

        $calculatorFactory = new CalculatorFactory();

        $state->addTaxCalculatorFactory($calculatorFactory);

        $calculatorFactory->addCalculatorFactory(
            "stateAverageTaxRate",
            function () {
                return new StateAverageTaxRate();
            }
        );

        $state->calculate("stateAverageTaxRate");
    }

    public function testNoAssignedCountiesException()
    {
        $this->expectException(ThereWhereNoCountiesInState::class);
        $this->expectExceptionMessage("There are no counties in the state");

        $state = new Texas();

        $calculatorFactory = new CalculatorFactory();

        $state->addTaxCalculatorFactory($calculatorFactory);

        $calculatorFactory->addCalculatorFactory(
            "stateTotalIncomeTax",
            function () {
                return new StateTotalIncomeTax();
            }
        );

        $state->calculate("stateTotalIncomeTax");
    }

    /**
     * Test wrong tax rate decimal
     *
     * @param $state State
     * @param array
     * @dataProvider providerStateCountyNoDecimalTaxRate
     */
    public function testNoDecimalTaxRateException($state, $counties)
    {
        $this->expectException(TaxRateWasNotValid::class);
        $this->expectExceptionMessage("The tax rate should be a decimal");

        foreach ($counties as $county){
            $state->addCounty($county);
        }

        $calculatorFactory = new CalculatorFactory();

        $state->addTaxCalculatorFactory($calculatorFactory);

        $calculatorFactory->addCalculatorFactory(
            "stateTotalIncomeTax",
            function () {
                return new StateTotalIncomeTax();
            }
        );

        $state->calculate("stateTotalIncomeTax");
    }

    public function providerStateCountyNoDecimalTaxRate()
    {
        return array(
            array(
                new Colorado(),
                array(
                    new Chafee(1000, new IncomeTaxRate40()),
                    new Denver(200,new IncomeTaxRate40())
                ),
            ),
        );
    }
}