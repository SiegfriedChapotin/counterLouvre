<?php

namespace App\Filter;


use Symfony\Component\Intl\Intl;
use Twig\Extension\AbstractExtension ;
use Twig\TwigFilter ;

class CountryFilter extends AbstractExtension
{
    public function getFilters()
    {
        return array(
            new TwigFilter('countryname', array($this, 'countryName')),
        );
    }

    public function countryName($countryCode)
    {
        $countryName = Intl::getRegionBundle()->getCountryName($countryCode);

        return $countryName;
    }
}
