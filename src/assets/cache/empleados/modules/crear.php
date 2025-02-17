<?php
include("../../../../../bd.php");

// Procesar el formulario cuando se envía
if ($_POST) {
    // Mostrar los datos del formulario y archivos para propósitos de depuración
    print_r($_POST);
    print_r($_FILES);

    // Obtener los valores del formulario
    $empleado = isset($_POST["nombre"]) ? $_POST["nombre"] : "";
    $domicilio = isset($_POST["domicilio"]) ? $_POST["domicilio"] : "";
    $celular = isset($_POST["celular"]) ? $_POST["celular"] : "";
    $id_puesto = isset($_POST["id_puesto"]) ? $_POST["id_puestos"] : "";
    $activo = isset($_POST["activo"]) ? $_POST["activo"] : "";
    // $foto = isset($_FILES["foto"]['name']) ? $_FILES["foto"]['name'] : "";
    // $cv = isset($_FILES["cv"]['name']) ? $_FILES["cv"]['name'] : "";


    // Preparar la consulta SQL para insertar un nuevo empleado
    $sentencia = $conexion->prepare("INSERT INTO 
        `empleados` 
        (`id_empleado`, `empleado`, `domicilio`, `celular`, `id_puesto`, `activo`) 
        VALUES (NULL, :empleado, :domicilio, :celular, :activo, :foto, :cv, :idpuesto, :fechadeingreso)");

    // Vincular los parámetros
    $sentencia->bindParam(":empleado", $empleado);
    $sentencia->bindParam(":domicilio", $domicilio);
    $sentencia->bindParam(":celular", $celular);
    $sentencia->bindParam(":activo", $activo);

    // Obtener la fecha actual para generar nombres únicos de archivos
    $fecha_ = new DateTime();

    // Procesar la imagen (foto)
    $nombreArchivo_foto = ($foto != '') ? $fecha_->getTimestamp() . "_" . $_FILES["foto"]['name'] : "";
    $tmp_foto = $_FILES['foto']['tmp_name'];

    if ($tmp_foto != '') {
        move_uploaded_file($tmp_foto, "./" . $nombreArchivo_foto);
    }

    $sentencia->bindParam(":foto", $nombreArchivo_foto);

    // Procesar el archivo PDF (CV)
    $nombreArchivo_cv = ($cv != '') ? $fecha_->getTimestamp() . "_" . $_FILES["cv"]['name'] : "";
    $tmp_cv = $_FILES['cv']['tmp_name'];

    if ($tmp_cv != '') {
        move_uploaded_file($tmp_cv, "./" . $nombreArchivo_cv);
    }

    $sentencia->bindParam(":cv", $nombreArchivo_cv);

    // Vincular el resto de los parámetros
    $sentencia->bindParam(":idpuesto", $idpuesto);
    $sentencia->bindParam(":fechadeingreso", $fechadeingreso);

    // Ejecutar la consulta
    $sentencia->execute();

    // Redireccionar a la página principal después de insertar
    $mensaje = "Registro agregado correctamente.";
    header("Location: index.php?mensaje=".$mensaje);
}

// Obtener la lista de puestos para el formulario de selección
$sentencia = $conexion->prepare("SELECT * FROM puestos");
$sentencia->execute();
$puestos = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include("../../../header.php"); ?>

<br>
<div class="card">
    <div class="card-header">Datos del empleado</div>
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">

            <!-- Campos del formulario -->
            <div class="mb-3">
                <label for="empleado" class="form-label">Nombre</label>
                <input type="text" class="form-control" name="empleado" id="empleado" aria-describedby="helpId"
                    placeholder="Nombre">
            </div>

            <div class="mb-3">
                <label for="domicilio" class="form-label">Domicilio</label>
                <input type="text" class="form-control" name="domicilio" id="domicilio" aria-describedby="helpId"
                    placeholder="Domicilio">
            </div>

            <div class="mb-3">
                <label for="celular" class="form-label">Celular</label>
                <input type="text" class="form-control" name="celular" id="celular" aria-describedby="helpId"
                    placeholder="Celular">
            </div>

            <div class="mb-3">
                <label for="idpuesto" class="form-label">Puesto:</label>
                <select class="form-select form-select-sm" name="idpuesto" id="idpuesto">
                    <?php foreach ($puestos as $registro) { ?>
                    <option value="<?php echo $registro['id_puesto'] ?>"><?php echo $registro['puesto'] ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="activo" class="form-label">Activo</label>
                <input type="checkbox" name="activo" id="activo" aria-describedby="helpId" value="">
            </div>
            <!-- 
            <div class="mb-3">
                <label for="foto" class="form-label">Foto:</label>
                <input type="file" class="form-control" name="foto" id="foto" aria-describedby="helpId"
                    placeholder="Foto">
            </div>

            <div class="mb-3">
                <label for="cv" class="form-label">CV(PDF):</label>
                <input type="file" class="form-control" name="cv" id="cv" placeholder="cv"
                    aria-describedby="fileHelpId">
            </div>



            <div class="mb-3">
                <label for="fechadeingreso" class="form-label">Fecha de Ingreso</label>
                <input type="date" class="form-control" name="fechadeingreso" id="fechadeingreso"
                    aria-describedby="emailHelpId" placeholder="abc@mail.com">
            </div>
 -->
            <!-- Botones del formulario -->
            <button type="submit" class="btn btn-success">Agregar registro</button>
            <a name="" id="" class="btn btn-danger" href="../index.php" role="button">Cancelar</a>

        </form>
    </div>
    <div class="card-footer text-muted"></div>
</div>
<br>

<?php include("../../../footer.php"); ?>