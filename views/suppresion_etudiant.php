<?php
require_once '../Model/pdo.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $sqlCheck = $dbPDO->prepare("SELECT * FROM etudiants WHERE id = :id");
    $sqlCheck->bindParam(':id', $id, PDO::PARAM_INT);
    $sqlCheck->execute();
    $student = $sqlCheck->fetch();

    if ($student) {
        $sqlDelete = $dbPDO->prepare("DELETE FROM etudiants WHERE id = :id");
        $sqlDelete->bindParam(':id', $id, PDO::PARAM_INT);
        if ($sqlDelete->execute()) {
            header("Location: ../index.php");
            exit();
        } else {
            echo "Erreur lors de la suppression de l'étudiant";
        }
    } else {
        echo "Étudiant non trouvé";
    }
} else {
    echo "ID d'étudiant non fourni";
}