<?php
session_start();
require '../Model/pdo.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$sqlUsers = $dbPDO->prepare("SELECT id, username FROM users");
$sqlUsers->execute();
$resUsers = $sqlUsers->fetchAll();

$sqlStudents = $dbPDO->prepare("SELECT nom, prenom FROM etudiants");
$sqlStudents->execute();
$resStudents = $sqlStudents->fetchAll();

$sqlClasses = $dbPDO->prepare("SELECT libelle FROM classes");
$sqlClasses->execute();
$resClasses = $sqlClasses->fetchAll();

$sqlProfs = $dbPDO->prepare("
    SELECT professeurs.nom AS prof_nom, professeurs.prenom AS prof_prenom, 
           matiere.lib AS matiere_nom, classes.libelle AS classe_libelle
    FROM professeurs
    JOIN matiere ON professeurs.id_matiere = matiere.id
    JOIN classes ON professeurs.id_classe = classes.id
");
$sqlProfs->execute();
$resProfs = $sqlProfs->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="p-8 bg-gray-100">
<h1 class="text-3xl font-bold mb-4">Tableau de bord Admin</h1>

<div class="bg-white p-6 rounded-lg shadow-md mb-6">
    <h2 class="text-xl font-semibold mb-4">Ajouter un utilisateur</h2>
    <form action="../Controllers/ajouter_utilisateur.php" method="POST" class="space-y-4">
        <div>
            <label for="username" class="block text-sm font-medium">Nom d'utilisateur</label>
            <input type="text" name="username" id="username" required class="w-full p-2 border border-gray-300 rounded-lg">
        </div>
        <div>
            <label for="password" class="block text-sm font-medium">Mot de passe</label>
            <input type="password" name="password" id="password" required class="w-full p-2 border border-gray-300 rounded-lg">
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Ajouter</button>
    </form>
</div>

<div class="bg-white p-6 rounded-lg shadow-md mb-6">
    <h2 class="text-xl font-semibold mb-4">Liste des utilisateurs</h2>
    <table class="w-full table-auto border-collapse border border-gray-200">
        <thead>
        <tr class="bg-gray-100">
            <th class="border border-gray-300 px-4 py-2">ID</th>
            <th class="border border-gray-300 px-4 py-2">Nom d'utilisateur</th>
            <th class="border border-gray-300 px-4 py-2">Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($resUsers as $user): ?>
            <tr>
                <td class='border border-gray-300 px-4 py-2'><?= $user['id']; ?></td>
                <td class='border border-gray-300 px-4 py-2'><?= $user['username']; ?></td>
                <td class='border border-gray-300 px-4 py-2'>
                    <a href='../Controllers/modifier_utilisateur.php?id=<?= $user['id']; ?>' class='text-blue-500 mr-2'>Modifier</a>
                    <a href='../Controllers/supprimer_utilisateur.php?id=<?= $user['id']; ?>' class='text-red-500'>Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-semibold mb-4">Liste des étudiants</h2>
    <table class="w-full table-auto border-collapse border border-gray-200">
        <thead class="bg-gray-100">
        <tr>
            <th class="border px-4 py-2">Prénom</th>
            <th class="border px-4 py-2">Nom</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($resStudents as $student): ?>
            <tr>
                <td class="border px-4 py-2"> <?= $student['prenom']; ?> </td>
                <td class="border px-4 py-2"> <?= $student['nom']; ?> </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="bg-white p-6 rounded-lg shadow-md mt-6">
    <h2 class="text-xl font-semibold mb-4">Liste des professeurs</h2>
    <table class="w-full table-auto border-collapse border border-gray-200">
        <thead class="bg-gray-100">
        <tr>
            <th class="border px-4 py-2">Prénom</th>
            <th class="border px-4 py-2">Nom</th>
            <th class="border px-4 py-2">Matière</th>
            <th class="border px-4 py-2">Classe</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($resProfs as $prof): ?>
            <tr>
                <td class="border px-4 py-2"> <?= $prof['prof_prenom']; ?> </td>
                <td class="border px-4 py-2"> <?= $prof['prof_nom']; ?> </td>
                <td class="border px-4 py-2"> <?= $prof['matiere_nom']; ?> </td>
                <td class="border px-4 py-2"> <?= $prof['classe_libelle']; ?> </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
