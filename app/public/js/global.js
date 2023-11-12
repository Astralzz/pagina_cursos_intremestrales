// // DATOS DE CARÁCTER GLOBAL
// // -------------- datos globales --------------
// const meses = [
//     "enero",
//     "febrero",
//     "marzo",
//     "abril",
//     "mayo",
//     "junio",
//     "julio",
//     "agosto",
//     "septiembre",
//     "octubre",
//     "noviembre",
//     "diciembre",
// ];

// async function verInformacionDelDato(url) {
//     //Limpiamos datos
//     limpiarDatosModal();

//     //Obtenemos deporte con ajax
//     await $.ajax({
//         type: "GET",
//         url: url,
//         data: {
//             _token: "{{ csrf_token() }}",
//         },
//         //Actualizamos
//         success: function (res) {
//             //Comprobamos
//             if (!res) {
//                 alert("ERROR, no se pudo obtener el dato");
//                 return;
//             } else if (res.error) {
//                 alert(res.error);
//                 return;
//             }

//             //Insertamos datos
//             insertarDatosModal(res);
//         },
//     });
// }

// // -------------- MODAL DE LOS DATOS --------------

// //Valores de el modal para ver el deporte
// const vars = {
//     categoria: document.getElementById("categoria-modal"),
//     nombre: document.getElementById("nombre-modal"),
//     informacion: document.getElementById("informacion-modal"),
//     tipo: document.getElementById("tipo-modal"),
//     nombre_instructor: document.getElementById("nombre_instructor-modal"),
//     sede: document.getElementById("sede-modal"),
//     fecha_inicio: document.getElementById("fecha_inicio-modal"),
//     fecha_final: document.getElementById("fecha_final-modal"),
// };

// // Inserta datos al modal
// function insertarDatosModal(obj) {
//     // * Categoria
//     if (vars.categoria && obj.categoria) {
//         vars.categoria.innerHTML = obj.categoria.nombre
//             ? "Categoria: " + obj.categoria.nombre
//             : "";
//         vars.categoria.hidden = !obj.categoria.nombre;
//     }

//     if (vars.categoria && obj.nivel_educativo) {
//         vars.categoria.innerHTML = obj.nivel_educativo.nombre
//             ? "Nivel educativo: " + obj.nivel_educativo.nombre
//             : "";
//         vars.categoria.hidden = !obj.nivel_educativo.nombre;
//     }

//     if (vars.nombre && (obj.comedor || obj.nombre)) {
//         vars.nombre.innerHTML = obj.nombre || obj.comedor.nombre || "";
//         vars.nombre.hidden = !(obj.nombre || obj.comedor.nombre);
//     }

//     if (vars.informacion) {
//         vars.informacion.innerHTML = obj.informacion || "";
//     }

//     if (vars.tipo) {
//         vars.tipo.hidden = !obj.ruta_imagen;
//         vars.tipo.src = obj.ruta_imagen || "#";
//     }

//     if (vars.nombre_instructor) {
//         const elementos_enlace_a =
//             vars.nombre_instructor.querySelector("a") || undefined;
//         elementos_enlace_a.href = obj.nombre_instructor || "#";
//         elementos_enlace_a.innerText = obj.nombre_instructor || "";
//         vars.nombre_instructor.hidden = !obj.nombre_instructor;
//     }

//     if (vars.sede) {
//         const elementos_pdf_a = vars.sede.querySelector("a") || undefined;
//         elementos_pdf_a.href = obj.ruta_archivo || "#";
//         elementos_pdf_a.innerText = obj.ruta_archivo || "";
//         vars.sede.hidden = !obj.ruta_archivo;
//     }
//     if (vars.fecha_inicio) {
//         vars.fecha_inicio.innerHTML = obj.fecha_inicio
//             ? obtenerFecha(obj.fecha_inicio)
//             : "";
//         vars.fecha_inicio.hidden = !obj.fecha_inicio;
//     }
//     if (vars.fecha_final) {
//         vars.fecha_final.innerHTML = obj.fecha_final
//             ? obtenerFecha(obj.fecha_final)
//             : "";
//         vars.fecha_final.hidden = !obj.fecha_final;
//     }
// }

// // Obtener fecha_inicio
// function obtenerFecha(f) {
//     const fecha = new Date(f);
//     const d = fecha.getDate();
//     const m = meses[fecha.getMonth()];
//     const a = fecha.getFullYear();

//     return `${d} de ${m} de ${a}`;
// }

// // Limpiamos
// function limpiarDatosModal() {}
