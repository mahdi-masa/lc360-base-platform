<?php
namespace App\Enum;



enum DonationTypeEnum:String
{
    case CASH = 'cash';
    case PLANT = 'plant';

    public static function getString(): String
    {
        $values = [];
        foreach(DonationTypeEnum::cases() as $item)
        {
            array_push($values, $item->value);
        }

        $string = implode("|", $values);
        return $string;
    }
}