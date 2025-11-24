<?php $this->layout('template', ['title' => 'TP Mihoyo']); ?>

<h1>Collection <?= $this->e($gameName) ?></h1>

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

            <!-- IMAGE -->
            <td>
                <?php if ($perso->getUrlImg()) : ?>
                    <img src="<?= $this->e($perso->getUrlImg()) ?>" 
                         alt="<?= $this->e($perso->getName()) ?>" 
                         class="perso-img">
                <?php else : ?> - <?php endif; ?>
            </td>

            <!-- NOM -->
            <td><?= $this->e($perso->getName()) ?></td>

            <!-- ELEMENT / BADGE -->
            <td>
                <?php $el = $perso->getElement(); ?>

                <?php if ($el): ?>
                    <span class="badge-element">
                        <?php if ($el->getUrlImg()): ?>
                            <img src="<?= $el->getUrlImg() ?>" alt="">
                        <?php endif; ?>
                        <?= $el->getName() ?>
                    </span>
                <?php else: ?>
                    -
                <?php endif; ?>
            </td>

            <!-- CLASSE -->
            <td>
                <?php $uc = $perso->getUnitclass(); ?>

                <?php if ($uc): ?>
                    <span class="badge-element">
                        <?php if ($uc->getUrlImg()): ?>
                            <img src="<?= $uc->getUrlImg() ?>" alt="">
                        <?php endif; ?>
                        <?= $uc->getName() ?>
                    </span>
                <?php else: ?>
                    -
                <?php endif; ?>
            </td>

            <!-- RARETE -->
            <td><?= $this->e($perso->getRarity()) ?>★</td>

            <!-- ORIGINE -->
            <td>
                <?php $orig = $perso->getOrigin(); ?>

                <?php if ($orig): ?>
                    <span class="badge-element">
                        <?php if ($orig->getUrlImg()): ?>
                            <img src="<?= $orig->getUrlImg() ?>" alt="">
                        <?php endif; ?>
                        <?= $orig->getName() ?>
                    </span>
                <?php else: ?>
                    <span class="badge-element">Inconnue</span>
                <?php endif; ?>
            </td>

            <!-- OPTIONS : BOUTONS -->
            <td class="perso-options">

                <a href="index.php?action=edit-perso&id=<?= $this->e($perso->getId()) ?>"
                   class="btn-option btn-edit">
                    Modifier
                </a>

                <a href="index.php?action=del-perso&id=<?= $this->e($perso->getId()) ?>"
                   class="btn-option btn-delete">
                    Supprimer
                </a>

            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>

</table>

<?php else : ?>
    <p>Aucun personnage en base pour le moment.</p>
<?php endif; ?>
