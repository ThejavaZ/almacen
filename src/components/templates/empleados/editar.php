<?php
include ("../../../../bd.php");

if(isset($_GET['txtID'])){
    $txtID = $_GET['txtID'];
    $sentencia = $conexion->prepare("SELECT * FROM empleados WHERE id_empleado=:id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    $registro = $sentencia->fetch(PDO::FETCH_LAZY);
    
    if ($registro) {
        $empleado = $registro["empleado"];
        $domicilio = $registro["domicilio"];
        $celular = $registro["celular"];
        $id_puesto = $registro["id_puesto"];
        $activo = $registro["activo"];
        $foto_actual = "../../temp/employees/img/" . $txtID . ".png"; // Ruta de la foto actual
    } else {
        $mensaje = "Empleado no encontrado.";
        header("Location: index.php?mensaje=".$mensaje);
        exit();
    }
}

if ($_POST) {
    // Recolectamos los datos del método POST
    $txtID = $_POST["txtID"];
    $empleado = $_POST["empleado"];
    $domicilio = $_POST["domicilio"];
    $celular = $_POST["celular"];
    $id_puesto = $_POST["id_puesto"];
    $activo = $_POST["activo"];

    // Verificar si se ha subido una nueva foto
    if (!empty($_FILES['foto']['name'])) {
        $directorio = "../../temp/employees/img/";
        $archivo_tmp = $_FILES['foto']['tmp_name'];
        $nombre_archivo = $txtID . ".png";
        $ruta_destino = $directorio . $nombre_archivo;

        // Eliminar imagen anterior si existe
        if (file_exists($ruta_destino)) {
            unlink($ruta_destino);
        }

        // Mover la nueva imagen
        if (move_uploaded_file($archivo_tmp, $ruta_destino)) {
            echo "Imagen subida correctamente.";
        } else {
            echo "Error al subir la imagen.";
        }
    }

    // Preparar la actualización de los datos 
    $sentencia = $conexion->prepare("UPDATE empleados SET
        empleado=:empleado,
        domicilio=:domicilio,
        celular=:celular,
        id_puesto=:id_puesto,
        activo=:activo
        WHERE id_empleado=:id
    ");
    
    // Asignar valores a las variables
    $sentencia->bindParam(":empleado", $empleado);
    $sentencia->bindParam(":domicilio", $domicilio);
    $sentencia->bindParam(":celular", $celular);
    $sentencia->bindParam(":id_puesto", $id_puesto);
    $sentencia->bindParam(":activo", $activo);
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute(); 
    
    $mensaje = "Registro actualizado.";
    header("Location: index.php?mensaje=".$mensaje);
    exit();
}
?>

<?php include("../../header.php"); ?>
<br/>

<div class="card">
    <div class="card-header">
        Datos del empleado
    </div>
    <div class="card-body">
        
    <form action="" method="post" enctype="multipart/form-data">

    <div class="mb-3">
        <label for="txtID" class="form-label">ID:</label>
        <input type="text" 
            value="<?php echo htmlspecialchars($txtID); ?>"
            class="form-control" readonly name="txtID" id="txtID" />
    </div>

    <div class="mb-3">
        <label for="empleado" class="form-label">Nombre del empleado:</label>
        <input type="text"
            value="<?php echo htmlspecialchars($empleado); ?>"
            class="form-control" name="empleado" id="empleado" required />
    </div>

    <div class="mb-3">
        <label for="domicilio" class="form-label">domicilio</label>
        <input type="text"
            value="<?php echo htmlspecialchars($domicilio); ?>"
            class="form-control" name="domicilio" id="domicilio" required />
    </div>

    <div class="mb-3">
        <label for="celular" class="form-label">celular</label>
        <input type="text"
            value="<?php echo htmlspecialchars($celular); ?>"
            class="form-control" name="celular" id="celular" required />
    </div>

    <div class="mb-3">
        <label for="id_puesto" class="form-label">usuario:</label>
        <select class="form-control" name="id_puesto" id="id_puesto" required>
        <?php
            $sentencia = $conexion->prepare("SELECT * FROM `puestos`");
            $sentencia->execute();
            $usuarios = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            foreach ($usuarios as $registro) {
                echo "<option value='" . $registro['id_puesto'] . "'>" . $registro['id_puesto'] ." - " . $registro['puesto'] . "</option>";
            }
        ?>
        </select>
    </div>

    <div class="mb-3">
        <label for="activo" class="form-label">activo</label>
        <select class="form-control" name="activo" id="activo" required>
            <option value="S" <?php echo ($activo == 1) ? 'selected' : ''; ?>>Sí</option>
            <option value="N" <?php echo ($activo == 0) ? 'selected' : ''; ?>>No</option>
        </select>
    </div>

    <div class="mb-3"> 
        <label for="foto" class="form-label">Foto</label>
        <br>
        <img src="
        <?php 
            echo file_exists($foto_actual) ? $foto_actual : "../../temp/employees/img/default.webp";
        ?>" 
             class="img-fluid rounded-top" alt="imagen usuario" 
             style="width: 100px; height: 100px;">
        <div class="mb-3">
            <input type="file" class="form-control" name="foto" id="foto" />
        </div>
    </div>
    
    <button type="submit" class="btn btn-success">Actualizar</button>
    <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>

    </form>    

<?php include("../../footer.php"); ?>
