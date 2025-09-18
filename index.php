<?php
// ==========================
// BLOQUE PHP - PROCESO FORMULARIO
// ==========================

// Inicializar variables para almacenar resultados
$fibo = [];            // Array que contendrá la secuencia de Fibonacci
$frase = "";           // Frase ingresada para verificar palíndromo
$esPalindromo = null;  // Booleano que indica si la frase es palíndromo
$numeroPrimo = null;   // Número ingresado para verificar si es primo
$esPrimo = null;       // Booleano que indica si el número es primo

// ==========================
// PROCESAR FORMULARIO
// Solo se ejecuta si el usuario envió un valor válido en 'numFibo'
// intval() convierte a entero. '?? 0' asegura que si no se envió, tome 0.
// El if se cumple solo si el valor convertido es mayor que 0
// ==========================
if (intval($_POST["numFibo"] ?? 0)) {

    // ==========================
    // FIBONACCI
    // ==========================
    $numFibo = intval($_POST["numFibo"]);  // Convertir a entero

    if ($numFibo === 1) {
        // Caso especial: solo 1 término
        $fibo = [0];
    } elseif ($numFibo > 1) {
        // Para 2 o más términos, iniciar la secuencia
        $fibo = [0, 1];
        for ($i = 2; $i < $numFibo; $i++) {
            // Cada término es la suma de los dos anteriores
            $fibo[$i] = $fibo[$i - 1] + $fibo[$i - 2];
        }
    }

    // ==========================
    // PALÍNDROMO
    // ==========================
    $frase = $_POST["frase"] ?? "";  // Obtener la frase del formulario
    // Limpiar frase: quitar caracteres no alfanuméricos y pasar a minúsculas
    $limpio = preg_replace("/[^A-Za-z0-9]/", "", strtolower($frase));
    // Comparar con su reverso para determinar si es palíndromo
    $esPalindromo = $limpio === strrev($limpio);

    // ==========================
    // NÚMERO PRIMO
    // ==========================
    $numeroPrimo = intval($_POST["numPrimo"] ?? 0); // Obtener número
    $esPrimo = false;  // Inicialmente asumimos que no es primo

    if ($numeroPrimo > 1) {
        $esPrimo = true;  // Suponemos que es primo

        // Verificar divisores desde 2 hasta la raíz cuadrada del número
        for ($i = 2; $i <= sqrt($numeroPrimo); $i++) {
            if ($numeroPrimo % $i === 0) {
                // Si encontramos un divisor, no es primo
                $esPrimo = false;
                break; // Salir del bucle
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

    <!-- ==========================
         FORMULARIO DE ENTRADA
         ========================== -->
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

    <!-- ==========================
         RESULTADOS
         ========================== -->
    <?php if (!empty($fibo) || $frase !== "" || $numeroPrimo !== null): ?>
    <div class="row g-4 justify-content-center">

        <!-- Fibonacci -->
        <?php if (!empty($fibo)): ?>
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card bg-dark bg-opacity-75 p-3 shadow-lg card-glow text-center">
                <h4 class="mb-3">Fibonacci (<?= count($fibo) ?> términos)</h4>
                <p class="fs-5"><?= implode(", ", $fibo) ?></p>
            </div>
        </div>
        <?php endif; ?>

        <!-- Palíndromo -->
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

        <!-- Número Primo -->
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
