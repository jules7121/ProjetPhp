<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?= $this->e($title) ?></title>

    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;600;700&family=Rajdhani:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="public/css/main.css"/>
</head>
<body>

<header>
    <nav>
        <ul>
            <li><a href="index.php">Accueil</a></li>
            
            <?php if (!empty($_SESSION['user_id'])): ?>
                <li><a href="index.php?action=all-perso">Tous les personnages</a></li>
                <li><a href="index.php?action=add-perso">Ajouter un personnage</a></li>
                <li><a href="index.php?action=add-perso-element">Ajouter un élément</a></li>
                <li><a href="index.php?action=add-unitclass">Ajouter une classe</a></li>
                <li><a href="index.php?action=add-origin">Ajouter une origine</a></li>
                <li><a href="index.php?action=logs">Logs</a></li>

                <li style="color:#ff335c; font-weight:bold;">
                    Connecté : <?= htmlspecialchars($_SESSION['username']) ?>
                </li>
                <li><a href="index.php?action=logout">Logout</a></li>

            <?php else: ?>
                <li><a href="index.php?action=login">Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

<main id="contenu">
    <?php
    use Helpers\Message;

    if (isset($message) && $message instanceof Message): ?>
        <?= $this->insert('message', ['message' => $message]) ?>
    <?php elseif (!empty($message)): ?>
        <?php
        $msgObj = new Message((string)$message);
        echo $this->insert('message', ['message' => $msgObj]);
        ?>
    <?php endif; ?>

    <?= $this->section('content') ?>
</main>

<footer></footer>

</body>
</html>
