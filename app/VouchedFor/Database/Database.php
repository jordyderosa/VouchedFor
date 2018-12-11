<?php

namespace VouchedFor\Database;
use \PDO;
include (__DIR__ ."\..\..\..\db.config.php");

class Database
{

        // db connection config vars
        private $user = DBUSER;
        private $password = DBPWD;
        private $baseName = DBNAME;
        private $host = DBHOST;
        private $port = DBPORT;
        private $conn;

        private $Debug;


        function __construct($params=array())
        {
      		$this->conn = false;
      		$this->debug = true;
      		$this->connect();
      	}

      	function __destruct()
        {
      		$this->disconnect();
      	}

      	public function connect()
        {
      		if (!$this->conn)
          {
          			try
                {
          				    $link = $this->conn = new PDO('mysql:host='.$this->host.';dbname='.$this->baseName.'', $this->user, $this->password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
                      $link -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          			}
          			catch (Exception $e)
                {
          				die('Error : ' . $e->getMessage());
          			}

          			if (!$this->conn)
                {
          				$this->status_fatal = true;
          				echo 'Connection BDD failed';
          				die();
          			}
          			else
                {
          				$this->status_fatal = false;
          			}
      	   }

      		return $this->conn;
      	}

      private	function disconnect()
      {
      		if ($this->conn)
          {
      			$this->conn = null;
      		}
      }

      public function resetData()
      {
          $sql = $this->connect()->prepare("TRUNCATE vouchedfor.logs");
          $sql->execute();
          $sql = $this->connect()->prepare("TRUNCATE vouchedfor.reviews");
          $sql->execute();
          $sql = $this->connect()->prepare("UPDATE users SET rank=100,professional=1 where 1");
          $sql->execute();
          
      }

}
?>
