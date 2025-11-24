<?php
/** @var mixed $message */

$this->layout('template', [
    'title'   => 'Login',
    'message' => $message
]);
?>

<h1>Authentification</h1>

<div class="card form-card">
    <form action="index.php?action=login" method="post" class="form-grid">

        <div class="form-field">
            <label for="login-username">Nom d’utilisateur / Email *</label>
            <input type="text" id="login-username" name="username"
                   required placeholder="Votre identifiant">
        </div>

        <div class="form-field">
            <label for="login-password">Mot de passe *</label>
            <input type="password" id="login-password" name="password"
                   required placeholder="********">
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary">Se connecter</button>
            <a href="index.php" class="btn-secondary">Retour</a>
        </div>

    </form>
</div>
