<?php $this->layout('template', ['title' => 'TP Mihoyo']); ?>

<h1><?= $this->e($pageTitle) ?></h1>

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
        <?php
        // Vérifie si l'utilisateur est connecté
        $isLogged = isset($_SESSION['user_id']);
        
        // On regarde si le perso est dans la collection si on a la collection
        $inCollection = false;
        if (isset($collection)) {
            $inCollection = in_array($perso->getId(), $collection);
        }
        if (!$inCollection && (isset($onlyCollection) && $onlyCollection)) continue;
        ?>
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

        <!-- Boutons admin (edit/delete) -->
        <a href="index.php?action=edit-perso&id=<?= $this->e($perso->getId()) ?>"
        class="btn-option btn-edit">
            Modifier
        </a>

        <a href="index.php?action=del-perso&id=<?= $this->e($perso->getId()) ?>"
        class="btn-option btn-delete">
            Supprimer
        </a>

        <!-- Boutons collection -->
        <?php if (!$isLogged): ?>

            <a href="index.php?action=login"
            class="btn-option btn-secondary"
            style="margin-left:10px;">
                Se connecter
            </a>

        <?php else: ?>

        <?php if ($inCollection): ?>
            <!-- Bouton - (retirer) -->
            <a href="index.php?action=remove-collection&id=<?= $perso->getId() ?>"
               class="btn-option btn-delete"
               style="background:rgba(255,0,50,0.45);">
                – Retirer
            </a>
        <?php else: ?>
            <!-- Bouton + (ajouter) -->
            <a href="index.php?action=add-collection&id=<?= $perso->getId() ?>"
               class="btn-option btn-edit"
               style="background:rgba(0,255,100,0.20);color:#00ff73;">
                + Ajouter
            </a>
        <?php endif; ?>

    <?php endif; ?>

</td>


        </tr>
    <?php endforeach; ?>
    </tbody>

</table>

<?php else : ?>
    <p>Aucun personnage en base pour le moment.</p>
<?php endif; ?>
