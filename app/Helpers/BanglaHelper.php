<?php

namespace App\Helpers;

use Carbon\Carbon;

class BanglaHelper
{
    public static function toBn($number)
    {
        $bnDigits = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
        $enDigits = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        return str_replace($enDigits, $bnDigits, (string)$number);
    }

    public static function toEn($number)
    {
        $bnDigits = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'];
        $enDigits = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        return str_replace($bnDigits, $enDigits, (string)$number);
    }

    public static function bnDate($date)
    {
        if (!$date) return "N/A";
        $carbon = Carbon::parse($date);
        $bnMonths = [
            'January' => 'জানুয়ারি', 'February' => 'ফেব্রুয়ারি', 'March' => 'মার্চ',
            'April' => 'এপ্রিল', 'May' => 'মে', 'June' => 'জুন',
            'July' => 'জুলাই', 'August' => 'আগস্ট', 'September' => 'সেপ্টেম্বর',
            'October' => 'অক্টোবর', 'November' => 'নভেম্বর', 'December' => 'ডিসেম্বর'
        ];
        
        $day = self::toBn($carbon->format('d'));
        $month = $bnMonths[$carbon->format('F')] ?? '';
        $year = self::toBn($carbon->format('Y'));

        return "{$day} {$month} {$year}";
    }

    public static function calculateFiscalYear($date)
    {
        $carbon = Carbon::parse($date);
        $year = $carbon->year;
        $month = $carbon->month;
        $fy = ($month >= 7) ? "{$year}-" . ($year + 1) : ($year - 1) . "-{$year}";
        return self::toBn($fy);
    }

    public static function getMonthsPassed($joinDate, $endDate = null)
    {
        if (!$joinDate) return 0;
        $start = Carbon::parse($joinDate)->startOfMonth();
        $target = $endDate ? Carbon::parse($endDate)->startOfMonth() : Carbon::now()->subMonth()->startOfMonth();

        if ($start->greaterThan($target)) return 0;
        return $start->diffInMonths($target) + 1;
    }
}
