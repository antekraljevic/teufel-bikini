<?php

namespace App\Calculator\Business;

use DateInterval;
use DateTime;
use DatePeriod;

class DatesCalculator
{
    private const TWELVE_MONTH_INTERVAL = 'P12M';
    private const MONTHLY_PERIOD = 'P1M';
    private const LAST_DAY_OF_MONTH = 'last day of';
    private const FIFTEENTH_DAY_OF_MONTH = 'Y-m-15';
    private const NAME_OF_MONTH = 'F';
    private const DAY_AS_NUMBER = 'N';
    private const FIRST_BUSSINES_DAY_BEFORE_WEEKEND = '-1 weekday';
    private const DATE_TIME_FORMAT = 'Y-m-d';
    private const SATURDAY_AS_NUMBER = 6;

    public function calculatePayrollDates(): array
    {
       $period = $this->createNewTwelveMonthsPeriod();
        
       $result = [];
        foreach ($period as $month) {
            $result[] = $this->getBaseSalaryAndBonusPayrollDatesFromAMonth($month);
        }

        return $result;
    }

    private function createNewTwelveMonthsPeriod(): DatePeriod
    {
        $start = new DateTime();
        $end = clone $start;
        $end->add(new DateInterval(self::TWELVE_MONTH_INTERVAL));

        return new DatePeriod(
            $start,
            new DateInterval(self::MONTHLY_PERIOD),
            $end
       );
    }

    private function getBaseSalaryAndBonusPayrollDatesFromAMonth(DateTime $month): array
    {
        return [
            $month->format(self::NAME_OF_MONTH),
            $this->getFirstBusinessDayFromADate($month->modify(self::LAST_DAY_OF_MONTH)),
            $this->getFirstBusinessDayFromADate($month->modify($month->format(self::FIFTEENTH_DAY_OF_MONTH)))
        ];
    }

    private function getFirstBusinessDayFromADate(DateTime $month): string
    {
        if($month->format(self::DAY_AS_NUMBER) >= self::SATURDAY_AS_NUMBER)
        {
            $month->modify(self::FIRST_BUSSINES_DAY_BEFORE_WEEKEND);
        }

        return $month->format(self::DATE_TIME_FORMAT);
    }
}