<?php
include ("../../../../bd.php");

if(isset($_GET['txtID'])){
    $txtID = $_GET['txtID'];
    $sentencia = $conexion->prepare("SELECT * FROM consultas WHERE id_consulta=:id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    $registro = $sentencia->fetch(PDO::FETCH_LAZY);
    
    if ($registro) {
        $id_empleado = $registro["id_empleado"];
        $id_material = $registro["id_material"];
        $id_usuario = $registro["id_usuario"];
        $fecha = $registro["fecha"];
        $cancelada = $registro["cancelada"];
    } else {
        $mensaje = "Usuario no encontrado.";
        header("Location: index.php?mensaje=".$mensaje);
        exit();
    }
}

if ($_POST) {
    // Recolectamos los datos del método POST
    $txtID = $_POST["txtID"];
    $id_empleado = $_POST["id_empleado"];
    $id_material = $_POST["id_material"];
    $id_usuario = $_POST["id_usuario"];
    $fecha = $_POST["fecha"];
    $cancelada = $_POST["cancelada"];

    // Preparar la actualización de los datos 
    $sentencia = $conexion->prepare("UPDATE consultas SET
        id_empleado=:id_empleado,
        id_material=:id_material,
        id_usuario=:id_usuario,
        fecha=:fecha,
        cancelada=:cancelada
        WHERE id_consulta=:id
    ");
    
    // Asignar valores a las variables
    $sentencia->bindParam(":id_empleado", $id_empleado);
    $sentencia->bindParam(":id_material", $id_material);
    $sentencia->bindParam(":id_usuario", $id_usuario);
    $sentencia->bindParam(":fecha", $fecha);
    $sentencia->bindParam(":cancelada", $cancelada);
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
        Datos de la consulta
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
        <label for="id_empleado" class="form-label">empleado:</label>
        <select class="form-control" name="id_empleado" id="id_empleado" required>
        <?php
            $sentencia = $conexion->prepare("SELECT * FROM `empleados`");
            $sentencia->execute();
            $empleados = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            foreach ($empleados as $registro) {
                echo "<option value='" . $registro['id_empleado'] . "'>" . $registro['id_empleado'] ." - " . $registro['empleado'] . "</option>";
            }
        ?>
        </select>
    </div>


    <div class="mb-3">
        <label for="id_material" class="form-label">material:</label>
        <select class="form-control" name="id_material" id="id_material" required>
        <?php
            $sentencia = $conexion->prepare("SELECT * FROM `materiales`");
            $sentencia->execute();
            $materiales = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            foreach ($materiales as $registro) {
                echo "<option value='" . $registro['id_material'] . "'>" . $registro['id_material'] ." - " . $registro['material'] . "</option>";
            }
        ?>
        </select>
    </div>

    
    <div class="mb-3">
        <label for="id_usuario" class="form-label">usuario:</label>
        <select class="form-control" name="id_usuario" id="id_usuario" required>
        <?php
            $sentencia = $conexion->prepare("SELECT * FROM `usuarios`");
            $sentencia->execute();
            $usuarios = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            foreach ($usuarios as $registro) {
                echo "<option value='" . $registro['id_usuario'] . "'>" . $registro['id_usuario'] ." - " . $registro['usuario'] . "</option>";
            }
        ?>
        </select>
    </div>

    <div class="mb-3">
        <label for="fecha" class="form-label">Fecha</label>
        <input type="date"
            value="<?php echo htmlspecialchars($fecha); ?>"
            class="form-control" name="fecha" id="fecha" required />
    </div>

    <div class="mb-3">
        <label for="cancelada" class="form-label">cancelada</label>
        <select class="form-control" name="cancelada" id="cancelada" required>
            <option value="S" <?php echo ($cancelada == 1) ? 'selected' : ''; ?>>Si</option>
            <option value="N" <?php echo ($cancelada == 2) ? 'selected' : ''; ?>>No</option>
        </select>
    </div>

    
    <button type="submit" class="btn btn-success">Actualizar</button>
    <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>

    </form>    

<?php include("../../footer.php"); ?>
