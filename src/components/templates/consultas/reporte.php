<?php
// Incluir conexión a la base de datos
include("../../../../bd.php");

// Obtener los consultas
$sentencia = $conexion->prepare("SELECT * FROM consultas");
$sentencia->execute();
$consultas = $sentencia->fetchAll(PDO::FETCH_ASSOC);

// Iniciar el buffer de salida
ob_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de consultas</title>
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
    <h2 style="text-align: center;">Reporte de consultas</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>id_empleado</th>
                <th>id_material</th>
                <th>id_usuario</th>
                <th>fecha</th>
                <th>Cancelada</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($consultas as $registro) { 
            ?>
            <tr>
                <td><?php echo $registro['id_consulta']; ?></td>
                <td><?php echo $registro['id_empleado']; ?></td>
                <td><?php echo $registro['id_material']; ?></td>
                <td><?php echo $registro['id_usuario']; ?></td>
                <td><?php echo $registro['fecha']; ?></td>
                <td><?php echo $registro['cancelada']; ?></td>
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
