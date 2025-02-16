<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    if (isset($data['descriptor'])) {
        $descriptor = $data['descriptor'];
        $fileName = uniqid() . '.json';
        $filePath = 'rostros/' . $fileName;

        if (!is_dir('rostros')) {
            mkdir('rostros', 0777, true);
        }

        file_put_contents($filePath, json_encode($descriptor));
        echo json_encode(['message' => 'Descriptor guardado con éxito', 'fileName' => $fileName]);
    } else {
        echo json_encode(['error' => 'Datos de descriptor no válidos']);
    }
}
?>

