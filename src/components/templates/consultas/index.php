<?php
include("../../../../bd.php");

if(isset( $_GET['txtID'] )){

    $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";
    $sentencia=$conexion->prepare("DELETE FROM consultas WHERE id_consulta=:id");
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();
    
    $mensaje = "Registro eliminado correctamente.";
    header("Location: index.php?mensaje=".$mensaje);
}

$sentencia=$conexion->prepare("SELECT * FROM `consultas`");
$sentencia->execute();
$consultas=$sentencia->fetchAll(PDO::FETCH_ASSOC);


?>
<?php include("../../header.php"); ?>
<br />


<div class="card">
    <div class="card-header">
        <a name="" id="" class="btn btn-primary" href="crear.php" role="button">
            Agregar
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive-sm">
            <table class="table" id="tabla_id">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">id_empleado</th>
                        <th scope="col">id_material</th>
                        <th scope="col">id_usuario</th>
                        <th scope="col">fecha</th>
                        <th scope="col">Cancelada</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($consultas as $registro) { ?>
                    <tr class="">
                        <td scope="row"><?php echo $registro['id_consulta']; ?></td>
                        <td><?php echo $registro['id_empleado']; ?></td>
                        <td><?php echo $registro['id_material']; ?></td>
                        <td><?php echo $registro['id_usuario']; ?></td>
                        <td><?php echo $registro['fecha']; ?></td>
                        <td><?php echo $registro['cancelada']; ?></td>
                        <td>
                            <a class="btn btn-info" href="editar.php?txtID=<?php echo $registro['id_consulta']; ?>"
                                role="button">Editar</a>
                            |
                            <a class="btn btn-danger" href="javascript:borrar(<?php echo $registro['id_consulta']; ?>);"
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