<?php
/** @var mixed $message */
$this->layout('template', [
    'title' => 'Ajouter une origine',
    'message' => $message
]);
?>

<h1>Ajouter une origine</h1>

<div class="card form-card">
    <form action="index.php?action=add-origin" method="post" class="form-grid">

        <div class="form-field">
            <label for="origin-name">Nom de l’origine *</label>
            <input type="text" id="origin-name" name="origin-name" required placeholder="Mondstadt, Snezhnaya...">
        </div>

        <div class="form-field">
            <label for="origin-img">URL de l’icône</label>
            <input type="url" id="origin-img" name="origin-img" placeholder="https://...">
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary">Valider</button>
            <a href="index.php" class="btn-secondary">Retour</a>
        </div>

    </form>
</div>
