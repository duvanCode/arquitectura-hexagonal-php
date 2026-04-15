<?php require __DIR__ . '/../layouts/header.php'; ?>
<?php require __DIR__ . '/../layouts/menu.php'; ?>

<h1>Lista de películas</h1>

<?php if (!empty($success)): ?>
    <div class="alert-success"><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?></div>
<?php endif; ?>

<?php if (!empty($message)): ?>
    <div class="alert-error"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></div>
<?php endif; ?>

<p><a class="btn btn-primary" href="?route=movies.create">Nueva película</a></p>

<?php if (empty($movies)): ?>
    <p>No hay películas registradas todavía.</p>
<?php else: ?>
    <table cellpadding="8" cellspacing="0" style="width: 100%;">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Director</th>
                <th>Género</th>
                <th>Duración</th>
                <th>Estreno</th>
                <th>Clasificación</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($movies as $movie): ?>
                <tr>
                    <td><?= htmlspecialchars($movie->getNombre(), ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($movie->getDirector(), ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($movie->getGenero(), ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars((string) $movie->getDuracionMinutos(), ENT_QUOTES, 'UTF-8') ?> min</td>
                    <td><?= htmlspecialchars($movie->getFechaEstreno(), ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($movie->getClasificacionEdad(), ENT_QUOTES, 'UTF-8') ?></td>
                    <td>
                        <a class="btn btn-sm btn-primary" href="?route=movies.show&id=<?= urlencode($movie->getId()) ?>">Ver</a>
                        <a class="btn btn-sm btn-warning" href="?route=movies.edit&id=<?= urlencode($movie->getId()) ?>">Editar</a>
                        <form method="POST" action="?route=movies.delete" style="display:inline;">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($movie->getId(), ENT_QUOTES, 'UTF-8') ?>">
                            <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('¿Seguro que deseas eliminar esta película?');">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
