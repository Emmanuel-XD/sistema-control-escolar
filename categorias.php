<?php include "../includes/header.php"; ?>


<body id="page-top">

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Lista de Categorias</h6>
                <br>

                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#cat">
                    <span class="glyphicon glyphicon-plus"></span> Agregar <i class="fa fa-plus"></i> </a></button>
            </div>
            <?php include "form_cat.php"; ?>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Categoria</th>
                                <th>Fecha_registro</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            require_once("../includes/db.php");
                            $result = mysqli_query($conexion, "SELECT * FROM categorias ");
                            while ($fila = mysqli_fetch_assoc($result)) :

                            ?>
                                <tr>
                                    <td><?php echo $fila['categoria']; ?></td>
                                    <td><?php echo $fila['registro']; ?></td>

                                    <td>
                                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editar<?php echo $fila['id']; ?>">
                                            <i class="fa fa-edit "></i>
                                        </button>
                                        <a href="../includes/eliminar_cat.php?id=<?php echo $fila['id'] ?>" class="btn btn-danger btn-del">
                                            <i class="fa fa-trash "></i></a>
                                    </td>
                                </tr>
                                <?php include "editar_cat.php"; ?>
                            <?php endwhile; ?>
                        </tbody>
                    </table>


                </div>
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

</html>