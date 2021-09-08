<?php

    /*Ide minden féle Insertáló modulokat írnék ha egy komplex weboldalról lenne szó.*/

    function users( $data ){

        foreach ($data as $row  ) {

            $insertString = "";
            $insertParam = [];

            foreach( $row as $column => $value ){
	
                $insertString .= $column . " = :" . $column . ", ";

                $insertParam = array_merge( $insertParam , array($column => $value) );
                
            }

            $insertString = rtrim( $insertString , ", " );
            
            $insertedData = run( "INSERT INTO test.users SET " . $insertString , $insertParam );
        

        }


       return !!$insertedData;

    }

?>