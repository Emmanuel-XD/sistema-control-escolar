$(document).ready(function () {
    var originalRows = $('table tbody').html();
    var cargoSubtotales = {};

    function obtenerSubtotales() {
        $.ajax({
            type: 'GET',
            url: '../includes/subtotales.php',
            dataType: 'json',
            success: function (data) {
                cargoSubtotales = data;
                updateTable([]);
            },
            error: function () {
                console.log('Error al obtener los subtotales desde la base de datos.');
            }
        });
    }

    obtenerSubtotales();


    function updateTable(data, item) {
        $('table tbody').empty();
        var selectedCargo = $('#id_cargo option:selected').text();

        $.each(data, function (index, item) {
            $('table tbody').append(`
                <tr>
                    <td data-beca="${item.beca}" data-id_alumno="${item.id_alumno}" data-id_grado="${item.id_grado}">${item.matricula}</td>
                    <td>${item.nombre}</td>
                    <td>${item.apellido}</td>
                    <td>${item.descripcion}</td>
                    <td >${item.beca}%</td>
                </tr>
            `);
        });

        // Cálculo del subtotal
        var selectedCargoValue = cargoSubtotales[selectedCargo];
        var monto = parseFloat(selectedCargoValue) || 0;

        $('#monto').html('<b>SubTotal:</b> $' + monto.toFixed(2));

        // Cálculo del descuentoñ{}
        var beca = parseFloat($('#searchResults tbody tr:first td:eq(4)').text());
        var descuento = 0;

        if (!isNaN(beca) && beca > 0) {
            descuento = monto * (beca / 100); //modificabke mas adelante
        }

        // Calculamos el total
        var total = monto - descuento;
        $('#total').html('<b>Total:</b> $' + total.toFixed(2));

    }


    $('#id_cargo').change(function () {
        var selectedCargo = $('#id_cargo option:selected').text();
        var monto = cargoSubtotales[selectedCargo];

        if (monto !== undefined) {

            $('#monto').html('<b>SubTotal:</b> $' + monto);

        } else {
            console.log('Tipo de cargo no encontrado en el mapeo.');
        }
    });


    $('#searchInput').autocomplete({
        source: function (request, response) {
            console.log(request)
            $.ajax({
                type: 'GET',
                url: '../includes/search.php',
                data: {
                    term: request.term
                },
                dataType: 'json',
                success: function (data) {

                    response($.map(data, function (item) {
                        return {
                            label: item.matricula + ' - ' + item.nombre + ' ' + item.apellido,
                            value: item.nombre
                        };
                    }));
                }
            });
        },
        minLength: 2,
        select: function (event, ui) {
            $('#searchInput').val(ui.item.value);
            $.ajax({
                type: 'GET',
                url: '../includes/search.php',
                data: {
                    term: ui.item.value
                },
                dataType: 'json',
                success: function (data) {
                    updateTable(data, ui.item);
                }
            });
            return false;
        },
        close: function (event, ui) {
            var searchTerm = $('#searchInput').val().trim();
            if (searchTerm === '') {
                $('table tbody').html(originalRows);
            }
        }
    });

    $('#searchInput').on('input', function () {
        var searchTerm = $(this).val().trim();
        if (searchTerm === '') {
            $('table tbody').html(originalRows);
        }
    });

    $("#pagoImp").click(function (e) {
        e.preventDefault();

        var id_cargo = $("#id_cargo").val();

        if (id_cargo === '0') {
            Swal.fire({
                icon: 'warning',
                title: 'Cargo no seleccionado',
                text: 'Debes seleccionar un tipo de cargo para realizar el pago.'
            });
        } else {
            console.log("si funcionoxd");

            var id_grado = $("#searchResults>tbody>tr:first>td").data("id_grado");
            var id_alumno = $("#searchResults>tbody>tr:first>td").data("id_alumno");
            var beca = $("#searchResults>tbody>tr:first>td").data("beca");
            var montoText = $("#monto").text();
            var totalText = $("#total").text();
            var descuento = parseFloat(montoText.replace(/[^\d.-]/g, ''));
            var pago = parseFloat(totalText.replace(/[^\d.-]/g, ''));

            console.log("monto:", descuento);
            console.log("total:", pago);
            console.log("id_cargo:", id_cargo);
            console.log("beca:", beca);
            console.log("id_grado:", id_grado);
            console.log("id_alumno:", id_alumno);

            if (!isNaN(pago)) {
                var data = new FormData();

                if (id_grado != undefined || id_alumno != undefined) {
                    data.append('accion', 'savePago');
                    data.append('id_grado', id_grado);
                    data.append('id_alumno', id_alumno);
                    data.append('id_cargo', id_cargo);
                    data.append('beca', beca);
                    data.append('descuento', descuento);
                    data.append('pago', pago);

                    fetch('../includes/functions.php', {
                            method: 'POST',
                            body: data
                        }).then(response => response.json())
                        .then(function (response) {
                            if (response.status == 'success') {
                                let params = `scrollbars=no,resizable=no,status=no,location=no,toolbar=no,menubar=no,width=800,height=600,left=-1000,top=-1000`;
                                open(`../includes/recibo.php?id=${response.reportId}`, 'ticket', params);
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Pago Realizado',
                                    text: 'El pago escolar fue guardado',
                                })
                                $('#searchInput').val("");
                                $('table tbody').html(originalRows);
                            }
                            if (response.status == 'error') {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'No se pudo acceder a la base de datos',
                                    text: 'Contacte al administrador',
                                })
                            }
                        })
                } else {
                    Swal.fire({
                        icon: 'info',
                        title: 'Datos incorrectos',
                        text: 'Revisa los datos de servicio',
                    })
                }
            }
        }
    });

});