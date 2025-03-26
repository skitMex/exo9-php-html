<?php
require_once '../Model/pdo.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $id_classe = $_POST['classe'];

    $sql = $dbPDO->prepare("INSERT INTO etudiants (nom, prenom, classe_id) VALUES (:nom, :prenom, :id_classe)");
    $sql->bindParam(':nom', $nom);
    $sql->bindParam(':prenom', $prenom);
    $sql->bindParam(':id_classe', $id_classe);
    $sql->execute();

    header('Location: ../index.php');
    exit();
}













































