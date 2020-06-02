<?php

    function redirect($location){
        header("Location:{$location}");
    }

    function unset_message(){

    }

    function alert_message($message){

        echo "<script>alert('$message');</script>";

    }

