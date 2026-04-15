<?php require __DIR__ . '/../layouts/header.php'; ?>
<?php require __DIR__ . '/../layouts/menu.php'; ?>

<h1>Detalle de película</h1>

<?php if (!empty($message)): ?>
    <div class="alert-error"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></div>
<?php endif; ?>

<table class="detail-table">
    <tr>
        <th>ID</th>
        <td><?= htmlspecialchars($movie->getId(), ENT_QUOTES, 'UTF-8') ?></td>
    </tr>
    <tr>
        <th>Nombre</th>
        <td><?= htmlspecialchars($movie->getNombre(), ENT_QUOTES, 'UTF-8') ?></td>
    </tr>
    <tr>
        <th>Título original</th>
        <td><?= htmlspecialchars($movie->getTituloOriginal(), ENT_QUOTES, 'UTF-8') ?></td>
    </tr>
    <tr>
        <th>Director</th>
        <td><?= htmlspecialchars($movie->getDirector(), ENT_QUOTES, 'UTF-8') ?></td>
    </tr>
    <tr>
        <th>Género</th>
        <td><?= htmlspecialchars($movie->getGenero(), ENT_QUOTES, 'UTF-8') ?></td>
    </tr>
    <tr>
        <th>Duración</th>
        <td><?= htmlspecialchars((string) $movie->getDuracionMinutos(), ENT_QUOTES, 'UTF-8') ?> minutos</td>
    </tr>
    <tr>
        <th>Fecha de estreno</th>
        <td><?= htmlspecialchars($movie->getFechaEstreno(), ENT_QUOTES, 'UTF-8') ?></td>
    </tr>
    <tr>
        <th>País de origen</th>
        <td><?= htmlspecialchars($movie->getPaisOrigen(), ENT_QUOTES, 'UTF-8') ?></td>
    </tr>
    <tr>
        <th>Idioma original</th>
        <td><?= htmlspecialchars($movie->getIdiomaOriginal(), ENT_QUOTES, 'UTF-8') ?></td>
    </tr>
    <tr>
        <th>Clasificación de edad</th>
        <td><?= htmlspecialchars($movie->getClasificacionEdad(), ENT_QUOTES, 'UTF-8') ?></td>
    </tr>
    <tr>
        <th>Productora</th>
        <td><?= htmlspecialchars($movie->getProductora(), ENT_QUOTES, 'UTF-8') ?></td>
    </tr>
    <tr>
        <th>Sinopsis</th>
        <td><?= htmlspecialchars($movie->getSinopsis(), ENT_QUOTES, 'UTF-8') ?></td>
    </tr>
</table>

<p style="margin-top: 16px;">
    <a class="btn btn-warning" href="?route=movies.edit&amp;id=<?= urlencode($movie->getId()) ?>">Editar</a>
    &nbsp;
    <a class="btn" href="?route=movies.index">Volver al listado</a>
</p>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
