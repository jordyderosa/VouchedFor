<?php
namespace VouchedFor\Controllers;
use \PDO;
use VouchedFor\Database\Database as Database;
use VouchedFor\Controllers\ParserController as Parser;

class ReviewsController
{

      public function getReviewFromBetweenDatetime($id_user,$d_start,$d_end)
      {
            if(isset($id_user) && isset($d_start) && isset($d_end))
            {
                try
                {
                  $db =new Database();
                  //example SELECT * FROM `reviews` WHERE `datetime` BETWEEN '2018-12-01 00:00:00.000000' AND '2018-12-04 00:00:00.000000'
                  $sql = $db->connect()->prepare("SELECT * FROM reviews WHERE datetime BETWEEN :d_start AND :d_end AND id_users = :id_user");
                  // bind parameters
                  $sql->bindParam(':d_start', $d_start, PDO::PARAM_STR);
                  $sql->bindParam(':d_end', $d_end, PDO::PARAM_STR);
                  $sql->bindParam(':id_user', $id_user, PDO::PARAM_INT);
                  // execute statement
                  $sql->execute();
                /*  echo "<br>";
                  $sql->debugDumpParams();
                  echo "<br>";
                */  // check if results
                  if($sql->rowCount() > 0)
                  {
                    // create associative array
                    $result = $sql->fetchAll();
                    return $result;
                  }
                  else
                  {
                    return array();
                  }

                }
                catch (PDOException $e)
                {
                    echo $e->getMessage();
                }
            }
            else
            {
                echo "<br/>Too few parameters provided in getReviewFromBetweenDatetime";
            }
      }
      public function getReviewFromDevice($id_user,$device)
      {
            if(isset($id_user) && isset($device))
            {
                try
                {
                  $db =new Database();
                  //example SELECT * FROM `reviews` WHERE `datetime` BETWEEN '2018-12-01 00:00:00.000000' AND '2018-12-04 00:00:00.000000'
                  $sql = $db->connect()->prepare("SELECT * FROM reviews WHERE device =:device AND id_users = :id_user");
                  // bind parameters
                  $sql->bindParam(':device', $device, PDO::PARAM_STR);
                  $sql->bindParam(':id_user', $id_user, PDO::PARAM_INT);
                  // execute statement
                  $sql->execute();
                  //$sql->debugDumpParams();
                  // check if results
                  if($sql->rowCount() > 0)
                  {
                    // create associative array
                    $result = $sql->fetchAll();
                    return $result;
                  }
                  else
                  {
                    return array();
                  }

                }
                catch (PDOException $e)
                {
                    echo $e->getMessage();
                }
            }
            else
            {
                echo "<br/>Too few parameters provided in getReviewFromDevice";
            }
      }
      public function getAverageFromReview($user)
      {
            if(isset($user))
            {
                  try
                  {

                      $db = new Database();
                      $sql = $db->connect()->prepare("SELECT AVG(stars) as average FROM reviews WHERE id_users=:id_user");
                      // bind dei parametri
                      $sql->bindParam(':id_user', $user->id_user, PDO::PARAM_INT);
                      // esecuzione del prepared statement
                      $sql->execute();
                      // conteggio dei record coinvolti dalla query
                      //$sql->debugDumpParams();
                      if($sql->rowCount() > 0)
                      {

                        // creazione di un'array contenente il risultato
                        $result = $sql->fetchAll();
                        // ciclo dei risultati
                        foreach ($result as $row)
                        {
                              if(isset($row['average']))
                                return $row['average'];
                              else
                                return 5;
                        }

                      }

                      return $average;
                  }
                  catch(PDOException $e)
                  {
                    echo $e->getMessage();
                  }

            }
            else
              echo "<br/>Too few parameters provided in getAverageFromReview";
      }
      public function storeReview($user,$input_array)
      {
          if(isset($user) && isset($input_array))
          {
            try
            {
                $db = new Database();
                $sql = $db->connect()->prepare("INSERT INTO reviews (datetime,id_users,solicited,device,words,stars) VALUES (?,?,?,?,?,?)");
                $parser = new Parser();
                $datetime=$parser->InputToDatetime($input_array["date"]);
                $words=str_replace(" words","",$input_array["words"]);
                $stars=substr_count($input_array["stars"],"*");
                $sql->execute(array($datetime,$user->id_user,$input_array["solicited"],$input_array["device"],$words,$stars));
                // esecuzione del prepared statement
                //$sql->debugDumpParams();
                return $db->connect()->lastInsertId();

            }
            catch(PDOException $e)
            {
              echo $e->getMessage();
            }
          }
          else
            echo "<br/>Too few parameters provided in storeReview";

      }
}
?>
