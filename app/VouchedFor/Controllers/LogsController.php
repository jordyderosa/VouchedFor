<?php
namespace VouchedFor\Controllers;
use \PDO;
use VouchedFor\Database\Database as Database;

class LogsController extends Database
{
      public function saveLogs($id_user,$id_reviews,$logs)
      {
        if(isset($id_user) && isset($logs) && isset($id_reviews))
        {
              try
              {
                  $sql = $this->connect()->prepare("INSERT INTO logs (id_users,id_reviews,logs) VALUES (?,?,?)");
                  // esecuzione del prepared statement
                  $sql->execute(array($id_user,$id_reviews,$logs));
              }
              catch(PDOException $e)
              {
                echo $e->getMessage();
              }
        }
        else
        {
            echo "<br/>Too few parameters in saveLogs";
        }

      }


}


?>
