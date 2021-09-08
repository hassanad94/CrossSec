<?php

    /*Ide minden féle Insertáló modulokat írnék ha egy komplex weboldalról lenne szó.*/

    function users( ){

       $users = run( "SELECT * FROM test.users" );


       return $users;

    }

?>