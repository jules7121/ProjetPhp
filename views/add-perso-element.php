<?php
/** @var mixed $message */
$this->layout('template', [
    'title' => 'Ajouter un élément',
    'message' => $message
]);
?>

<h1>Ajouter un élément</h1>

<div class="card form-card">
    <form action="index.php?action=add-perso-element" method="post" class="form-grid">

        <div class="form-field">
            <label for="element-name">Nom de l’élément *</label>
            <input type="text" id="element-name" name="element-name" required placeholder="Pyro, Hydro, Cryo...">
        </div>

        <div class="form-field">
            <label for="element-img">URL de l’icône *</label>
            <input type="url" id="element-img" name="element-img" required placeholder="https://...">
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary">Valider</button>
            <a href="index.php" class="btn-secondary">Retour</a>
        </div>

    </form>
</div>
