<?php
namespace VouchedFor\Controllers;
use VouchedFor\Interfaces\InputInterface as InputInterface;

class InputByGETController implements InputInterface
{

   public function setInputAssocArray()
   {
     if(isset($_GET['input']))
     {
        $input=explode(', ',$_GET['input']);
        if(count($input)==6)
        {
            $assoc_array['date']=$input[0];
            $assoc_array['name']=$input[1];
            $assoc_array['solicited']=$input[2];
            $assoc_array['device']=$input[3];
            $assoc_array['words']=$input[4];
            $assoc_array['stars']=$input[5];
            //print_r ($assoc_array);
            return $assoc_array;
        }
        else
            die("<br/>Could not read review summary data");
     }
     else
        die("<br/>Could not read review summary data");

   }
}


?>
