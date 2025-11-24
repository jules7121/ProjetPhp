<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?= $this->e($title) ?></title>

    <!-- Polices futuristes -->
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;600;700&family=Rajdhani:wght@400;600&display=swap" rel="stylesheet">

    <!-- CSS principal -->
    <link rel="stylesheet" href="public/css/main.css"/>
</head>
<body>

<header>
    <nav>
        <ul>
            <li><a href="index.php">Accueil</a></li>
            <li><a href="index.php?action=add-perso">Ajouter un personnage</a></li>
            <li><a href="index.php?action=add-perso-element">Ajouter un élément</a></li>
            <li><a href="index.php?action=add-unitclass">Ajouter une classe</a></li>
            <li><a href="index.php?action=add-origin">Ajouter une origine</a></li>
            <li><a href="index.php?action=logs">Logs</a></li>
            <li><a href="index.php?action=login">Login</a></li>
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

<footer>
</footer>

<!-- Script pour les icônes dans les <select> (si tu as des URL d'icônes) -->
<script>
document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll("select").forEach(select => {
        select.addEventListener("change", function() {
            const opt = this.selectedOptions[0];
            if (opt && opt.dataset.icon) {
                this.style.backgroundImage = `url('${opt.dataset.icon}')`;
                this.style.backgroundRepeat = "no-repeat";
                this.style.backgroundSize   = "24px 24px";
                this.style.backgroundPosition = "8px center";
                this.style.paddingLeft = "40px";
            } else {
                this.style.backgroundImage = "none";
                this.style.paddingLeft = "12px";
            }
        });

        const opt = select.selectedOptions[0];
        if (opt && opt.dataset.icon) {
            select.style.backgroundImage = `url('${opt.dataset.icon}')`;
            select.style.backgroundRepeat = "no-repeat";
            select.style.backgroundSize   = "24px 24px";
            select.style.backgroundPosition = "8px center";
            select.style.paddingLeft = "40px";
        }
    });
});
</script>

</body>
</html>
