<?php
/** @var mixed $message */
/** @var ?\Models\Personnage $perso */
/** @var string $mode */
/** @var \Models\Element[] $elements */
/** @var \Models\UnitClass[] $unitclasses */
/** @var \Models\Origin[] $origins */

$mode = $mode ?? 'create';
$isEdit = $mode === 'edit';

$titlePage = $isEdit ? 'Modifier un personnage' : 'Ajouter un personnage';
$actionUrl = $isEdit
    ? 'index.php?action=edit-perso'
    : 'index.php?action=add-perso';

?>
<?php $this->layout('template', ['title' => $titlePage, 'message' => $message]); ?>

<h1><?= $titlePage ?></h1>

<div class="card form-card">
    <form action="<?= $actionUrl ?>" method="post" class="form-grid">

        <?php if ($isEdit && isset($perso)) : ?>
            <input type="hidden" name="idPerso" value="<?= htmlspecialchars($perso->getId()) ?>">
        <?php endif; ?>

        <!-- NOM -->
        <div class="form-field">
            <label for="perso-nom">Nom *</label>
            <input type="text" id="perso-nom" name="perso-nom"
                required
                value="<?= isset($perso) ? htmlspecialchars($perso->getName()) : '' ?>">
        </div>

        <!-- ÉLÉMENT -->
        <div class="form-field">
            <label for="perso-element">Élément *</label>
            <select id="perso-element" name="perso-element" required>
                <option value="">-- Choisir un élément --</option>

                <?php foreach ($elements as $e): ?>
                    <option value="<?= $e->getId() ?>"
                        <?= isset($perso) && $perso->getElementId() === $e->getId() ? 'selected' : '' ?>>
                        <?= htmlspecialchars($e->getName()) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- CLASSE -->
        <div class="form-field">
            <label for="perso-unitclass">Classe / Arme *</label>
            <select id="perso-unitclass" name="perso-unitclass" required>
                <option value="">-- Choisir une classe --</option>

                <?php foreach ($unitclasses as $u): ?>
                    <option value="<?= $u->getId() ?>"
                        <?= isset($perso) && $perso->getUnitclassId() === $u->getId() ? 'selected' : '' ?>>
                        <?= htmlspecialchars($u->getName()) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- RARETÉ -->
        <div class="form-field">
            <label for="perso-rarity">Rareté (4, 5...) *</label>
            <input type="number" id="perso-rarity" name="perso-rarity"
                   min="1" max="5" required
                   value="<?= isset($perso) ? htmlspecialchars($perso->getRarity()) : '' ?>">
        </div>

        <!-- ORIGINE -->
        <div class="form-field">
            <label for="perso-origin">Origine</label>
            <select id="perso-origin" name="perso-origin">
                <option value="">-- Aucune / Inconnue --</option>

                <?php foreach ($origins as $o): ?>
                    <option value="<?= $o->getId() ?>"
                        <?= isset($perso) && $perso->getOriginId() === $o->getId() ? 'selected' : '' ?>>
                        <?= htmlspecialchars($o->getName()) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- IMAGE -->
        <div class="form-field">
            <label for="perso-url-img">URL de l’image *</label>
            <input type="url" id="perso-url-img" name="perso-url-img"
                   required placeholder="https://..."
                   value="<?= isset($perso) ? htmlspecialchars($perso->getUrlImg()) : '' ?>">
        </div>

        <!-- BOUTONS -->
        <div class="form-actions">
            <button type="submit" class="btn-primary">Valider</button>
            <a href="index.php" class="btn-secondary">Retour</a>
        </div>

    </form>
</div>
