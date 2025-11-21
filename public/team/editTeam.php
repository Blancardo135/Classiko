<?php
require_once __DIR__ . '/../../src/utils/autoloader.php';
require_once __DIR__ . '/../../src/config/translations.php';
require_once __DIR__ . '/../../src/config/lang.php';

use Team\TeamsManager;
use Team\Team;
use Database;

session_start();
$currentUserId = $_SESSION['user_id'] ?? null;

$teamsManager = new TeamsManager();

if (isset($_GET["id"])) {
    $teamId = (int) $_GET["id"];

    // ownership check
    $pdo = Database::getInstance()->getPdo();
    $ownerStmt = $pdo->prepare('SELECT owner_user_id FROM teams WHERE id = :id');
    $ownerStmt->bindValue(':id', $teamId, \PDO::PARAM_INT);
    $ownerStmt->execute();
    $owner = $ownerStmt->fetchColumn();

    if ($owner !== false && ($currentUserId === null || (int)$owner !== (int)$currentUserId)) {
        header('Location: ../403.php');
        exit();
    }

    $team = $teamsManager->getTeamById($teamId);

    if (!$team) {
        die(t('not_found'));
    }
} else {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"];
    $nbPlayers = $_POST["nbPlayers"];
    $descr = $_POST["descr"];
    $sport = $_POST["sport"];

    $errors = [];

    try {
        $updatedTeam = new Team(
            $teamId,
            $name,
            (int) $nbPlayers,
            $descr,
            $sport
        );
    } catch (InvalidArgumentException $e) {
        $errors[] = $e->getMessage();
    }

    if (empty($errors)) {
        try {
            $teamsManager->updateTeam($updatedTeam);
            header("Location: index.php");
            exit();
        } catch (PDOException $e) {
            if ($e->getCode() === "23000") {
                $errors[] = t('tool_exists');
            } else {
                $errors[] = t('db_error') . $e->getMessage();
            }
        } catch (Exception $e) {
            $errors[] = t('unexpected_error') . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="<?= $language ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="light dark">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
    <link rel="stylesheet" href="../assets/css/custom.css">
    <title><?= t('edit_team') ?> | MyApp</title>
</head>

<body>
    <main class="container">
        <h1><?= t('edit_team') ?></h1>

        <p><a href="../index.php"><?= t('home') ?></a> > <a href="index.php"><?= t('teams_management') ?></a> > <?= t('edit_team') ?></p>

        <?php if ($_SERVER["REQUEST_METHOD"] === "POST") { ?>
            <?php if (empty($errors)) { ?>
                <p style="color: green;"><?= t('team_updated_success') ?></p>
            <?php } else { ?>
                <p style="color: red;"><?= t('form_error') ?></p>
                <ul>
                    <?php foreach ($errors as $error) { ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php } ?>
                </ul>
            <?php } ?>
        <?php } ?>

        <form action="editTeam.php?id=<?= htmlspecialchars($teamId) ?>" method="POST">
            <label for="name"><?= t('team_name') ?></label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($team->getName() ?? '') ?>" required minlength="2">

            <label for="nbPlayers"><?= t('team_nbPlayers') ?></label>
            <input type="number" id="nbPlayers" name="nbPlayers" value="<?= htmlspecialchars($team->getNbPlayers() ?? '') ?>" required min="1">

            <label for="descr"><?= t('team_description') ?></label>
            <textarea id="descr" name="descr" required><?= htmlspecialchars($team->getDescr() ?? '') ?></textarea>

            <label for="sport"><?= t('team_sport') ?></label>
            <input type="text" id="sport" name="sport" value="<?= htmlspecialchars($team->getSport() ?? '') ?>" required>

            <button type="submit"><?= t('update_team') ?></button>
        </form>
    </main>
</body>

</html>