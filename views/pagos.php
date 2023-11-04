<?php include "../includes/header.php"; ?>
<link rel="stylesheet" href="../css/jquery-ui.css">
<style>
    .control {

        /* width: 100%; */
        height: calc(1.5em + 0.75rem + 2px);
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #6e707e;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #d1d3e2;
        border-radius: 0.35rem;
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    }
</style>

<body id="page-top">

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h4 class="m-0 font-weight-bold text-center text-primary">REALIZAR PAGO DE ESTUDIANTES</h4>
                <br>
                <div class="form-group">
                    <label for=""><b>Tipo de Cargo</b></label>
                    <br>
                    <select name="id_cargo" id="id_cargo" class="control" required>
                        <option value="0">Selecciona una opcion</option>
                        <?php

                        include("../includes/db.php");

                        $sql = "SELECT * FROM cargos ";
                        $resultado = mysqli_query($conexion, $sql);
                        while ($consulta = mysqli_fetch_array($resultado)) {
                            echo '<option value="' . $consulta['id'] . '">' . $consulta['cargo'] . '</option>';
                        }

                        ?>
                    </select>
                </div>

            </div>


            <div class="card-body">
                <label for="" class="form-laberl">Buscador <i class="fa fa-search"></i> </label>

                <input type="text" class="form-control" id="searchInput" placeholder="Ingrese el numero de matricula o nombre del estudiante...">
                <br>

                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0" id="searchResults">
                        <thead>
                            <tr>
                                <th>Matricula</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Grado</th>
                                <th>Beca</th>
                            </tr>
                        </thead>
                        <tbody>


                        </tbody>

                    </table>
                    <br>
                    <p id="monto"><b>SubTotal:</b> </p>
                    <p id="total"><b>Total:</b></p>
                </div>
                <br>
                <button type="submit" class="btn btn-primary" id="pagoImp"> PAGAR IMPORTE $ </button>

            </div>
        </div>

    </div>
    <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->


    </div>
    <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->


</body>


<?php include "../includes/footer.php"; ?>
<script src="../js/pagos.js"></script>
<script src="../js/jquery-ui.js"></script>

</html>