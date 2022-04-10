<?php
     class Database{
          private $connection;

          function __construct() {

          }

          function connect(){
               $this->connection=new mysqli("localhost","root","sibw","periodico");

               if ($this->connection->connect_error) {
                   die("Connection failed: " . $this->connection->connect_error);
               }
          }

          function query($query){
               $result = $this->connection->query($query);
               return $result;
          }

          function close(){
               $this->connection->close();
          }
     }

 ?>
