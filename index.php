<?php
use VouchedFor\Controllers\ParserController as Parser;
use VouchedFor\Controllers\UserController as User;
use VouchedFor\Controllers\ScoreController as Score;
use VouchedFor\Controllers\InputByGETController as InputByGETController;
use VouchedFor\Gateway\InputGateway as InputGateway;
use VouchedFor\Controllers\ReviewsController as Reviews;

require_once 'app/bootstrap.php';

//$input="12th July 12:04, Jon, solicited, LB3-TYU, 50 words, *****";
$inputType=new InputByGETController();
$gateway=new InputGateway();
$input=$gateway->initInput($inputType);

$parser = new Parser();
if($parser->validateInputParameters($input))
{
   $user = new User();
   $review=new Reviews();

   $user->getUserFromName($input["name"]);
   $average=$review->getAverageFromReview($user);
   //echo "<br/>average is $average";
   $id_reviews=$review->storeReview($user,$input);


   $score = new Score();
   $score->sameMinuteOrHourRule($user,$id_reviews,$input["date"]);
   $score->solicitedRule($user,$id_reviews,$input["solicited"]);
   $score->sameDeviceRule($user,$id_reviews,$input["device"]);
   $score->ReviewLenghtRule($user,$id_reviews,$input["words"]);
   $score->fiveStarRule($user,$id_reviews,$input["stars"],$average);
   $score->RankLessThan70Rule($user,$id_reviews);
   $score->RankLessThan50Rule($user,$id_reviews);

   $user->storeRankByValue();

   $user->showInfoMessage($user);
}
else
{
  die("<br/>Could not read review summary data");
}






?>
