<?php

$this->layout('template', ['title' => 'TP Mihoyo']);

?>

<h1>Collection <?= $this->e($gameName) ?></h1>

<?php if ($message !== null) : ?>
    <p class="message"><?= $this->e($message) ?></p>
<?php endif; ?>

<?php if (!empty($listPersonnage)) : ?>
    <table class="perso-table">
        <thead>
            <tr>
                <th>Image</th>
                <th>Nom</th>
                <th>Élément</th>
                <th>Classe</th>
                <th>Rareté</th>
                <th>Origine</th>
                <th>Options</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($listPersonnage as $perso) : ?>
            <tr>
                <td>
                    <?php if ($perso->getUrlImg()) : ?>
                        <img src="<?= $this->e($perso->getUrlImg()) ?>" alt="<?= $this->e($perso->getName()) ?>" class="perso-img">
                    <?php else : ?>
                        -
                    <?php endif; ?>
                </td>
                <td><?= $this->e($perso->getName()) ?></td>
                <td><?= $this->e($perso->getElement()) ?></td>
                <td><?= $this->e($perso->getUnitclass()) ?></td>
                <td><?= $this->e($perso->getRarity()) ?>★</td>
                <td><?= $this->e($perso->getOrigin() ?? 'Inconnu') ?></td>
                <td class="perso-options">
                    <!-- on prépare les liens (même s’ils ne fonctionnent pas encore) -->
                    <a href="index.php?action=edit-perso&id=<?= $this->e($perso->getId()) ?>" class="btn-option btn-edit">Modifier</a>
                    <a href="index.php?action=del-perso&id=<?= $this->e($perso->getId()) ?>" class="btn-option btn-delete">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php else : ?>
    <p>Aucun personnage en base pour le moment.</p>
<?php endif; ?>

