<?php

namespace App\Filter;

use Symfony\Component\Intl\Intl;
use Twig\Extension\AbstractExtension ;
use Twig\TwigFilter ;

class TariffFilter extends AbstractExtension
{
    public function getFilters()
    {
        return array(
            new TwigFilter('countryname', array($this, 'tariffName')),
        );
    }

    public function tariffName($countryCode)
    {
        $countryName = Intl::getRegionBundle()->getCountryName($countryCode);

        return $countryName;
    }
}
