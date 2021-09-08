<?php

	/*Ide jönnek a Rendszer szintű functionok. */

	function run( $sql , $parameters = [] , $dbname = "test" ,  $connection = null  ){

		try{
	
			$sql = trim( $sql);

			if(  empty( $connection )  ){

				$credentials = [

					"host" => "localhost",
					"user" => "root",
					"pw" => "",
					"dbname" => $dbname,
					"charset" => "utf8mb4"
				];


				$dsn = "mysql:host=". $credentials["host"] ."; dbname=". $credentials["dbname"]. "; charset=". $credentials["charset"];
	
				$connection = new PDO( $dsn, $credentials["host"] , $credentials["pw"] );
	
				$connection -> setAttribute( PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION );
				
	
			}
	
			$statement = $connection -> prepare( $sql );
	
			foreach( $parameters as $field => $value ){
	
				$statement -> bindParam( ':' . $field , $parameters[ $field ] );
	
			}
	
			$queryString = $statement -> queryString;
	
			$statement -> execute();
	
			$type = strtolower(
				preg_split( '/\s+/' ,
							trim( preg_replace( '!/\*.*?\*/!s' , '' , $statement -> queryString ) )
				)[ 0 ]
			);
			
			switch( $type ){
				case 'select':
					return $statement -> fetchAll( PDO::FETCH_ASSOC );
				case 'insert':
					return $connection -> lastInsertId();
				/*case 'update':
					return $this->statement->rowCount();*/
				default:
					return true;
			}
	
		}catch( \PDOException $ex ){
	
			$queryString = isset( $statement ) && isset( $statement -> queryString ) ?
				$statement -> queryString
				:
				'';
			
			foreach( $parameters as $field => $value ){
				$queryString = str_replace( ':' . $field , "'" . $value . "'" , $queryString );
			}
			
			echo $ex -> getMessage() . ' / ' . $queryString;
			
			throw $ex;
	
		};
	
		return $stmt->fetch();

	}

	/*Csak hogy ne keljen kézzel létre hozni. Erre nem találtam sajnos szebb megoldást.*/

	function setUpDatabase(){

		$dbname = "test";
		$pdo = new PDO("mysql:host=localhost", "root", "");
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$dbname = "`".str_replace("`","``",$dbname)."`";
		$pdo->query("CREATE DATABASE IF NOT EXISTS $dbname");
		$pdo->query("use $dbname");

		run( "CREATE TABLE IF NOT EXISTS `users` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`name` varchar(50) NOT NULL DEFAULT '0',
			`gender` varchar(10) NOT NULL DEFAULT '0',
			`age` tinyint(4) NOT NULL DEFAULT '0',
			`email` varchar(50) NOT NULL DEFAULT '0',
			`city` varchar(25) NOT NULL DEFAULT '0',
			`country` varchar(25) NOT NULL DEFAULT '0',
			`salt` varchar(25) NOT NULL DEFAULT '0',
			`password` char(64) NOT NULL DEFAULT '0',
			`picture` varchar(100) NOT NULL DEFAULT '0',
			PRIMARY KEY (`id`)
		  ) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=latin1;
		  " );

	}

	setUpDatabase();


?>