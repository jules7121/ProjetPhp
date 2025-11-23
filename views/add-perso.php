<?php
/** @var ?string $message */
/** @var ?\Models\Personnage $perso */
/** @var string $mode */
$mode = $mode ?? 'create'; // 'create' ou 'edit'

// Titre et action selon le mode
$isEdit = $mode === 'edit';

$titlePage = $isEdit ? 'Modifier un personnage' : 'Ajouter un personnage';
$actionUrl = $isEdit
    ? 'index.php?action=edit-perso'
    : 'index.php?action=add-perso';

$buttonText = $isEdit ? 'Enregistrer les modifications' : 'Ajouter le personnage';

// valeurs par défaut si on a un personnage (mode edit)
$val = fn($getter, $default = '') => isset($perso) ? htmlspecialchars($perso->$getter(), ENT_QUOTES, 'UTF-8') : $default;
?>

<?php $this->layout('template', ['title' => $titlePage, 'message' => $message]); ?>

<h1><?= $titlePage ?></h1>

<div class="card form-card">
    <form action="<?= $actionUrl ?>" method="post" class="form-grid">

        <?php if ($isEdit && isset($perso)) : ?>
            <!-- id caché pour l'update -->
            <input type="hidden" name="idPerso" value="<?= $val('getId') ?>">
        <?php endif; ?>

        <div class="form-field">
            <label for="perso-nom">Nom *</label>
            <input type="text" id="perso-nom" name="perso-nom"
                   required
                   value="<?= $val('getName') ?>">
        </div>

        <div class="form-field">
            <label for="perso-element">Élément *</label>
            <input type="text" id="perso-element" name="perso-element"
                   placeholder="Pyro, Hydro, etc."
                   required
                   value="<?= $val('getElement') ?>">
        </div>

        <div class="form-field">
            <label for="perso-unitclass">Classe / Arme *</label>
            <input type="text" id="perso-unitclass" name="perso-unitclass"
                   placeholder="Épéiste, Arcaniste..."
                   required
                   value="<?= $val('getUnitclass') ?>">
        </div>

        <div class="form-field">
            <label for="perso-rarity">Rareté (4, 5...) *</label>
            <input type="number" id="perso-rarity" name="perso-rarity"
                   min="1" max="5" step="1"
                   required
                   value="<?= $val('getRarity') ?>">
        </div>

        <div class="form-field">
            <label for="perso-origin">Origine</label>
            <input type="text" id="perso-origin" name="perso-origin"
                   placeholder="Mondstadt, Liyue..."
                   value="<?= $val('getOrigin') ?>">
        </div>

        <div class="form-field">
            <label for="perso-url-img">URL de l’image *</label>
            <input type="url" id="perso-url-img" name="perso-url-img"
                   placeholder="https://..."
                   required
                   value="<?= $val('getUrlImg') ?>">
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary">
                <?= $buttonText ?>
            </button>
            <a href="index.php" class="btn-secondary">Retour à la liste</a>
        </div>
    </form>
</div>
