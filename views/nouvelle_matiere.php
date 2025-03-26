<?php
require_once '../Model/pdo.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $libelle = $_POST['libelle'];

    $sql = $dbPDO->prepare("INSERT INTO matiere (lib) VALUES (:libelle)");
    $sql->bindParam(':libelle', $libelle);
    $sql->execute();

    header('Location: ../index.php');
    exit();
}