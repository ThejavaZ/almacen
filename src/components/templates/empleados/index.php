<?php
include("../../../../bd.php");

if(isset( $_GET['txtID'] )){

    $route_photo = "../../temp/employees/" . $_GET['txtID'] . ".png";
    if (file_exists($route_photo)) {
        unlink($route_photo);
    }



    $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";
    $sentencia=$conexion->prepare("DELETE FROM empleados WHERE id_empleado=:id");
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();
    
    $mensaje = "Registro eliminado correctamente.";
    header("Location: index.php?mensaje=".$mensaje);
}


$sentencia=$conexion->prepare("SELECT t1.id_empleado, t1.empleado, t1.domicilio, t1.celular, t2.puesto, t1.activo FROM empleados t1 INNER JOIN puestos t2 WHERE t1.id_puesto = t2.id_puesto");

$sentencia->execute();
$empleados=$sentencia->fetchAll(PDO::FETCH_ASSOC);


?>
<?php include("../../header.php"); ?>
<br />


<div class="card">
    <div class="card-header">
        <a name="" id="" class="btn btn-primary" href="crear.php" role="button">
            Agregar
        </a>

        <a name="" id="" class="btn btn-secondary" href="reporte.php" role="button">
            Reporte
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive-sm">
            <table class="table" id="tabla_id">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Foto</th>
                        <th scope="col">Empleado</th>
                        <th scope="col">Domicilio</th>
                        <th scope="col">Teléfono</th>
                        <th scope="col">Puesto</th>
                        <th scope="col">Activo</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($empleados as $registro) { ?>
                    <tr class="">
                        <td scope="row"><?php echo $registro['id_empleado']; ?></td>
                        <td>
                            <img src="<?php 
                                if (file_exists(("../../temp/employees/img/" . $registro['id_empleado'] . ".png"))) {
                                    echo ("../../temp/employees/img/" . $registro['id_empleado'] . ".png");
                                }
                                else
                                {
                                    echo "../../temp/employees/img/default.webp";
                                }
                            ?>" class="img-fluid rounded-top" alt="imagen empleado" style="width: 100px; height: 100px;">
                        </td>
                        <td><?php echo $registro['empleado']; ?></td>
                        <td><?php echo $registro['domicilio']; ?></td>
                        <td><?php echo $registro['celular']; ?></td>
                        <td><?php echo $registro['puesto']; ?></td>
                        <td><?php echo $registro['activo']; ?></td>
                        <td>
                            <a class="btn btn-info" href="editar.php?txtID=<?php echo $registro['id_empleado']; ?>"
                                role="button">Editar</a>
                            |
                            <a class="btn btn-danger" href="javascript:borrar(<?php echo $registro['id_empleado']; ?>);"
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