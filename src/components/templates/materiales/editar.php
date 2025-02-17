<?php
include ("../../../../bd.php");

if(isset($_GET['txtID'])){
    $txtID = $_GET['txtID'];
    $sentencia = $conexion->prepare("SELECT * FROM materiales WHERE id_material=:id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    $registro = $sentencia->fetch(PDO::FETCH_LAZY);
    
    if ($registro) {
        $material = $registro["material"];
        $existencia = $registro["existencia"];
        $precio = $registro["precio"];
        $disponible = $registro["disponible"];
        $foto_actual = "../../temp/materials/" . $txtID . ".png";
    } else {
        $mensaje = "Material no encontrado.";
        header("Location: index.php?mensaje=".$mensaje);
        exit();
    }
}

if ($_POST) {
    // Recolectamos los datos del método POST
    $txtID = $_POST["txtID"];
    $material = $_POST["material"];
    $existencia = $_POST["existencia"];
    $precio = $_POST["precio"];
    $disponible = $_POST["disponible"];

    // Verificar si se ha subido una nueva foto
    if (!empty($_FILES['foto']['name'])) {
        $directorio = "../../temp/materials/";
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
    $sentencia = $conexion->prepare("UPDATE materiales SET
        material=:material,
        existencia=:existencia,
        precio=:precio,
        disponible=:disponible
        WHERE id_material=:id
    ");
    
    // Asignar valores a las variables
    $sentencia->bindParam(":material", $material);
    $sentencia->bindParam(":existencia", $existencia);
    $sentencia->bindParam(":precio", $precio);
    $sentencia->bindParam(":disponible", $disponible);
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
        Datos del material
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
        <label for="material" class="form-label">Nombre del material:</label>
        <input type="text"
            value="<?php echo htmlspecialchars($material); ?>"
            class="form-control" name="material" id="material" required />
    </div>

    <div class="mb-3">
        <label for="existencia" class="form-label">Existencia</label>
        <input type="text"
            value="<?php echo htmlspecialchars($existencia); ?>"
            class="form-control" name="existencia" id="existencia" required />
    </div>

    <div class="mb-3">
        <label for="precio" class="form-label">Precio</label>
        <input type="text"
            value="<?php echo htmlspecialchars($precio); ?>"
            class="form-control" name="precio" id="precio" required />
    </div>

    <div class="mb-3"> 
        <label for="foto" class="form-label">Foto</label>
        <br>
        <img src="
        <?php 
            echo file_exists($foto_actual) ? $foto_actual : "../../temp/materials/no.png";
        ?>" 
             class="img-fluid rounded-top" alt="imagen usuario" 
             style="width: 100px; height: 100px;">
        <div class="mb-3">
            <input type="file" class="form-control" name="foto" id="foto" />
        </div>
        <div>
            <a id="" href="javascript:borrar(<?php echo $txtID; ?>);" class="btn btn-danger">Eliminar foto</a>
        </div>
    </div>

    <div class="mb-3">
        <label for="disponible" class="form-label">Disponible</label>
        <select class="form-control" name="disponible" id="disponible" required>
            <option value="S" <?php echo ($disponible == 1) ? 'selected' : 'S'; ?>>Sí</option>
            <option value="N" <?php echo ($disponible == 0) ? 'selected' : 'N'; ?>>No</option>
        </select>
    </div>
    
    <button type="submit" class="btn btn-success">Actualizar</button>
    <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>

    </form>    

<?php include("../../footer.php"); ?>
