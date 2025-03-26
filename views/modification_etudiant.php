
<?php
require_once '../Model/pdo.php';

$id = $_GET['id'];

$sql = $dbPDO->prepare("SELECT nom, prenom, classe_id FROM etudiants WHERE id = :id");
$sql->execute(['id' => $id]);
$etudiant = $sql->fetch();

$sqlClasses = $dbPDO->prepare("SELECT id, libelle FROM classes");
$sqlClasses->execute();
$resClasses = $sqlClasses->fetchAll();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $classe = $_POST['classe'];

    $update = $dbPDO->prepare("UPDATE etudiants SET nom = :nom, prenom = :prenom, classe_id = :classe WHERE id = :id");
    $update->execute([
        'nom' => $nom,
        'prenom' => $prenom,
        'classe' => $classe,
        'id' => $id
    ]);

    echo "<br>Modification réussie ! <a href='../index.php'>Retour</a>";
    exit;
}
?>

<body>
<h1>Modifier un Étudiant</h1>
<form method="post">
    <label for="nom">Nom :</label>
    <input type="text" id="nom" name="nom" value="<?= $etudiant['nom'] ?>" required>

    <label for="prenom">Prénom :</label>
    <input type="text" id="prenom" name="prenom" value="<?= $etudiant['prenom'] ?>" required>

    <label for="classe">Classe :</label>
    <select id="classe" name="classe">
        <?php foreach ($resClasses as $class): ?>
            <option value="<?= $class['id'] ?>" <?= $class['id'] == $etudiant['classe_id'] ? 'selected' : '' ?>>
                <?= $class['libelle'] ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit">Modifier</button>
</form>
<a href="../index.php">Retour</a>
</body>
</html>