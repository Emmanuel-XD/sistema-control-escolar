<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "../includes/db.php";
if (isset($_POST['buscar'])) {
    $usuario = $_POST["buscar"];
    $buscador = mysqli_query($conexion, "SELECT a.id, a.matricula, a.nombre, a.apellido, a.correo,
    a.telefono, a.curp, a.edad, a.birthdate, a.beca, a.id_grado, a.id_grupo, a.fecha, g.descripcion, gru.grupo
    FROM alumnos a INNER JOIN grados g ON a.id_grado = g.id INNER JOIN grupos gru ON a.id_grupo = gru.id 
    INNER JOIN users u ON a.id_user = u.id WHERE u.usuario =  '$usuario'");
    $numero = mysqli_num_rows($buscador);
}
?>

<h5 class="card-tittle">Resultados encontrados (<?php echo $numero; ?>)</h5>
<div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                <tr>

                    <th>Matricula</th>
                    <th>Nombre</th>

                    <th>Correo</th>
                    <th>Telefono</th>
                    <th>CURP</th>
                    <th>Edad</th>
                    <th>Fecha Nacimiento</th>
                    <th>Beca %</th>
                    <th>Grado & Grupo</th>
                    <th>Fecha_Registro</th>
                </tr>
            </thead>
            <?php while ($fila = mysqli_fetch_assoc($buscador)) { ?>


                <tr>
                    <td><?php echo $fila['matricula']; ?></td>
                    <td><?php echo $fila['nombre'] . ' ' . $fila['apellido']; ?></td>

                    <td><?php echo $fila['correo']; ?></td>
                    <td><?php echo $fila['telefono']; ?></td>
                    <td><?php echo $fila['curp']; ?></td>
                    <td><?php echo $fila['edad']; ?></td>
                    <td><?php echo $fila['birthdate']; ?></td>
                    <td><?php echo $fila['beca'] . '%'; ?></td>
                    <td><?php echo $fila['descripcion'] . '' . $fila['grupo']; ?></td>
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