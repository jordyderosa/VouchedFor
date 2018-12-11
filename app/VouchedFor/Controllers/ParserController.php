<?php

namespace VouchedFor\Controllers;

class ParserController
{

    public function validateInputParameters($input)
    {
      if(isset($input))
      {
          if(count($input)==6)
          {
              return true;
          }
          else
            return false;
      }
      else
      {
          die("<br/>Input string empty in validateInputParameters");
      }
    }

    public function InputToDatetime($input)
    {
      if(isset($input))
      {
        $array=explode(" ",$input);
        $date_array=date_parse($array[0]." ".$array[1]." ".date('Y')." ".$array[2]);
        $day=$date_array["day"];

        if($day<10)
          $day ="0".$day;

        $month=$date_array["month"];

        if($month<10)
          $month ="0".$month;

        $hours=$date_array["hour"];

        if($hours<10)
          $hours = "0".$hours;

        $minutes=$date_array["minute"];
        if($minutes<10)
          $minutes ="0".$minutes;

        $year=$date_array["year"];
        $datetime="$year-$month-$day $hours:$minutes";
        return $datetime;
      }
      else
      {
          die("<br/>Input string empty!");
      }
    }
    public function InputToSameHour($input)
    {
      if(isset($input))
      {
        $array=explode(" ",$input);
        $hour_array=explode(":",$array[2]);
        $date_array=date_parse($array[0]." ".$array[1]." ".date('Y')." ".$hour_array[0].":00");
        $day=$date_array["day"];

        if($day<10)
          $day ="0".$day;

        $month=$date_array["month"];

        if($month<10)
          $month ="0".$month;

        $hours=$date_array["hour"];

        if($hours<10)
          $hours = "0".$hours;

        $year=$date_array["year"];
        $datetime="$year-$month-$day $hours:00";
        return $datetime;
      }
      else
      {
          die("<br/>Input string empty!");
      }
    }

}

?>
