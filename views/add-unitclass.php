<?php
/** @var mixed $message */
$this->layout('template', [
    'title' => 'Ajouter une classe / arme',
    'message' => $message
]);
?>

<h1>Ajouter une classe / arme</h1>

<div class="card form-card">
    <form action="index.php?action=add-unitclass" method="post" class="form-grid">

        <div class="form-field">
            <label for="unitclass-name">Nom de la classe *</label>
            <input type="text" id="unitclass-name" name="unitclass-name" required placeholder="Épéiste, Lancier, Mage...">
        </div>

        <div class="form-field">
            <label for="unitclass-img">URL de l’icône</label>
            <input type="url" id="unitclass-img" name="unitclass-img" placeholder="https://...">
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary">Valider</button>
            <a href="index.php" class="btn-secondary">Retour</a>
        </div>

    </form>
</div>
