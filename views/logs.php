<?php
/** @var mixed $message */
/** @var string[] $files */
/** @var ?string $content */

$this->layout('template', [
    'title'   => 'Logs',
    'message' => $message
]);

$selectedFile = $_GET['file'] ?? null;
?>

<h1>Journal des logs</h1>

<div class="card">
    <h2 style="margin-bottom: 15px;">Fichiers de logs disponibles</h2>

    <?php if (empty($files)): ?>
        <p>Aucun fichier de log pour le moment.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($files as $f): ?>
                <?php
                $isActive = ($selectedFile === $f);
                ?>
                <li style="margin-bottom: 8px;">
                    <a href="index.php?action=logs&file=<?= urlencode($f) ?>"
                       style="
                           text-decoration:none;
                           font-weight:<?= $isActive ? '700' : '500' ?>;
                           color:<?= $isActive ? '#ff335c' : '#e6e6e6' ?>;
                       ">
                        <?= htmlspecialchars($f) ?>
                        <?= $isActive ? ' ⟵' : '' ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>

<?php if (!empty($content)) : ?>
    <div class="card">
        <h2 style="margin-bottom: 10px;">
            Contenu du fichier : <?= htmlspecialchars($selectedFile ?? '') ?>
        </h2>
        <pre><?= htmlspecialchars($content) ?></pre>
    </div>
<?php endif; ?>
