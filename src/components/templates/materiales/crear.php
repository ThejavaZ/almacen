<?php
include("../../../../bd.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $material = $_POST['material'];
    $existencia = $_POST['existencia'];
    $precio = $_POST['precio'];
    $disponible = $_POST['disponible'];

    // Paso 1: Insertar usuario SIN imagen
    $sentencia = $conexion->prepare("INSERT INTO materiales (material, existencia, precio, disponible) 
                                    VALUES (:material, :existencia, :precio, :disponible)");
    $sentencia->bindParam(":material", $material);
    $sentencia->bindParam(":existencia", $existencia);
    $sentencia->bindParam(":precio", $precio);
    $sentencia->bindParam(":disponible", $disponible);
    $sentencia->execute();

    // Paso 2: Obtener el ID del usuario recién creado
    $id_usuario = $conexion->lastInsertId();

    // Paso 3: Subir la imagen con el ID del usuario
    if (!empty($_FILES['foto']['name'])) {
        $directorio = "../../temp/materials/";
        $archivo_tmp = $_FILES['foto']['tmp_name'];
        $nombre_archivo = $id_usuario . ".png";
        $ruta_destino = $directorio . $nombre_archivo;

        if (move_uploaded_file($archivo_tmp, $ruta_destino)) {
            echo "Imagen subida correctamente.";
        } else {
            echo "Error al subir la imagen.";
        }
    }

    header("Location: index.php?mensaje=Material creado correctamente");
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
        <label for="material" class="form-label">Nombre del material:</label>
        <input type="text" class="form-control" name="material" id="material" required />
    </div>
    
    <div class="mb-3">
        <label for="existencia" class="form-label">Existencia:</label>
        <input type="integer" class="form-control" name="existencia" id="existencia" required />
    </div>
    
    <div class="mb-3">
        <label for="precio" class="form-label">Insertar el precio</label>
        <input type="decimal" class="form-control" name="precio" id="precio" required />
    </div>
    
    <div class="mb-3">
        <label for="disponible">Disponible</label>
        <select class="form-control" name="disponible" id="disponible" required>
            <option value="S">Si</option>
            <option value="N">No</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="foto" class="form-label">Foto</label>
        <input type="file" class="form-control" name="foto" id="foto" />
    </div>
    
    <button type="submit" class="btn btn-success">Agregar</button>
    <a class="btn btn-primary" href="index.php">Cancelar</a>
    </form>    
    </div>
    <div class="card-footer text-muted"></div>
</div>

<br>

<?php include("../../footer.php"); ?>
