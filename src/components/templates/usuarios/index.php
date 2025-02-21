<?php
include("../../../../bd.php");

if(isset( $_GET['txtID'] )){

    $route_photo = "../../temp/users/img/" . $_GET['txtID'] . ".png";
    if (file_exists($route_photo)) {
        unlink($route_photo);
    }



    $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";
    $sentencia=$conexion->prepare("DELETE FROM usuarios WHERE id_usuario=:id");
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();
    
    $mensaje = "Registro eliminado correctamente.";
    header("Location: index.php?mensaje=".$mensaje);
}

$sentencia=$conexion->prepare("SELECT * FROM `usuarios`");
$sentencia->execute();
$usuarios=$sentencia->fetchAll(PDO::FETCH_ASSOC);


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
                        <th scope="col">Usuario</th>
                        <th scope="col">Cuenta</th>
                        <th scope="col">Contraseña</th>
                        <th scope="col">Nivel</th>
                        <th scope="col">Idioma</th>
                        <th scope="col">Autorizado</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($usuarios as $registro) { ?>
                    <tr class="">
                        <td scope="row"><?php echo $registro['id_usuario']; ?></td>

                        <td>
                            <img src="<?php 
                                if (file_exists(("../../temp/users/img/" . $registro['id_usuario'] . ".png"))) {
                                    echo ("../../temp/users/img/" . $registro['id_usuario'] . ".png");
                                }
                                else
                                {
                                    echo "../../temp/users/img/default.webp";
                                }
                            ?>" class="img-fluid rounded-top" alt="imagen usuario" style="width: 100px; height: 100px;">
                        </td>
                        <td><?php echo $registro['usuario']; ?></td>
                        <td><?php echo $registro['cuenta']; ?></td>
                        <td> * * * * *</td>
                        <td><?php if($registro['nivel'] == 1) { echo "Administrador"; } else { echo "Operador"; } ?></td>
                        <td><?php if($registro['idioma'] == 1) { echo "Español"; } else { echo "Inglés"; } ?></td>
                        <td><?php echo $registro['autorizado']; ?></td>
                        <td>
                            <a class="btn btn-info" href="editar.php?txtID=<?php echo $registro['id_usuario']; ?>"
                                role="button">Editar</a>
                            |
                            <a class="btn btn-danger" href="javascript:borrar(<?php echo $registro['id_usuario']; ?>);"
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