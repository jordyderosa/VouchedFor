<?php
namespace VouchedFor\Controllers;
use VouchedFor\Controllers\ReviewsController as Reviews;
use VouchedFor\Controllers\UserController as User;
use VouchedFor\Controllers\LogsController as Logs;
use VouchedFor\Controllers\ParserController as Parser;

class ScoreController
{
    public function sameMinuteOrHourRule($user,$id_reviews,$value)
    {
        if(isset($user) && isset($value) && isset($id_reviews))
        {
          if($this->validateDateTime($value))
          {
              $parser = new Parser();
              $datetime=$parser->InputToDatetime($value);
            //  echo "<br/>datetime=$datetime";
              //if others reviews in the same day at the same same hour and minute was found
              //sub 40% to the user's rank
              $reviews=new Reviews();
              $results=$reviews->getReviewFromBetweenDatetime($user->id_user,$datetime,$datetime);
              if(count($results)>1)
              {

                $user->changeRankByValue(-40);
                //save into logs table
                $log=new Logs();
                $log_msg="sameMinuteRule -40%";
                $log->saveLogs($user->id_user,$id_reviews,$log_msg);
              }
              else
              {
                  $this->sameHourRule($user,$id_reviews,$value);
              }
           }
           else
           {
             echo "<br/>Datetime is invalid in sameMinuteOrHourRule";
           }
        }
        else
        {
            echo "<br/>Too few arguments in sameMinuteRule";
        }

    }

    public function sameHourRule($user,$id_reviews,$value)
    {
        if(isset($user) && isset($value) && isset($id_reviews))
        {
           if($this->validateDateTime($value))
            {
                $parser = new Parser();
                $datetime=$parser->InputToSameHour($value);
                $date_array=date_parse($datetime);

                $d_end = date('Y-m-d H:i', strtotime("+59 minutes", strtotime($datetime)));
               // echo "<br/>datetime=$datetime , d_end=$d_end";

                //if others reviews in the same day at the same same hour was found
                //sub 20% to the user's rank

                $reviews=new Reviews();
                $results=$reviews->getReviewFromBetweenDatetime($user->id_user,$datetime,$d_end);
                if(count($results)>1)
                {
                  $user->changeRankByValue(-20);
                  //save into logs table
                  $log=new Logs();
                  $log_msg="sameHourRule -20%";
                  $log->saveLogs($user->id_user,$id_reviews,$log_msg);

                }
            }
        }
        else
        {
            echo "<br/>Too few arguments in sameHourRule";
        }
    }
    public function solicitedRule($user,$id_reviews,$value)
    {
      if(isset($user) && isset($value) && isset($id_reviews))
      {
         if($value == "solicited")
         {
              //if solicited add 3% to the user's rank
              $reviews=new Reviews();
              $user->changeRankByValue(+3);
              //save into logs table
              $log=new Logs();
              $log_msg="solicitedRule +3%";
              $log->saveLogs($user->id_user,$id_reviews,$log_msg);
          }
          else if($value == "unsolicited")
          {
              //do nothing
          }
          else
          {
              echo "<br/>Value error in solicited parameter : $value. Expected value are 'solicited' or 'unsolicited.'";
          }
      }
      else
      {
          echo "<br/>Too few arguments in sameHourRule";
      }
    }

    public function sameDeviceRule($user,$id_reviews,$value)
    {
      if(isset($user) && isset($value) && isset($id_reviews))
      {

             //if multiple review coming from the same device knock 30% to the user's rank
             $reviews=new Reviews();
             $results=$reviews->getReviewFromDevice($user->id_user,$value);
             if(count($results)>1)
             {
               $user->changeRankByValue(-30);
               //save into logs table
               $log=new Logs();
               $log_msg="sameDeviceRule -30%";
               $log->saveLogs($user->id_user,$id_reviews,$log_msg);
             }

      }
      else
      {
          echo "<br/>Too few arguments in sameDeviceRule";
      }
    }


    public function ReviewLenghtRule($user,$id_reviews,$value)
    {
      if(isset($user) && isset($value) && isset($id_reviews))
      {
         $value=str_replace(" words","",$value);
         if(is_numeric($value) && $value>100)
         {
              //if review is less than 100 words knock 0,5% to the user's rank
              $reviews=new Reviews();
              $user->changeRankByValue(-0.5);
              //save into logs table
              $log=new Logs();
              $log_msg="ReviewLenghtRule -0,5%";
              $log->saveLogs($user->id_user,$id_reviews,$log_msg);
          }
      }
      else
      {
          echo "<br/>Too few arguments in ReviewLenghtRule";
      }
    }

    public function fiveStarRule($user,$id_reviews,$value,$average)
    {
      if(isset($user) && isset($id_reviews) && isset($value)  && isset($average))
      {
         //if average <3.5 knock 8% to the user's rank
          if($average<3.5)
          {
            $this->averageRateRule($user,$id_reviews);
          }
           //if 5* review knock 2% to the user's rank
          else if(substr_count($value,"*")==5)
          {
               $user->changeRankByValue(-2);
               //save into logs table
               $log=new Logs();
               $log_msg="fiveStarRule -2%";
               $log->saveLogs($user->id_user,$id_reviews,$log_msg);

          }
      }
      else
      {
          echo "<br/>Too few arguments in fiveStarRule";
      }
    }

    public function averageRateRule($user,$id_reviews)
    {
      if(isset($user) && isset($id_reviews))
      {
            //if average <3.5 knock 8% to the user's rank
            $user->changeRankByValue(-8);
            //save into logs table
            $log=new Logs();
            $log_msg="averageRateRule -8%";
            $log->saveLogs($user->id_user,$id_reviews,$log_msg);
      }
      else
      {
          echo "<br/>Too few arguments in averageRateRule";
      }
    }

    public function RankLessThan70Rule($user,$id_reviews)
    {
      if(isset($user) && isset($id_reviews))
      {
        if(($user->rank<70) && ($user->rank>50))
        {
            //save into the log table
            $log=new Logs();
            $log_msg="RankLessThan70Rule Warning";
            $log->saveLogs($user->id_user,$id_reviews,$log_msg);


            die("<br/>Warning: $user->name has a trusted review score of $user->rank");
        }
      }
      else
      {
        echo "<br/>Too few parameters in RankLessThan70Rule";
      }
    }

    public function RankLessThan50Rule($user,$id_reviews)
    {
      if(isset($user) && isset($id_reviews))
      {
            if($user->rank<50)
            {

              //save into the log table
              $log=new Logs();
              $log_msg="RankLessThan50Rule deactivateUser";
              $log->saveLogs($user->id_user,$id_reviews,$log_msg);
              $user->deactivateUser($user);
            }
      }
      else
      {
          echo "<br/>Too few parameters in RankLessThan50Rule";
      }
    }


    // aux functions

    private function validateDateTime($value)
    {
      //12th July 12:04
      $array=explode(" ",$value);
      if(count($array)==3)
      {

          $date_array=date_parse($array[0]." ".$array[1]." ".date('Y')." ".$array[2]);
          //validate date
          if(checkdate($date_array["month"],$date_array["day"],$date_array["year"]))
          {
              return true;
          }
          else
          {
              echo "<br/>Invalid date in input string : $value";
              return false;
          }
      }
      else
      {
          echo "<br/>Date has too few parameters in ValidateDateTime";
          return false;
      }
    }
}


?>
