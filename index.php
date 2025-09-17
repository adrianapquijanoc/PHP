<?php
// Inicializar variables
$fibo = [];
$frase = "";
$esPalindromo = null;
$numeroPrimo = null;

// Ejecutar solo si se envió el formulario
if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] === "POST") {
    // === Fibonacci ===
    $numFibo = intval($_POST["numFibo"]);
    if ($numFibo > 0) {
        $fibo = [0, 1];
        for ($i = 2; $i < $numFibo; $i++) {
            $fibo[$i] = $fibo[$i - 1] + $fibo[$i - 2];
        }
        if ($numFibo === 1) $fibo = [0];
    }

    // === Palíndromo ===
    $frase = $_POST["frase"];
    $limpio = preg_replace("/[^A-Za-z0-9]/", "", strtolower($frase));
    $esPalindromo = $limpio === strrev($limpio);

    // === Número Primo ===
    $numeroPrimo = intval($_POST["numPrimo"] ?? 0);
    $esPrimo = false;
    if ($numeroPrimo > 1) {
        $esPrimo = true;
        for ($i = 2; $i <= sqrt($numeroPrimo); $i++) {
            if ($numeroPrimo % $i === 0) {
                $esPrimo = false;
                break;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicios PHP</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Fondo degradado y texto blanco */
        body {
            background: linear-gradient(135deg, #1f1c2c, #928dab);
            color: #fff;
            min-height: 100vh;
        }

        /* Efecto hover en tarjetas */
        .card-glow {
            transition: transform 0.3s, box-shadow 0.3s;
            border: none;
            overflow: hidden;
            color: #fff;
        }
        .card-glow:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.5);
        }

        /* Bordes redondeados en inputs y botones */
        .form-control, .btn-success, .btn-primary {
            border-radius: 0.5rem;
        }

        /* Badges con texto blanco */
        .badge {
            font-size: 1rem;
            color: #fff !important;
        }

        /* Ajuste de enlaces dentro de tarjetas */
        .card a {
            color: #fff;
            text-decoration: none;
        }
        .card a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<div class="container py-5">
    <h1 class="text-center mb-5 display-5 fw-bold">🎉 Ejercicios PHP</h1>

    <!-- Formulario -->
    <div class="row justify-content-center mb-5">
        <div class="col-12 col-md-8 col-lg-6">
            <div class="card bg-dark bg-opacity-75 p-4 shadow-lg card-glow">
                <h3 class="text-center mb-4">Ingresa los datos</h3>
                <form method="post">
                    <div class="mb-3">
                        <label class="form-label">Número de términos Fibonacci</label>
                        <input type="number" name="numFibo" class="form-control" min="1" value="<?= $_POST['numFibo'] ?? '' ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Frase para verificar Palíndromo</label>
                        <input type="text" name="frase" class="form-control" value="<?= $_POST['frase'] ?? '' ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Número para verificar si es Primo</label>
                        <input type="number" name="numPrimo" class="form-control" value="<?= $_POST['numPrimo'] ?? '' ?>" min="0" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-success btn-lg">Generar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Resultados -->
    <?php if (!empty($fibo) || $frase !== "" || $numeroPrimo !== null): ?>
    <div class="row g-4 justify-content-center">
        <?php if (!empty($fibo)): ?>
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card bg-dark bg-opacity-75 p-3 shadow-lg card-glow text-center">
                <h4 class="mb-3">Fibonacci (<?= count($fibo) ?> términos)</h4>
                <p class="fs-5"><?= implode(", ", $fibo) ?></p>
            </div>
        </div>
        <?php endif; ?>

        <?php if ($frase !== ""): ?>
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card bg-dark bg-opacity-75 p-3 shadow-lg card-glow text-center">
                <h4 class="mb-3">Palíndromo</h4>
                <p class="fs-5">La frase: "<strong><?= htmlspecialchars($frase) ?></strong>"</p>
                <span class="badge rounded-pill <?= $esPalindromo ? 'bg-success' : 'bg-danger' ?>">
                    <?= $esPalindromo ? 'Es Palíndromo ✅' : 'No es Palíndromo ❌' ?>
                </span>
            </div>
        </div>
        <?php endif; ?>

        <?php if ($numeroPrimo !== null): ?>
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card bg-dark bg-opacity-75 p-3 shadow-lg card-glow text-center">
                <h4 class="mb-3">Número Primo</h4>
                <p class="fs-5">El número: <strong><?= $numeroPrimo ?></strong></p>
                <span class="badge rounded-pill <?= $esPrimo ? 'bg-success' : 'bg-danger' ?>">
                    <?= $esPrimo ? 'Es Primo ✅' : 'No es Primo ❌' ?>
                </span>
            </div>
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
