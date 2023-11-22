<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "../includes/db.php";
if (isset($_POST['buscar'])) {
    $usuario = $_POST["buscar"];
    $buscador = mysqli_query($conexion, "SELECT p.id, p.cedula, p.nombres, p.apellidos, p.correo, p.curp, 
    p.edad, p.fecha_na, p.id_especialidad, p.fecha, e.especialidad FROM profesores p INNER JOIN especialidades e 
    ON p.id_especialidad = e.id  WHERE p.correo =  '$usuario'");
    $numero = mysqli_num_rows($buscador);
}
?>

<h5 class="card-tittle">Resultados encontrados (<?php echo $numero; ?>)</h5>
<div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>

                    <th>Cedula</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>CURP</th>
                    <th>Edad</th>
                    <th>Nacimiento</th>
                    <th>Especialidad</th>
                    <th>Fecha_Registro</th>
                </tr>
            </thead>
            <?php while ($fila = mysqli_fetch_assoc($buscador)) { ?>


                <tr>
                    <td><?php echo $fila['cedula']; ?></td>
                    <td><?php echo $fila['nombres'] . ' ' . $fila['apellidos']; ?></td>

                    <td><?php echo $fila['correo']; ?></td>
                    <td><?php echo $fila['curp']; ?></td>
                    <td><?php echo $fila['edad']; ?></td>
                    <td><?php echo $fila['fecha_na']; ?></td>
                    <td><?php echo $fila['especialidad']; ?></td>
                    <td><?php echo $fila['fecha']; ?></td>



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