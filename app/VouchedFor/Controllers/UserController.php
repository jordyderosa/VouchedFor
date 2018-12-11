<?php
namespace VouchedFor\Controllers;
use VouchedFor\Database\Database as Database;
use \PDO;


class UserController
{
    public $id_user;
    public $name;
    public $rank;
    public $professional;

    public function getUserFromName($user_name)
    {
          if(isset($user_name))
          {
                try
                {
                    $db = new Database();
                    $sql = $db->connect()->prepare("SELECT * FROM users WHERE name =:user_name");
                    // bind dei parametri
                    $sql->bindParam(':user_name', $user_name, PDO::PARAM_STR);
                    // esecuzione del prepared statement
                    $sql->execute();
                    // conteggio dei record coinvolti dalla query
                    if($sql->rowCount() > 0)
                    {
                      // creazione di un'array contenente il risultato
                      $result = $sql->fetchAll();
                      // ciclo dei risultati
                      foreach($result as $row)
                      {
                          $this->id_user=$row['id'];
                          $this->name=$row['name'];
                          $this->rank=$row['rank'];
                          $this->professional=$row['professional'];
                          return $this;
                      }
                    }
                    else
                       echo "No user found with name=". $user_name.".";

                }
                catch(PDOException $e)
                {
                  echo $e->getMessage();
                }

          }
          else
            echo "User name is empty";

    }
    public function changeRankByValue($value)
    {
      if(isset($this->rank) && isset($this->id_user) && isset($value))
      {
          $rank=$this->rank + $value;
          if($rank<=100 || $rank>=0)
          {
            $this->rank=$rank;
            //echo "Rank setted to $rank<br/>";
          }

      }
      else
          echo "<br/>Too few parameters provided in storeRankByValue";
    }
    public function storeRankByValue()
    {
      if(isset($this->rank))
      {
          if($this->rank>=0 && $this->rank<=100)
          {
              try
              {
                  $db = new Database();
                  $sql = $db->connect()->prepare("UPDATE users SET rank =:rank WHERE id = :id_user");
                  $rank=(string)$this->rank;
                  $sql->bindParam(':id_user', $this->id_user, PDO::PARAM_INT);
                  $sql->bindParam(':rank', $rank, PDO::PARAM_STR);
                  $sql->execute();

                //  $sql->debugDumpParams();
                //  echo "<br/>Info: $this->name has a trusted review score of $this->rank";
              }
              catch (PDOException $e)
              {
                  $e->getMessage();
              }
         }
      }
      else
          echo "<br/>rank property is not setted";
    }
    public function deactivateUser($user)
    {
      if(isset($user))
      {
          try
          {
              $db = new Database();
              $sql = $db->connect()->prepare("UPDATE users SET professional = 0 WHERE id = :id_user");
              $sql->bindParam(':id_user', $this->id_user, PDO::PARAM_INT);
              $sql->execute();
            //  $sql->debugDumpParams();
             $this->professional=0;
             $user->storeRankByValue();
              die("<br/>Alert: $user->name has been de-activate due to a low trusted review score");
          }
          catch (PDOException $e)
          {
              $e->getMessage();
          }
      }
      else
      {
          echo "<br/>Too few parameters provided in deactivateUser";
      }
    }

    public function showInfoMessage($user)
    {
       $name=$user->name;
       echo "<br/>Info: $name has a trusted review score of ".$this->getUserFromName($name)->rank;
    }
}

 ?>
