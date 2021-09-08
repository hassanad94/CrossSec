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

?>