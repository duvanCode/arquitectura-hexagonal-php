<?php require __DIR__ . '/../layouts/header.php'; ?>

<div class="auth-box">
    <h1>Nueva contraseña</h1>

    <?php if (!empty($message)): ?>
        <div class="alert-error"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>

    <form method="POST" action="?route=auth.reset.send">
        <input type="hidden" name="token"
               value="<?= htmlspecialchars($token ?? '', ENT_QUOTES, 'UTF-8') ?>">

        <div class="form-group">
            <label for="password">Nueva contraseña</label><br>
            <input type="password" id="password" name="password"
                   autocomplete="new-password" autofocus>
            <?php if (!empty($errors['password'])): ?>
                <div class="field-error"><?= htmlspecialchars($errors['password'], ENT_QUOTES, 'UTF-8') ?></div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirmar contraseña</label><br>
            <input type="password" id="password_confirmation" name="password_confirmation"
                   autocomplete="new-password">
        </div>

        <button type="submit" class="btn btn-primary">Guardar nueva contraseña</button>
    </form>

    <p style="margin-top: 16px;">
        <a href="?route=auth.login">Volver al inicio de sesión</a>
    </p>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
