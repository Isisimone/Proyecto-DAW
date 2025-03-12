<?php

require '../vendor/autoload.php';

use Clases\Ajuste;

$ajuste = new Ajuste();
$ajustes = $ajuste->obtenerAjustes();

echo '<pre>';
print_r($ajustes);
echo '</pre>';