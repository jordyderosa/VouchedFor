<?php
namespace VouchedFor\Gateway;
use VouchedFor\Interfaces\InputInterface as InputInterface;

class InputGateway
{

  public function initInput(InputInterface $inputType)
  {
     $assoc_array = $inputType->setInputAssocArray();
     return $assoc_array;
  }

}

?>
