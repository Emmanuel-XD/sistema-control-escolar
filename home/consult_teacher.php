<?php include "../includes/header.php";
include_once "../includes/db.php";

error_reporting(0);
session_start();

$sql = "SELECT  u.id, u.usuario, u.correo, u.password,
u.fecha, u.imagen, p.rol FROM users u
LEFT JOIN permisos p ON u.id_rol= p.id  WHERE correo ='$usuario'";
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
        <h1 class="text-center">Consulta tu Informacion <?php echo $fila['usuario']; ?></h1>

        <br>
        <p style="text-align: justify;">A continuación, puedes consultar el estado de tu perfil como profesor, gestionar
            calificaciones, editar tu perfil de usuario y acceder a otras funciones relacionadas con tus actividades docentes.
            Además, podrás revisar cualquier cambio realizado dentro del sistema, ajustes en tu perfil. También, te brindamos la opción de solicitar préstamos educativos y gestionar otros aspectos importantes para tu labor como educador. </p>

        <a href="teacher_history.php" class="btn btn-primary">Mi Historial <i class="fa fa-archive"></i></a>
        <a href="teacher_calendar.php" class="btn btn-primary">Prestamos <i class="fa fa-calendar-plus"></i></a>
        <br>
        <br>
        <div data-id="<?php echo $_SESSION['correo']; ?>" id="datos"></div>

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