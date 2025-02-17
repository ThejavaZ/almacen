<?php
include("../../../../bd.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $cuenta = $_POST['cuenta'];
    $clave = password_hash($_POST['clave'], PASSWORD_DEFAULT); // Cifrar la contraseña
    $nivel = $_POST['nivel'];
    $idioma = $_POST['idioma'];
    $autorizado = $_POST['autorizado'];

    // Paso 1: Insertar usuario SIN imagen
    $sentencia = $conexion->prepare("INSERT INTO usuarios (usuario, cuenta, clave, nivel, idioma, autorizado) 
                                    VALUES (:usuario, :cuenta, :clave, :nivel, :idioma, :autorizado)");
    $sentencia->bindParam(":usuario", $usuario);
    $sentencia->bindParam(":cuenta", $cuenta);
    $sentencia->bindParam(":clave", $contraseña);
    $sentencia->bindParam(":nivel", $nivel);
    $sentencia->bindParam(":idioma", $idioma);
    $sentencia->bindParam(":autorizado", $autorizado);
    $sentencia->execute();

    // Paso 2: Obtener el ID del usuario recién creado
    $id_usuario = $conexion->lastInsertId();

    // Paso 3: Subir la imagen con el ID del usuario
    if (!empty($_FILES['foto']['name'])) {
        $directorio = "../../temp/users/img/";
        $archivo_tmp = $_FILES['foto']['tmp_name'];
        $nombre_archivo = $id_usuario . ".png";
        $ruta_destino = $directorio . $nombre_archivo;

        if (move_uploaded_file($archivo_tmp, $ruta_destino)) {
            echo "Imagen subida correctamente.";
        } else {
            echo "Error al subir la imagen.";
        }
    }

    header("Location: index.php?mensaje=Usuario creado correctamente");
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
        <label for="usuario" class="form-label">Nombre del usuario:</label>
        <input type="text" class="form-control" name="usuario" id="usuario" required />
    </div>
    
    <div class="mb-3">
        <label for="cuenta" class="form-label">Correo:</label>
        <input type="email" class="form-control" name="cuenta" id="cuenta" required />
    </div>
    
    <div class="mb-3">
        <label for="clave" class="form-label">Insertar la contraseña</label>
        <input type="password" class="form-control" name="clave" id="clave" required />
    </div>
    
    <div class="mb-3">
        <label for="nivel">Nivel</label>
        <select class="form-control" name="nivel" id="nivel" required>
            <option value="1">Administrador</option>
            <option value="2">Operador</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="idioma">Idioma</label>
        <select class="form-control" name="idioma" id="idioma" required>
            <option value="1">Español</option>
            <option value="2">Inglés</option>
        </select>
    </div>
    
    <div class="mb-3">
        <label for="autorizado">Autorizado</label>
        <select class="form-control" name="autorizado" id="autorizado" required>
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
