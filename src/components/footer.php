</main>

<footer class="navbar navbar-dark bg-dark-subtle align-items-center justify-content-center text-aling-center">
    <!-- place footer here -->

    <div class="row justify-content-center">
        <div class="container text-center col-md-12 ">
            <p class="text-white">&copy; 2025 Almacen</p>
        </div>
    </div>
</footer>
<!-- Bootstrap JavaScript Libraries -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
    integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
</script>
<script>
$(document).ready(function() {
    $("#tabla_id").DataTable({
        "pageLength": 3,
        lengthMenu: [
            [3, 10, 25, 50],
            [3, 10, 25, 50],
        ],
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json"
        }
    });
});
</script>
<script>
function borrar(id) {
    Swal.fire({
        title: '¿Desea borrar el registro?',
        showCancelButton: true,
        confirmButtonText: "Si, Borrar",
    }).then((result) => {
        if (result.isConfirmed) {
            window.location = "index.php?txtID=" + id;
        }
    })
}
</script>
</body>

</html>