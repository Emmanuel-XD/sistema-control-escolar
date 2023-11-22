$(document).ready(function() {
  
    // $('#id_evaluacion').change(function() {
    //     var idEvaluacion = $(this).val();
    //     var idStudent = urlParams.get('id') 
    //     $.ajax({
    //         url: 'obtener_calificacion.php',
    //         type: 'POST',
    //         data: {
    //             idEvaluacion: idEvaluacion,
    //             idAlumno: idStudent
    //         },
    //         dataType: 'html',
    //         success: function(data) {
    //             $('#calificaciones-body').html(data);
    //         },
    //         error: function(xhr, status, error) {
    //             alert('Error: Ocurrió un error inesperado');
    //         }
    //     });
    // });
});
$("#id_periodo, #id_evaluacion").change(function (e) { 
    e.preventDefault();
    var table = $('#dataTable').DataTable();
    var periodEval = $("#id_periodo").val()
    var numEval = $("#id_evaluacion").val()

    if(periodEval === "" && numEval === "" ){
        $(".is-completed").show()
        $(".is-completed").html("Selecciona un periodo y el numero de evaluación.")
        table.clear().draw();
        console.log("1")
    }
    if(periodEval === "" && numEval >= 1 ){
        $(".is-completed").show()
        $(".is-completed").html("Selecciona un periodo.")
        console.log("2")
        table.clear().draw();
    }
    if(periodEval >= 1 && numEval === "" ){
        $(".is-completed").show()
        $(".is-completed").html("Selecciona un numero de evaluación.")
        console.log("3")
        table.clear().draw();
    }
    if(periodEval >= 1 && numEval >= 1 ){
        $(".is-completed").hide()
        $(".is-completed").html("")
        console.log("4")
        gradesAssign(periodEval, numEval);
    }
    function gradesAssign(periodEval, numEval){

        const url = window.location.href;
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        var idStudent = urlParams.get('id') 

        const data = new FormData()
        data.append('perEval', periodEval)
        data.append('numEval', numEval)
        data.append('idStudent', idStudent)
        fetch('obtener_calificacion.php', {
            method: 'POST',
            body: data, // Include the FormData object as the request body
          })
            .then(response => {
              if (response.ok) {
                return response.text();
              } else {
                throw new Error('Network response was not ok');
              }
            })
            .then(data => {
              console.log('Response data: ', data);
            })
            .catch(error => {
              console.error('Error:', error);
            });

    }
       
});
// variables =  if the first input is empty show the alert and delete the table (if data is there) ; 
// if the seccond input is empty show the alert and delete the table (if data is there); 
// if both input are empty show the alert and delete the table (if data is there)
// if(periodEval === "" && periodEval === ""){
//     $(".is-completed").show()
//     $(".is-completed").html("Selecciona un periodo y el numero de evaluación.")
// }
// else{
    
// }
