<?php
/**
 *  * Created by PhpStorm.
 * User: Gastón Cortés
 * Date: 1/17/19
 * Time: 4:26 PM
 */

namespace Unit;

use IncomeTaxCalculator\Exception\ThereWhereNoCountiesInState;
use IncomeTaxCalculator\Exception\ThereWhereNoStatesInCountry;
use PHPUnit\Framework\TestCase;

use IncomeTaxCalculator\Country\Country;
use IncomeTaxCalculator\County\Arizona\LaPaz;
use IncomeTaxCalculator\County\NewMexico\RioArriba;
use IncomeTaxCalculator\IncomeTaxRate\IncomeTaxRate15;
use IncomeTaxCalculator\State\Arizona;
use IncomeTaxCalculator\State\NewMexico;
use IncomeTaxCalculator\Calculator\CalculatorFactory;
use IncomeTaxCalculator\Calculator\Calculators\CountryAverageTaxRate;
use IncomeTaxCalculator\Calculator\Calculators\CountryTotalIncomeTax;
use IncomeTaxCalculator\County\California\Alameda;
use IncomeTaxCalculator\County\California\Lake;
use IncomeTaxCalculator\State\California;
use IncomeTaxCalculator\Country\USA;
use IncomeTaxCalculator\County\Texas\Anderson;
use IncomeTaxCalculator\County\Texas\Andrews;
use IncomeTaxCalculator\IncomeTaxRate\IncomeTaxRate25;
use IncomeTaxCalculator\IncomeTaxRate\IncomeTaxRate32;
use IncomeTaxCalculator\State\Texas;


class CountryCalculatorTest extends TestCase
{
    /**
     * Test Average Tax Rate By Country
     *
     * @param $country Country
     * @param array
     * @param float
     * @dataProvider providerCountryStateCountyAverageTaxRate
     */
    public function testAverageTaxRateOfTheCountry($country, $statesCounties, $expected)
    {
        foreach ($statesCounties as $stateCounty){

            $state = $stateCounty[0];
            $counties = $stateCounty[1];

            foreach ($counties as $county){
                $state->addCounty($county);
            }

            $country->addState($state);
        }

        $calculatorFactory = new CalculatorFactory();

        $calculatorFactory->addCalculatorFactory(
            "countryAverageTaxRate",
            function () {
                return new CountryAverageTaxRate();
            }
        );

        $country->addTaxCalculatorFactory($calculatorFactory);

        $averageIncomeTaxRate = $country->calculate("countryAverageTaxRate");

        $this->assertEquals($expected, bcdiv($averageIncomeTaxRate,1,2));
    }

    public function providerCountryStateCountyAverageTaxRate()
    {
        return array(
            array(
                new USA(),
                array(
                    array(
                        new Texas(),
                        array(
                            new Anderson(1000, new IncomeTaxRate32()),
                            new Andrews(200,new IncomeTaxRate25())
                        ),
                      ),
                    array(
                        new California(),
                        array(
                            new Alameda(1000, new IncomeTaxRate32()),
                            new Lake(200,new IncomeTaxRate32())
                        ),
                    ),
                    array(
                        new Arizona(),
                        array(
                            new LaPaz(1000, new IncomeTaxRate15())
                        ),
                    ),
                    array(
                        new NewMexico(),
                        array(
                            new RioArriba(1000, new IncomeTaxRate15())
                        ),
                    ),
                ),
                .25
            )
        );
    }

    /**
     * Test Total Income Tax Collected By Country
     *
     * @param $country Country
     * @param array
     * @dataProvider providerCountryStateCountyTotalIncomeTax
     */
    public function testTotalIncomeTaxCollectedOfTheCountry($country, $statesCounties)
    {
        $expected = 0;
        foreach ($statesCounties as $stateCounty){

            $state = $stateCounty[0];
            $counties = $stateCounty[1];
            $expected = $stateCounty[2] + $expected;

            foreach ($counties as $county){
                $state->addCounty($county);
            }

            $country->addState($state);
        }

        $calculatorFactory = new CalculatorFactory();

        $calculatorFactory->addCalculatorFactory(
            "countryTotalIncomeTax",
            function () {
                return new CountryTotalIncomeTax();
            }
        );

        $country->addTaxCalculatorFactory($calculatorFactory);

        $totalIncome = $country->calculate("countryTotalIncomeTax");

        $this->assertEquals($expected, $totalIncome);
    }

    public function providerCountryStateCountyTotalIncomeTax()
    {
        return array(
            array(
                new USA(),
                array(
                    array(
                        new Texas(),
                            array(
                                new Anderson(1000, new IncomeTaxRate32()),
                                new Andrews(200,new IncomeTaxRate25())
                            ),
                            370
                    ),
                    array(
                        new California(),
                            array(
                                new Alameda(1000, new IncomeTaxRate32()),
                                new Lake(3000,new IncomeTaxRate25())
                            ),
                            1070
                    ),
                ),
            )
        );
    }


    /**
     * Exception Tests
     */
    public function testNoAssignedStatesException()
    {
        $this->expectException(ThereWhereNoStatesInCountry::class);
        $this->expectExceptionMessage("There are no states in the country");

        $country = new USA();

        $calculatorFactory = new CalculatorFactory();

        $calculatorFactory->addCalculatorFactory(
            "countryTotalIncomeTax",
            function () {
                return new CountryTotalIncomeTax();
            }
        );

        $country->addTaxCalculatorFactory($calculatorFactory);

        $country->calculate("countryTotalIncomeTax");
    }

    public function testNoAssignedCountiesException()
    {
        $this->expectException(ThereWhereNoCountiesInState::class);
        $this->expectExceptionMessage("There are no counties in the state");

        $country = new USA();
        $texas = new Texas();

        $country->addState($texas);

        $calculatorFactory = new CalculatorFactory();

        $calculatorFactory->addCalculatorFactory(
            "countryTotalIncomeTax",
            function () {
                return new CountryTotalIncomeTax();
            }
        );

        $country->addTaxCalculatorFactory($calculatorFactory);

        $country->calculate("countryTotalIncomeTax");
    }
}