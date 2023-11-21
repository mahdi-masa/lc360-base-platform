<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SaliBhdr\TyphoonIranCities\Models\IranProvince;

class UtilsController extends Controller
{
    public function getProvinces()
    {
        return IranProvince::select(['id', 'name'])
            ->get();
    }

    public function getProvinceCities(IranProvince $province)
    {
        return $province->cities()
            ->select(['id', 'name', 'province_id', 'county_id'])
            ->get();
    }
}
