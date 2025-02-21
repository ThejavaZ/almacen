<?php
include ("../../../../bd.php");

if(isset($_GET['txtID'])){
    $txtID = $_GET['txtID'];
    $sentencia = $conexion->prepare("SELECT * FROM usuarios WHERE id_usuario=:id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    $registro = $sentencia->fetch(PDO::FETCH_LAZY);
    
    if ($registro) {
        $usuario = $registro["usuario"];
        $correo = $registro["correo"];
        $cuenta = $registro["cuenta"];
        $nivel = $registro["nivel"];
        $idioma = $registro["idioma"];
        $autorizado = $registro["autorizado"];
        $foto_actual = "../../temp/users/img/" . $txtID . ".png"; // Ruta de la foto actual
    } else {
        $mensaje = "Usuario no encontrado.";
        header("Location: index.php?mensaje=".$mensaje);
        exit();
    }
}

if ($_POST) {
    // Recolectamos los datos del método POST
    $txtID = $_POST["txtID"];
    $usuario = $_POST["usuario"];
    $cuenta = $_POST["cuenta"];
    $nivel = $_POST["nivel"];
    $idioma = $_POST["idioma"];
    $autorizado = $_POST["autorizado"];

    // Verificar si se ha subido una nueva foto
    if (!empty($_FILES['foto']['name'])) {
        $directorio = "../../temp/users/img/";
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
    $sentencia = $conexion->prepare("UPDATE usuarios SET
        usuario=:usuario,
        cuenta=:cuenta,
        nivel=:nivel,
        idioma=:idioma,
        autorizado=:autorizado
        WHERE id_usuario=:id
    ");
    
    // Asignar valores a las variables
    $sentencia->bindParam(":usuario", $usuario);
    $sentencia->bindParam(":cuenta", $cuenta);
    $sentencia->bindParam(":nivel", $nivel);
    $sentencia->bindParam(":idioma", $idioma);
    $sentencia->bindParam(":autorizado", $autorizado);
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
        Datos del usuario
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
        <label for="usuario" class="form-label">Nombre del usuario:</label>
        <input type="text"
            value="<?php echo htmlspecialchars($usuario); ?>"
            class="form-control" name="usuario" id="usuario" required />
    </div>

    <div class="mb-3">
        <label for="cuenta" class="form-label">Cuenta</label>
        <input type="text"
            value="<?php echo htmlspecialchars($cuenta); ?>"
            class="form-control" name="cuenta" id="cuenta" required />
    </div>

    <div class="mb-3">
        <label for="nivel" class="form-label">Nivel</label>
        <select class="form-control" name="nivel" id="nivel" required>
            <option value="1" <?php echo ($nivel == 1) ? 'selected' : ''; ?>>Administrador</option>
            <option value="2" <?php echo ($nivel == 2) ? 'selected' : ''; ?>>Operador</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="idioma" class="form-label">Idioma</label>
        <select class="form-control" name="idioma" id="idioma" required>
            <option value="1" <?php echo ($idioma == 1) ? 'selected' : ''; ?>>Español</option>
            <option value="2" <?php echo ($idioma == 2) ? 'selected' : ''; ?>>Inglés</option>
        </select>
    </div>

    <div class="mb-3"> 
        <label for="foto" class="form-label">Foto</label>
        <br>
        <img src="
        <?php 
            echo file_exists($foto_actual) 
            ? $foto_actual 
            : "../../temp/users/img/default.webp";
        ?>" 
             class="img-fluid rounded-top" alt="imagen usuario" 
             style="width: 100px; height: 100px;">
        <div class="mb-3">
            <input type="file" class="form-control" name="foto" id="foto" />
        </div>
    </div>

    <div class="mb-3">
        <label for="autorizado" class="form-label">Autorizado</label>
        <select class="form-control" name="autorizado" id="autorizado" required>
            <option value="S" <?php echo ($autorizado == 1) ? 'selected' : 'S'; ?>>Sí</option>
            <option value="N" <?php echo ($autorizado == 0) ? 'selected' : 'N'; ?>>No</option>
        </select>
    </div>
    
    <button type="submit" class="btn btn-success">Actualizar</button>
    <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>

    </form>    

<?php include("../../footer.php"); ?>
