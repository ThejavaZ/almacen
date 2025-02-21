<?php
// Incluir conexión a la base de datos
include("../../../../bd.php");

// Obtener los materiales
$sentencia = $conexion->prepare("SELECT * FROM `materiales`");
$sentencia->execute();
$materiales = $sentencia->fetchAll(PDO::FETCH_ASSOC);

// Iniciar el buffer de salida
ob_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Materiales</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }
        img {
            width: 100px;
            height: 100px;
        }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Reporte de Materiales</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Material</th>
                <th>Existencia</th>
                <th>Precio</th>
                <th>Disponible</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($materiales as $registro) { 
            ?>
            <tr>
                <td><?php echo $registro['id_material']; ?></td>
                <td><?php echo $registro['material']; ?></td>
                <td><?php echo $registro['existencia']; ?></td>
                <td><?php echo $registro['precio']; ?></td>
                <td><?php echo $registro['disponible']; ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>

<?php
// Obtener el contenido HTML
$html = ob_get_clean();

// Incluir la librería Dompdf
require_once './lib/dompdf/autoload.inc.php';
use Dompdf\Dompdf;
use Dompdf\Options;

// Configurar Dompdf
$options = new Options();
$options->set('isRemoteEnabled', true);  // Habilitar carga de imágenes
$options->set('isHtml5ParserEnabled', true);
$options->set('defaultFont', 'Arial');

// Crear instancia de Dompdf
$dompdf = new Dompdf($options);

// Cargar el HTML
$dompdf->loadHtml($html);

// Configurar tamaño del papel
$dompdf->setPaper('A4', 'portrait');

// Renderizar el PDF
$dompdf->render();

// Mostrar PDF en el navegador
$dompdf->stream("materiales.pdf", ["Attachment" => false]);
?>
