<?php
// Incluir conexión a la base de datos
include("../../../../bd.php");

// Obtener los usuarios
$sentencia = $conexion->prepare("SELECT * FROM `usuarios`");
$sentencia->execute();
$usuarios = $sentencia->fetchAll(PDO::FETCH_ASSOC);

// Iniciar el buffer de salida
ob_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Usuarios</title>
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
    <h2 style="text-align: center;">Reporte de Usuarios</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuarios</th>
                <th>Cuenta</th>
                <th>Nivel</th>
                <th>Idioma</th>
                <th>Autorizado</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $registro) { 
            ?>
            <tr>
                <td><?php echo $registro['id_usuario']; ?></td>
                <td><?php echo $registro['usuario']; ?></td>
                <td><?php echo $registro['cuenta']; ?></td>
                <td><?php echo $registro['nivel']; ?></td>
                <td><?php echo $registro['idioma']; ?></td>
                <td><?php echo $registro['autorizado']; ?></td>
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
