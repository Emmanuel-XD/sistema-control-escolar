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
        <p style="text-align: justify;">A continuación, los alumnos tienen la posibilidad de consultar el estado de su perfil,
            gestionar calificaciones, y editar su información personal dentro del sistema. Además, podrán revisar cualquier cambio
            realizado en sus calificaciones y ajustes en sus perfiles.</p>

        <a href="student_tickets.php?id=<?php echo $fila['id'] ?>" class="btn btn-primary">Boleta De Califiacion <i class="fa fa-file"></i></a>
        <a href="student_grades.php?id=<?php echo $fila['id'] ?>" class="btn btn-primary">Mis Calificaciones <i class="fa fa-list-alt" aria-hidden="true"></i></a>
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
            url: 'search.php',
            success: function(data) {
                document.getElementById("datos").innerHTML = data;
            }
        });
    }
</script>

<?php include "../includes/footer.php"; ?>

</html>