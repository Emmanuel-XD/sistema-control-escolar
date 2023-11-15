<div class="modal fade" id="per" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h3 class="modal-title" id="exampleModalLabel">Agregar nuevo periodo</h3>
                <button type="button" class="btn btn-primary" data-dismiss="modal">
                    <i class="fa fa-times" aria-hidden="true"></i></button>
            </div>
            <div class="modal-body">

                <form id="perForm">


                    <div class="form-group">
                        <label for="Descripcion" class="form-label">Descripcion</label>
                        <input type="text" id="periodo" name="periodo" class="form-control" required>

                    </div>


                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="date_in">Periodo de Inicio</label><br>
                                <input type="date" name="date_in" id="date_in" class="form-control" required>

                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="date_fin">Periodo de Fin</label><br>
                                <input type="date" name="date_fin" id="date_fin" class="form-control" required>
                            </div>
                        </div>
                    </div>


                    <br>

                    <input type="hidden" name="accion" value="insert_per">

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="register" name="registrar">Guardar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>

            </div>

            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#perForm').submit(function(e) {
            e.preventDefault(); 
            var formData = $(this).serialize(); 
            $.ajax({
                url: '../includes/functions.php',
                type: 'POST',
                data: formData,
                dataType: 'json', 
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Datos Guardados',
                            text: 'Los datos se guardaron correctamente'
                        }).then(function() {
                            window.location = "periodos.php"; 
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Ocurrió un error inesperado'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Ocurrió un error inesperado'
                    });
                }
            });
        });
    });
</script>