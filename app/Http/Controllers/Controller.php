<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function getDayKhmer($day)
    {
        if ($day == 'Mon') {
            $day = 'ច័ន្ទ';
        } elseif ($day == 'Tue') {
            $day = 'អង្គារ';
        } elseif ($day == 'Wed') {
            $day = 'ពុធ';
        } elseif ($day == 'Thu') {
            $day = 'ព្រហស្បតិ៍';
        } elseif ($day == 'Fri') {
            $day = 'សុក្រ';
        } elseif ($day == 'Sat') {
            $day = 'សៅរ៍';
        } elseif ($day == 'Sun') {
            $day = 'អាទិត្យ';
        }

        return $day;
    }

    public function getMonthKhmer($month)
    {
        if ($month == 'Jan') {
            $month = 'មករា';
        } elseif ($month == 'Feb') {
            $month = 'កុម្ភៈ';
        } elseif ($month == 'Mar') {
            $month = 'មីនា';
        } elseif ($month == 'Apr') {
            $month = 'មេសា';
        } elseif ($month == 'May') {
            $month = 'ឧសភា';
        } elseif ($month == 'Jun') {
            $month = 'មិថុនា';
        } elseif ($month == 'Jul') {
            $month = 'កក្កដា';
        } elseif ($month == 'Aug') {
            $month = 'សីហា';
        } elseif ($month == 'Sep') {
            $month = 'កញ្ញា';
        } elseif ($month == 'Oct') {
            $month = 'តុលា';
        } elseif ($month == 'Nov') {
            $month = 'វិច្ឆិការ';
        } else {
            $month = 'ធ្នូរ';
        }

        return $month;
    }
}
