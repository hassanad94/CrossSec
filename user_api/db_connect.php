<?php

class Dbh{

    private $password;
    private $dbname;
    private $charet;
    private $username;
    private $servername;

    protected function connect(){

        
        $this->servername = "localhost";
        $this->username = "root";
        $this->password = "";
        $this->dbname = "test";
        $this->charset = "utf8mb4";     

        try {

            $dsn = "mysql:host=". $this->servername ."; dbname=".$this->dbname."; charset=".$this->charset;

            $pdo = new PDO( $dsn, $this->username, $this->password );


            // $pdo-> setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC );

            $pdo-> setAttribute( PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC );
            return $pdo;
        
        } catch (PDOException $e ) {

            echo "Connection failed: ". $e->getMessage();

        }



    }

}

?>