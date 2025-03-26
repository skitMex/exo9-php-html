<?php
require 'Models/pdo.php';

$sqlEtudiants = $dbPDO-->prepare("SELECT  *FROM etudiants");
$sqlEtudiants->execute();
$resEtudiant = $sqlEtudiants->fetchAll(PDO::FETCH_ASSOC);


$sqlClasse = $dbPDO-->prepare("SELECT id, libelle FROM classes");
$sqlClasse->execute();
$resClasse = $sqlClasse->fetchAll(PDO::FETCH_ASSOC);


$sqlProfesseur = $dbPDO->prepare("SELECT professeurs.nom AS nom_professeur, professeurs.prenom AS prenom_professeur, matiere.lib AS nom_matiere, classes.libelle AS libelle_classe FROM professeurs JOIN matiere ON professeurs.id_matiere = matiere.id JOIN classes ON professeurs.id_classe = classes.id");
$sqlProfesseur->execute();
$resProfesseur = $sqlProfesseur->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des étudiants</title>
</head>
<body>
<h1>Liste des étudiants</h1>
<ul>
    <?php foreach ($resEtudiant as $etudiant): ?>
        <li>
            <?php echo htmlspecialchars($etudiant['prenom'] . ' ' . $etudiant['nom']); ?>
            <a href="views/modif_etudiant.php?id=<?php echo urlencode($etudiant['id']); ?>">Modifier</a>
            <a href="views/suppression_etudiant.php?id=<?php echo urlencode($etudiant['id']); ?>" onclick="return confirm('Voulez-vous vraiment supprimer cet étudiant ?');">Supprimer</a>
        </li>
    <?php endforeach; ?>
</ul>

<h1>Liste des classes</h1>
<ul>
    <?php foreach ($resClasse as $classe): ?>
        <li><?php echo htmlspecialchars($classe['libelle']); ?></li>
    <?php endforeach; ?>
</ul>

<h1>Liste des professeurs</h1>
<ul>
    <?php foreach ($resProfesseur as $professeur): ?>
        <li><?php echo htmlspecialchars($professeur['prenom_professeur'] . ' ' . $professeur['nom_professeur'] . ' - ' . $professeur['nom_matiere'] . ' - ' . $professeur['libelle_classe']); ?></li>
    <?php endforeach; ?>
</ul>

<h1>Nouvelle matière</h1>
<form action="views/nouvelle_matiere.php" method="post">
    <label for="libelle">Libellé:</label>
    <input type="text" id="libelle" name="libelle" required>
    <button type="submit">Valider</button>
</form>

<h1>Nouvel élève</h1>
<form action="views/nouvel_etudiant.php" method="post">
    <label for="nom">Nom:</label>
    <input type="text" id="nom" name="nom" required>
    <label for="prenom">Prénom:</label>
    <input type="text" id="prenom" name="prenom" required>
    <label for="classe">Classe:</label>
    <select id="classe" name="classe" required>
        <?php foreach ($resClasse as $classe): ?>
            <option value="<?php echo htmlspecialchars($classe['id']); ?>"><?php echo htmlspecialchars($classe['libelle']); ?></option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Valider</button>
</form>
</body>
</html>
