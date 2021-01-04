<?php

$selection = $_REQUEST["selection"];
$research = $_REQUEST["research"];

try {
   $conn = new PDO("mysql:host=localhost;dbname=web-project", "webproject", "123456");

   $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   if (strcmp($selection,"musee"){
      
   } )
} catch (PDOException $e) {
   echo "Connection failed: " . $e->getMessage();
}
