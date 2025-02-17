<?php
include("src/components/header.php");
?>

</br>

<div class="p-5 card text-white bg-dark mb-3 rounded-3 d-flex justify-content-center align-items-center flex-column">
    <img src="<?php echo $url_base; ?>public/logo.png" class="img-fluid rounded-top" alt="imagen app"
        style="width: 15rem;" />
    <div class="card-body">
        <h4 class="card-title">
            <div class="flex-start justify-content-between">
                <p>Bienvenid@ al sistema
                    <br>
                    <br>
                    <strong>
                        <?php
    if (isset($_SESSION['usuario'])) {
        echo $_SESSION['usuario'];
    }
    ?>
                    </strong>
                </p>
        </h4>
    </div>
</div>

<?php include("src/components/footer.php"); ?>