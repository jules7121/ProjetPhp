<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8"/>
    <link rel="stylesheet" href="public/css/main.css"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $this->e($title) ?></title>
</head>
<body>
<main id="contenu">

    <?php if (!empty($message)) : ?>
        <div class="alert">
            <?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?>
        </div>
    <?php endif; ?>

<header>
    
    <nav>
        <ul>
            <li><a href="index.php">Accueil</a></li>
            <li><a href="index.php?action=add-perso">Ajouter un personnage</a></li>
            <li><a href="index.php?action=add-perso-element">Ajouter un élément</a></li>
            <li><a href="index.php?action=logs">Logs</a></li>
            <li><a href="index.php?action=login">Login</a></li>
        </ul>
    </nav>

</header>

<main id="contenu">
    <?=$this->section('content')?>
</main>

<footer>
</footer>

</body>
</html>

