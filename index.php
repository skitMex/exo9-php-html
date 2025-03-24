<?php
require 'Views/pdo.php';
?>
<!DOCTYPE html>
<?php
$qeury = $pdo->query('SELECT * FROM etudiants');
$etudiant = $qeury->fetchAll();
