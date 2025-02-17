<?php
include("../../../../bd.php");

if(isset( $_GET['txtID'] )){

    $route_photo = "../../temp/materials/img/" . $_GET['txtID'] . ".png";
    if (file_exists($route_photo)) {
        unlink($route_photo);
    }



    $txtID=(isset($_GET['txtID']))?$_GET['txtID']:"";
    $sentencia=$conexion->prepare("DELETE FROM materiales WHERE id_material=:id");
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();
    
    $mensaje = "Registro eliminado correctamente.";
    header("Location: index.php?mensaje=".$mensaje);
}

$sentencia=$conexion->prepare("SELECT * FROM `materiales`");
$sentencia->execute();
$materiales=$sentencia->fetchAll(PDO::FETCH_ASSOC);


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
                        <th scope="col">Foto</th>
                        <th scope="col">Material</th>
                        <th scope="col">Existencia</th>
                        <th scope="col">Precio</th>
                        <th scope="col">Disponible</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($materiales as $registro) { ?>
                    <tr class="">
                        <td scope="row"><?php echo $registro['id_material']; ?></td>
                        <td>
                            <img src="<?php 
                                if (file_exists(("../../temp/materials/img/" . $registro['id_material'] . ".png"))) {
                                    echo ("../../temp/materials/img/" . $registro['id_material'] . ".png");
                                }
                                else
                                {
                                    echo "../../temp/materials/img/no.png";
                                }
                            ?>" class="img-fluid rounded-top" alt="imagen material" style="width: 100px; height: 100px;">
                        </td>
                        <td><?php echo $registro['material']; ?></td>
                        <td><?php echo $registro['existencia']; ?></td>
                        <td><?php echo $registro['precio']; ?></td>
                        <td><?php echo $registro['disponible']; ?></td>
                        <td>
                            <a class="btn btn-info" href="editar.php?txtID=<?php echo $registro['id_material']; ?>"
                                role="button">Editar</a>
                            |
                            <a class="btn btn-danger" href="javascript:borrar(<?php echo $registro['id_material']; ?>);"
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