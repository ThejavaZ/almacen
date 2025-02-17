<?php
include("../../../../bd.php");
include("../../header.php");

// Obtener usuarios
$sentencia = $conexion->prepare("SELECT * FROM `usuarios`");
$sentencia->execute();
$usuarios = $sentencia->fetchAll(PDO::FETCH_ASSOC);

// Definir rutas de almacenamiento
$ruta_words = "../../temp/users/word/";
$ruta_excel = "../../temp/users/excel/";
$ruta_pdf = "../../temp/users/pdf/";

// Crear carpetas si no existen
foreach ([$ruta_words, $ruta_excel, $ruta_pdf] as $ruta) {
    if (!file_exists($ruta)) {
        mkdir($ruta, 0777, true);
    }
}

foreach ($usuarios as $registro) {
    $id_usuario = $registro["id_usuario"];
    $usuario = $registro["usuario"];
    $cuenta = $registro["cuenta"];
    $nivel = $registro["nivel"];
    $idioma = $registro["idioma"];
    $autorizado = $registro["autorizado"];

    // Rutas de archivos
    $ruta_word = $ruta_words . $id_usuario . ".docx";
    $ruta_excel = $ruta_excel . $id_usuario . ".xlsx";
    $ruta_pdf = $ruta_pdf . $id_usuario . ".pdf";

    // // Generar archivo Word
    // $word = new PhpWord();
    // $section = $word->addSection();
    // $section->addText("ID: " . $id_usuario);
    // $section->addText("Usuario: " . $usuario);
    // $section->addText("Cuenta: " . $cuenta);
    // $section->addText("Nivel: " . $nivel);
    // $section->addText("Idioma: " . $idioma);
    // $section->addText("Autorizado: " . $autorizado);
    // $section->addTextBreak(2);
    // $section->addText("Reporte generado en: " . date("d-m-Y H:i:s"));

    // $writer = IOFactory::createWriter($word, 'Word2007');
    // $writer->save($ruta_word);

    // // Generar archivo Excel
    // $excel = new Spreadsheet();
    // $sheet = $excel->getActiveSheet();
    // $sheet->setTitle("Reporte");

    // $sheet->setCellValue('A1', 'ID');
    // $sheet->setCellValue('B1', 'Usuario');
    // $sheet->setCellValue('C1', 'Cuenta');
    // $sheet->setCellValue('D1', 'Nivel');
    // $sheet->setCellValue('E1', 'Idioma');
    // $sheet->setCellValue('F1', 'Autorizado');

    // $sheet->setCellValue('A2', $id_usuario);
    // $sheet->setCellValue('B2', $usuario);
    // $sheet->setCellValue('C2', $cuenta);
    // $sheet->setCellValue('D2', $nivel);
    // $sheet->setCellValue('E2', $idioma);
    // $sheet->setCellValue('F2', $autorizado);

    // $excelWriter = new Xlsx($excel);
    // $excelWriter->save($ruta_excel);

    // // Generar archivo PDF
    // $pdfWriter = new Mpdf($excel);
    // $pdfWriter->save($ruta_pdf);
}
?>

<br />

<div class="card">
    <div class="card-header">
        <a name="" id="" class="btn btn-primary" href="<?php echo $ruta_word; ?>" role="button" download>Word Reporte</a>
        
        <a name="" id="" class="btn btn-success" href="<?php echo $ruta_excel; ?>" role="button" download>Excel Reporte</a>
        
        <a name="" id="" class="btn btn-secondary" href="<?php echo $ruta_pdf; ?>" role="button" download>PDF Reporte</a>

        <a name="" id="" class="btn btn-danger" href="index.php" role="button">Cancelar</a>
    </div>
    <div class="card-body">
        <div class="table-responsive-sm">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Foto</th>
                        <th scope="col">Usuario</th>
                        <th scope="col">Cuenta</th>
                        <th scope="col">Nivel</th>
                        <th scope="col">Idioma</th>
                        <th scope="col">Autorizado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $registro) { ?>
                    <tr>
                        <td><?php echo $registro['id_usuario']; ?></td>
                        <td>
                            <img src="<?php echo file_exists("../../temp/users/img/" . $registro['id_usuario'] . ".png") 
                                ? "../../temp/users/img/" . $registro['id_usuario'] . ".png"
                                : "../../temp/users/img/default.webp"; ?>"
                                class="img-fluid rounded-top" alt="imagen usuario" style="width: 100px; height: 100px;">
                        </td>
                        <td><?php echo $registro['usuario']; ?></td>
                        <td><?php echo $registro['cuenta']; ?></td>
                        <td><?php echo ($registro['nivel'] == 1) ? "Administrador" : "Operador"; ?></td>
                        <td><?php echo ($registro['idioma'] == 1) ? "Español" : "Inglés"; ?></td>
                        <td><?php echo $registro['autorizado']; ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include("../../footer.php"); ?>
