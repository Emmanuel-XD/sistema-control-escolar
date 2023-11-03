<?php include "../includes/header.php"; ?>
<link rel="stylesheet" href="../css/style.css">



<body id="page-top">

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Lista de Horarios Escolares</h6>
                <br>
                <form id="hourForm" method="POST" action="../includes/functions.php">
                    <select name="id_grado" id="id_grado" class="control" onchange="getMaterias()">

                        <option value="">Seleccione una opcion</option>
                        <?php

                        include("../includes/db.php");

                        $sql = "SELECT * FROM grados ";
                        $resultado = mysqli_query($conexion, $sql);
                        while ($consulta = mysqli_fetch_array($resultado)) {
                            echo '<option value="' . $consulta['id'] . '">' . $consulta['descripcion'] .  '</option>';
                        }

                        ?>
                    </select>
                    <input type="hidden" name="accion" value="insert_hor">

                    <button type="submit" name="save" id="save" class="btn btn-success">Guardar</button>

            </div>

            <div class="card-body">
                <div id="materias-disponibles">
                    <!-- Aquí se mostrarán los botones de las materias relacionadas con el grado -->
                </div>


                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>HORARIO</th>
                                <?php
                                include("../includes/db.php");
                                $consulta = "SELECT * FROM class_days LIMIT 2";
                                $sql = mysqli_query($conexion, $consulta);
                                if ($sql->num_rows > 0) {
                                    foreach ($sql as $key => $filas) {
                                        $id_day = $filas['id'];
                                ?>
                                        <th>
                                            <label>
                                                <input type="checkbox" name="selected_days[]" value="<?php echo $id_day; ?>">
                                                <?php echo $filas['days']; ?>
                                            </label>
                                        </th>
                                <?php
                                    }
                                }
                                ?>
                            </tr>


                        </thead>
                        <tbody>
                            <?php
                            include("../includes/db.php");
                            $result = mysqli_query($conexion, "SELECT * FROM class_hour ");
                            while ($fila = mysqli_fetch_assoc($result)) :
                                $id_hour = $fila['id'];
                                $hora = $fila['hora'];
                            ?>
                                <tr>
                                    <td><?php echo $fila['hora']; ?></td>
                                    <td>
                                        <select name="id_materia[<?php echo $id_hour; ?>]" class="form-control">
                                            <option value="">Selecciona una opción</option>
                                            <?php
                                            include("../includes/db.php");
                                            $sql = "SELECT * FROM materias ";
                                            $resultado = mysqli_query($conexion, $sql);
                                            while ($consulta = mysqli_fetch_array($resultado)) {
                                                $id_materia = $consulta['id'];
                                            ?>
                                                <option value="<?php echo $id_materia; ?>"><?php echo $consulta['materia']; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                        <input type="hidden" name="id_hour[<?php echo $id_hour; ?>]" value="<?php echo $id_hour; ?>">
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                    </form>

                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

    <script>
        function getSelectedDays() {
            const selectedDays = [];
            const checkboxes = document.querySelectorAll('input[name="selected_days[]"]');
            checkboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    selectedDays.push(checkbox.value);
                }
            });
            const idDayInput = document.getElementById('id_day');
            idDayInput.value = selectedDays.join(','); // Guarda los IDs de los días como una lista separada por comas
        }
    </script>







    </div>
    <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->



</body>


<?php include "../includes/footer.php"; ?>


</html>