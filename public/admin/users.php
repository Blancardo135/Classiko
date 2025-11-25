<?php
require_once __DIR__ . '/../../src/utils/autoloader.php';
require_once __DIR__ . '/../../src/config/translations.php';
require_once __DIR__ . '/../../src/config/lang.php';

use Database;

require_once __DIR__ . '/../../src/utils/auth.php';
$currentUserId = requireAdmin();

$userManager = new userManager();
$users = $userManager->getAllUsers();

$message = '';
$error = '';

// Traiter la mise à jour du rôle
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id']) && isset($_POST['new_role'])) {
    $userId = (int) $_POST['user_id'];
    $newRole = trim($_POST['new_role']);

    if (in_array($newRole, ['admin', 'user'])) {
        try {
            if ($userManager->updateUserRole($userId, $newRole)) {
                $message = t('form_submit');
                // Rafraîchir la liste
                $users = $userManager->getAllUsers();
            } else {
                $error = t('unexpected_error') . 'Role update failed.';
            }
        } catch (Exception $e) {
            $error = t('unexpected_error') . $e->getMessage();
        }
    } else {
        $error = t('unexpected_error') . 'Invalid role.';
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
    <link rel="stylesheet" href="../css/custom.css">

    <title><?= t('admin_panel_title') ?> | <?= t('app_name') ?></title>
</head>

<body>
    <main class="container">
        <h1><?= t('admin_panel') ?></h1>

        <p><a href="../index.php"><?= t('home') ?></a> > <?= t('admin_panel') ?></p>

        <?php if (!empty($message)): ?>
            <article style="background-color: #ddffdd; border: 1px solid #51cf66; padding: 1rem; border-radius: 0.5rem;">
                <p><?= htmlspecialchars($message) ?></p>
            </article>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <article style="background-color: #ffdddd; border: 1px solid #ff6b6b; padding: 1rem; border-radius: 0.5rem;">
                <p><?= htmlspecialchars($error) ?></p>
            </article>
        <?php endif; ?>

        <h2><?= t('users_list') ?></h2>

        <table>
            <thead>
                <tr>
                    <th><?= t('user_id') ?></th>
                    <th><?= t('user_firstname') ?></th>
                    <th><?= t('user_lastname') ?></th>
                    <th><?= t('user_email') ?></th>
                    <th><?= t('user_role') ?></th>
                    <th><?= t('actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= htmlspecialchars($user['id']) ?></td>
                        <td><?= htmlspecialchars($user['firstname']) ?></td>
                        <td><?= htmlspecialchars($user['lastname']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td><?= $user['role'] === 'admin' ? t('role_admin') : t('role_user') ?></td>
                        <td>
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="user_id" value="<?= htmlspecialchars($user['id']) ?>">
                                <?php if ($user['role'] === 'admin'): ?>
                                    <input type="hidden" name="new_role" value="user">
                                    <button type="submit"><?= t('revoke_admin') ?></button>
                                <?php else: ?>
                                    <input type="hidden" name="new_role" value="admin">
                                    <button type="submit"><?= t('make_admin') ?></button>
                                <?php endif; ?>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <p><a href="../index.php"><button><?= t('home') ?></button></a></p>
    </main>
</body>

</html>
