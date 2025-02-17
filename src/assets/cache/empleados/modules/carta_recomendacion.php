<?php
include("../../bd.php");

if(isset( $_GET['txtID'] )){
    $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";

    $sentencia = $conexion->prepare("SELECT *,(SELECT nombredelpuesto 
    FROM tbl_puestos 
    WHERE tbl_puestos.id = tbl_empleados.idpuesto LIMIT 1) AS puesto FROM tbl_empleados WHERE id=:id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    $registro = $sentencia->fetch(PDO::FETCH_LAZY);

    // print_r($registro);

    $primernombre = $registro["primernombre"];
    $segundonombre = $registro["segundonombre"];
    $primerapellido = $registro["primerapellido"];
    $segundoapellido = $registro["segundoapellido"];

    $nombreCompleto = $primernombre . " " . $segundonombre . " " . $primerapellido. " " . $segundoapellido;

    
    $foto = $registro["foto"];
    $cv = $registro["cv"];
    $idpuesto = $registro["idpuesto"];
    $puesto = $registro["puesto"];
    $fechadeingreso = $registro["fechadeingreso"];

    $fechaInicio = new DateTime($fechadeingreso);
    $fechaFin = new DateTime(date('Y-m-d'));
    $diferencia = date_diff($fechaInicio, $fechaFin);
    $periodoLaborado = $diferencia->format('%Y años y %d días');

}
ob_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carta de recomendacion</title>
</head>

<body>

    <h1>Carta de Recomendacion Laboral</h1>
    <br /></br>
    Hermosillo Sonora, Mexico a <strong> <?php echo date('d M Y'); ?> </strong>
    <br /></br>
    A quien pueda interesar:
    <br /></br>
    Reciba un cordial y respetuoso saludo.
    <br /></br>
    A través de estas lineas deseo hacer de su conocimiento que Sr(a). <strong><?php echo $nombreCompleto;?> </strong>,
    quien laboro en mi organizacion durante <strong> <?php echo  $diferencia->y?> año(s) </strong>
    es un ciudadano intachable. Ha demostrado ser un excelente trabajador,
    comprometido, responsable y fiel.
    <br /></br>
    Durante estos años se ha desempeñado como: <strong> <?php echo $puesto; ?> </strong>
    Es por ello le sugiero considere esta recomendacion, con la confianza de que estara siempre a la altura de sus
    compromisos y responsabilidades.
    <br /></br>
    Sin mas nada a que referirme y, esperando que esta misiva sea tomada en cuenta, dejo mi numero de contacto para
    cualquier informacion de interes.
    <br /></br><br /></br><br /></br><br /></br>
    Atentamente.
    <br />
    Ing.


</body>

</html>
<?php
$HTML=ob_get_clean();

require_once("../../libs/autoload.inc.php");
use Dompdf\Dompdf;
$dompdf= new Dompdf();

$opciones=$dompdf->getOptions();
$opciones->set(array("isRemoteEnabled"=>true));

$dompdf->setOptions($opciones);

$dompdf->loadHTML($HTML);

$dompdf->setPaper('letter');
$dompdf->render();
$dompdf->stream("archivo.pdf", array("Attachment"=>false));


?>