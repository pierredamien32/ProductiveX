<?php

declare(strict_types=1);

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class DateExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('dateIntervalFormat', [$this, 'dateIntervalFormat']),
        ];
    }

    public function dateIntervalFormat(\DateInterval $dateInterval): string
    {
        $months = (int) $dateInterval->format('%m');
        $days = (int) $dateInterval->format('%d');
        $hours = (int) $dateInterval->format('%H');
        $minutes = (int) $dateInterval->format('%i');
        $seconds = (int) $dateInterval->format('%s');
        
        return trim(
            $this->format($months, 'Month').
            $this->format($days, 'Day').
            $this->format($hours, 'Hour').
            $this->format($minutes, 'Minute') .
            $this->format($seconds, 'Second')    
        );
    }

    private function format(int $period, string $stringPeriod): string
    {
        return $period ? sprintf('%d %s%s ', $period, $stringPeriod, $period > 1 ? 's' : '') : '';
    }
}