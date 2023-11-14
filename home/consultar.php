<?php include "../includes/header.php";
include_once "../includes/db.php";

error_reporting(0);
session_start();

$sql = "SELECT  u.id, u.usuario, u.correo, u.password,
u.fecha, u.imagen, p.rol FROM users u
LEFT JOIN permisos p ON u.id_rol= p.id   WHERE usuario ='$actualsesion'";
$usuarios = mysqli_query($conexion, $sql);
if ($usuarios->num_rows > 0) {
    foreach ($usuarios as $key => $fila) {
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Informacion</title>
    <script src="../js/cont/jquery.min.js"></script>

</head>

<body>
    <div class="container">
        <h1 class="text-center">Consulta tu Informacion <?php echo $usuario; ?></h1>

        <br>
        <p style="text-align: justify;">Acontinuacion puedes consultar el estado de tu contrato de servicio, editar tu perfil
            de usuario entre otras funciones. Asi como tambien podras ver algunos cambios realizados dentro del sistema en caso de
            algun cambio. </p>

        <a href="customer_history.php?id=<?php echo $fila['id'] ?>" class="btn btn-primary">Mi Historial <i class="fa fa-credit-card" aria-hidden="true"></i></a>
        <a href="report_service.php?id=<?php echo $fila['id'] ?>" class="btn btn-primary">Reportar Servicio <i class="fa fa-credit-card" aria-hidden="true"></i></a>
        <br>
        <br>
        <div data-id="<?php echo $_SESSION['usuario']; ?>" id="datos"></div>

    </div>
</body>

<script>
    var buscar = $("#datos").data("id");
    $(document).onload(buscar_ahora(buscar))

    function buscar_ahora(buscar) {
        var parametros = {
            "buscar": buscar
        };
        $.ajax({
            data: parametros,
            type: 'POST',
            url: 'buscador.php',
            success: function(data) {
                document.getElementById("datos").innerHTML = data;
            }
        });
    }
</script>

<?php include "../includes/footer.php"; ?>

</html>