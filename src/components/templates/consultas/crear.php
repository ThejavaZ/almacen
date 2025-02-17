<?php
include("../../../../bd.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_empleado = $_POST['id_empleado'];
    $id_material = $_POST['id_material'];
    $id_usuario = $_POST['id_usuario'];
    $fecha = $_POST['fecha'];
    $cancelada = $_POST['cancelada'];

    // Paso 1: Insertar usuario SIN imagen
    $sentencia = $conexion->prepare("INSERT INTO consultas (id_empleado, id_material, id_usuario, fecha, cancelada) 
                                    VALUES (:id_empleado, :id_material, :id_usuario, :fecha, :cancelada)");
    $sentencia->bindParam(":id_empleado", $id_empleado);
    $sentencia->bindParam(":id_material", $id_material);
    $sentencia->bindParam(":id_usuario", $id_usuario);
    $sentencia->bindParam(":fecha", $fecha);
    $sentencia->bindParam(":cancelada", $cancelada);
    $sentencia->execute();

    header("Location: index.php?mensaje=Usuario creado correctamente");
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
        <label for="cuenta" class="form-label">Fecha:</label>
        <input type="date" class="form-control" name="fecha" id="fecha" required />
    </div>

    <div class="mb-3">
        <label for="cancelada" class="form-label">Cancelada</label>
        <select class="form-control" name="cancelada" id="cancelada" required>
            <option value="S">Sí</option>
            <option value="N">No</option>
        </select>
    </div>

    <button type="submit" class="btn btn-success">Agregar</button>
    <a class="btn btn-primary" href="index.php">Cancelar</a>
    </form>    
    </div>
    <div class="card-footer text-muted"></div>
</div>

<br>

<?php include("../../footer.php"); ?>