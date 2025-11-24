<?php
/** @var \Helpers\Message $message */
?>

<div class="alert <?= htmlspecialchars($message->getColor(), ENT_QUOTES, 'UTF-8') ?>">
    <?php if ($message->getTitle() !== '') : ?>
        <strong><?= htmlspecialchars($message->getTitle(), ENT_QUOTES, 'UTF-8') ?></strong><br>
    <?php endif; ?>

    <?= nl2br(htmlspecialchars($message->getMessage(), ENT_QUOTES, 'UTF-8')) ?>
</div>
