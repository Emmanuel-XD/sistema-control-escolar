<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "../includes/db.php";
if (isset($_POST['buscar'])) {
    $usuario = $_POST["buscar"];
    $buscador = mysqli_query($conexion, "SELECT c.id, c.folio, c.nombres, c.apellidos, c.edad, c.telefono, 
    c.correo, c.domicilio, c.id_servicio, c.status, c.fecha_pago, c.fecha_registrado, s.servicio, s.precio, u.usuario 
    FROM clientes c INNER JOIN servicios s ON c.id_servicio = s.id INNER JOIN users u ON c.id_user = u.id WHERE u.usuario =  '$usuario'");
    $numero = mysqli_num_rows($buscador);
}
?>

<h5 class="card-tittle">Resultados encontrados (<?php echo $numero; ?>)</h5>
<div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>

                    <th>Nombre</th>
                    <th>Edad</th>
                    <th>Telefono</th>
                    <th>Correo</th>
                    <th>Domicilio</th>
                    <th>Servicio</th>
                    <th>Status</th>
                    <th>Fecha Pago</th>
                    <th>Pago</th>
                    <th>Fecha Registro</th>
                </tr>
            </thead>
            <?php while ($fila = mysqli_fetch_assoc($buscador)) { ?>


                <tr>
                    <td><?php echo $fila['nombres'] . ' ' . $fila['apellidos']; ?></td>
                    <td><?php echo $fila['edad']; ?></td>
                    <td><?php echo $fila['telefono']; ?></td>
                    <td><?php echo $fila['correo']; ?></td>
                    <td><?php echo $fila['domicilio']; ?></td>
                    <td><?php echo $fila['servicio']; ?></td>
                    <td><?php echo $fila['status']; ?></td>
                    <td><?php echo $fila['fecha_pago']; ?></td>
                    <td><?php echo '$' . $fila['precio']; ?></td>
                    <td><?php echo $fila['fecha_registrado']; ?></td>



                </tr>
            <?php
            }

            ?>
            </tbody>
        </table>


    </div>
</div>
</div>

</div>
<!-- /.container-fluid -->

</div>