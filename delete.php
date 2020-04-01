<?php
require 'connec.php';
$pdo = new PDO (DSN,USER,PASS, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

if(isset($_GET['id']) && !empty($_GET['id'])){
    $id = $_GET['id'];
    try{
        $request = $pdo-> prepare("DELETE FROM article WHERE id=:id");
        $request->execute(['id' => $id]);
        header('Location: http://localhost:8888/PDO_Atelier/index.php');
    } catch (PDOException $e){
        $error = $e->getMessage();
    }
}