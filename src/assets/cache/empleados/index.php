<?php
include("../../../../bd.php");

// Eliminar un empleado si se pasa el parámetro txtID en la URL
if (isset($_GET['txtID'])) {
    $txtID = $_GET['txtID'] ?? '';


    if(isset( $_GET['txtID'] )){
        $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";
        $sentencia=$conexion->prepare("DELETE FROM tbl_empleados WHERE id=:id");
        $sentencia->bindParam(":id",$txtID);
        $sentencia->execute();
        header("Location:index.php");

    }

    // // Buscar los archivos relacionados al empleado
    // $sentencia = $conexion->prepare("SELECT foto, cv FROM tbl_empleados WHERE id = :id");
    // $sentencia->bindParam(":id", $txtID);
    // $sentencia->execute();
    // $registro_recuperado = $sentencia->fetch(PDO::FETCH_LAZY);

    // Eliminar la foto si existe
    if (isset($registro_recuperado["foto"]) && $registro_recuperado["foto"] != '') {
        if (file_exists("./" . $registro_recuperado["foto"])) {
            unlink("./" . $registro_recuperado["foto"]);
        }
    }

    // Eliminar el CV si existe
    if (isset($registro_recuperado["cv"]) && $registro_recuperado["cv"] != '') {
        if (file_exists("./" . $registro_recuperado["cv"])) {
            unlink("./" . $registro_recuperado["cv"]);
        }
    }

    // Eliminar el registro del empleado en la base de datos
    $sentencia = $conexion->prepare("DELETE FROM tbl_empleados WHERE id = :id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();

    // Redirigir a la página principal
    $mensaje = "Registro eliminado correctamente.";
    header("Location: index.php?mensaje=".$mensaje);
}

// Seleccionar todos los empleados y sus puestos
$sentencia = $conexion->prepare("SELECT t1.id_empleado as id, t1.empleado as nombre, t1.domicilio ,t1.celular ,t2.puesto ,t1.activo FROM empleados t1 INNER JOIN puestos t2 where t1.id_puesto = t2.id_puesto");
$sentencia->execute();
$lista_tbl_empleados = $sentencia->fetchAll(PDO::FETCH_ASSOC);

if(isset($_POST['activo'])){
    $id = $_POST['id'];
    $activo = $_POST['activo'];
    $sentencia = $conexion->prepare("UPDATE empleados SET activo = :activo WHERE id_empleado = :id");
    $sentencia->bindParam(':activo', $activo);
    $sentencia->bindParam(':id', $id);
    $sentencia->execute();
}
?>

<?php include("../../header.php"); ?>
<br>
<div class="card">
    <div class="card-header d-flex justify-content-start align-items-start flex-row">
        <a name="" id="" class="btn btn-primary" href="modules/crear.php" role="button">Agregar registro</a>
    </div>
    <div class="card-body table-responsive-sm table-hover ">
        <div class="table-responsive-sm table-hover d-flex justify-content-center align-items-center flex-column">
            <table class="table" id="tabla_id">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Domicilio</th>
                        <th scope="col">Celular</th>
                        <th scope="col">Puesto</th>
                        <!-- <th scope="col">Fecha de ingreso</th> -->
                        <th scope="col">Activo</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lista_tbl_empleados as $registro) { ?>
                    <tr>
                        <td><?php echo $registro['id']; ?></td>
                        <td>
                            <?php echo $registro['nombre']; ?>
                        </td>
                        <td>
                            <?php echo $registro['domicilio']; ?>
                        </td>
                        <td>
                            <?php echo $registro['celular']; ?>
                        </td>
                        <!-- <td>
                            <img width="50" src="<?php echo $registro['foto']; ?>" class="img-fluid rounded" alt="" />
                        </td> -->
                        <!-- <td>
                            <a href="<?php echo $registro['cv']; ?>"><?php echo $registro['cv']; ?></a>
                        </td> -->
                        <td><?php echo $registro['puesto']; ?></td>
                        <td>
                            <input type="checkbox" name="activo"
                                value="<?php echo $registro['activo'] ;if ($registro['activo'] == "S"){echo "checked";}?>">
                            <?php echo $registro['activo']?>
                        </td>
                        <!-- <td><?php echo $registro['fechadeingreso']; ?></td> -->
                        <td>
                            <!-- <a href="carta_recomendacion.php?txtID=<?php echo $registro['id']; ?>"
                                class="btn btn-primary" role="button">Carta</a> -->
                            <a class="btn btn-info" href="modules/editar.php?txtID=<?php echo $registro['id']; ?>"
                                role="button">Editar</a>
                            |
                            <a class="btn btn-danger" href="javascript:borrar(<?php echo $registro['id']; ?>);"
                                role="button">Eliminar</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include("../../footer.php"); ?>