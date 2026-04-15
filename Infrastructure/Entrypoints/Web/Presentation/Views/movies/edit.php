<?php require __DIR__ . '/../layouts/header.php'; ?>
<?php require __DIR__ . '/../layouts/menu.php'; ?>

<h1>Editar película</h1>

<?php if (!empty($message)): ?>
    <div class="alert-error"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></div>
<?php endif; ?>

<form method="POST" action="?route=movies.update">
    <input type="hidden" name="id"
           value="<?= htmlspecialchars($old['id'] ?? $movie->getId(), ENT_QUOTES, 'UTF-8') ?>">

    <div class="form-group">
        <label for="nombre">Nombre</label><br>
        <input type="text" id="nombre" name="nombre"
               value="<?= htmlspecialchars($old['nombre'] ?? $movie->getNombre(), ENT_QUOTES, 'UTF-8') ?>">
    </div>

    <div class="form-group">
        <label for="titulo_original">Título original</label><br>
        <input type="text" id="titulo_original" name="titulo_original"
               value="<?= htmlspecialchars($old['titulo_original'] ?? $movie->getTituloOriginal(), ENT_QUOTES, 'UTF-8') ?>">
    </div>

    <div class="form-group">
        <label for="director">Director</label><br>
        <input type="text" id="director" name="director"
               value="<?= htmlspecialchars($old['director'] ?? $movie->getDirector(), ENT_QUOTES, 'UTF-8') ?>">
    </div>

    <div class="form-group">
        <label for="genero">Género</label><br>
        <select id="genero" name="genero">
            <?php foreach ($genreOptions as $opt): ?>
                <option value="<?= htmlspecialchars($opt, ENT_QUOTES, 'UTF-8') ?>"
                    <?= (($old['genero'] ?? $movie->getGenero()) === $opt) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($opt, ENT_QUOTES, 'UTF-8') ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="duracion_minutos">Duración (minutos)</label><br>
        <input type="number" id="duracion_minutos" name="duracion_minutos" min="1"
               value="<?= htmlspecialchars((string) ($old['duracion_minutos'] ?? $movie->getDuracionMinutos()), ENT_QUOTES, 'UTF-8') ?>">
    </div>

    <div class="form-group">
        <label for="fecha_estreno">Fecha de estreno</label><br>
        <input type="date" id="fecha_estreno" name="fecha_estreno"
               value="<?= htmlspecialchars($old['fecha_estreno'] ?? $movie->getFechaEstreno(), ENT_QUOTES, 'UTF-8') ?>">
    </div>

    <div class="form-group">
        <label for="pais_origen">País de origen</label><br>
        <input type="text" id="pais_origen" name="pais_origen"
               value="<?= htmlspecialchars($old['pais_origen'] ?? $movie->getPaisOrigen(), ENT_QUOTES, 'UTF-8') ?>">
    </div>

    <div class="form-group">
        <label for="idioma_original">Idioma original</label><br>
        <input type="text" id="idioma_original" name="idioma_original"
               value="<?= htmlspecialchars($old['idioma_original'] ?? $movie->getIdiomaOriginal(), ENT_QUOTES, 'UTF-8') ?>">
    </div>

    <div class="form-group">
        <label for="clasificacion_edad">Clasificación de edad</label><br>
        <select id="clasificacion_edad" name="clasificacion_edad">
            <?php foreach ($ageRatingOptions as $opt): ?>
                <option value="<?= htmlspecialchars($opt, ENT_QUOTES, 'UTF-8') ?>"
                    <?= (($old['clasificacion_edad'] ?? $movie->getClasificacionEdad()) === $opt) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($opt, ENT_QUOTES, 'UTF-8') ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="productora">Productora</label><br>
        <input type="text" id="productora" name="productora"
               value="<?= htmlspecialchars($old['productora'] ?? $movie->getProductora(), ENT_QUOTES, 'UTF-8') ?>">
    </div>

    <div class="form-group">
        <label for="sinopsis">Sinopsis</label><br>
        <textarea id="sinopsis" name="sinopsis" rows="4" cols="60"><?= htmlspecialchars($old['sinopsis'] ?? $movie->getSinopsis(), ENT_QUOTES, 'UTF-8') ?></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Guardar cambios</button>
    &nbsp;
    <a class="btn" href="?route=movies.index">Cancelar</a>
</form>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
