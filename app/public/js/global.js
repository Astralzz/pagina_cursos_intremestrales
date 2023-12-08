// Accion del boton
$("#descargarPdf").on("click", function () {
    // Obtenemos url
    var rutaPdf = $(this).data("route");

    // Cambiamos el estilo del botón mientras se genera el PDF
    $(this).html(
        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Generando PDF...'
    );
    $(this).attr("disabled", "disabled");

    console.log(rutaPdf);

    // Realizamos petición
    $.get(rutaPdf, function (response) {
        // Puedes agregar más lógica aquí si es necesario
        console.log("PDF generado y descargado");
        console.log("====================================");
        console.log(response);
        console.log("====================================");

        // Restaurar el estilo del botón
        $("#descargarPdf").html("Descargar PDF");
        $("#descargarPdf").removeAttr("disabled");
    })
        // ! Error
        .fail(function (error) {
            // Manejar errores
            console.error("Error en la solicitud AJAX:", error);

            // Puedes agregar lógica adicional para notificar al usuario sobre el error
            alert(
                "Ocurrió un error al generar el PDF. Por favor, inténtelo nuevamente."
            );
        })
        // Finally
        .always(function () {});
});

// Limpiamos datos
$("#moodal_inf_curso").on("hidden.bs.modal", function () {});

// Agrega un evento cuando el modal se cierra
$("#modal_registro_curso").on("hidden.bs.modal", function () {

    // ? Existe
    if (Livewire?.dispatch) {
        // Llama al método para limpiar los datos
        Livewire.dispatch("limpiarDatos");
        return;
    }

    console.error("No se encontró el obj livewire.dispatch")
});
