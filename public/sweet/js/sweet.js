// $(".formulario-eliminar").submit(function (e) {
// 	e.preventDefault();
// 	Swal.fire({
// 		title: '¿Está seguro?',
// 		text: '¡ No podrá recuperar este registro !',
// 		icon: 'warning',	/*icono que va mostrar success-error-info-warning-question*/
// 		showCancelButton: true,
// 		confirmButtonColor: '#2CB073',
// 		cancelButtonColor: '#d33',
// 		confirmButtonText: 'Si, Eliminar',
// 		cancelButtonText: 'No, Salir',
// 		reverseButtons: true,
// 		//width:'300px',
// 		padding: '20px',
// 		//background: 'rgb(70,200,255)',
// 		backdrop: true,	/* color oscuro de la pagina true-false */

// 		position: 'top',	/* posicion de ubicacion top--bottom--center top-end bottom-end top-start */
// 		/* bottom-start center-start center-end */

// 		allowOutsideClick: true,	/* para NO salir con un click */
// 		allowEscapeKey: true,	/* para SI salir con un escape */
// 		allowEnterKey: false,	/* para SI salir con un enter */

// 	}).then((result) => {
// 		/* Read more about isConfirmed, isDenied below */
// 		if (result.isConfirmed) {
// 		  this.submit();
// 		}
// 	  })
// })




$(document).on("click", "a.eliminar", function (event) {
    event.preventDefault(); // Evita que se siga el enlace
    var form = $(this).parent(".formulario-eliminar"); // Obtiene el formulario anterior al botón
    var url = form.attr("action"); // Obtiene la URL de la ruta de eliminación
    var csrf_token = $('meta[name="csrf-token"]').attr("content"); // Obtiene el token CSRF

    Swal.fire({
        title: "¿Está seguro?",
        text: "¡ No podrá recuperar este registro !",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#2CB073",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, Eliminar",
        cancelButtonText: "No, Salir",
        reverseButtons: true,
        padding: "20px",
        backdrop: true,
        position: "top",
        allowOutsideClick: true,
        allowEscapeKey: true,
        allowEnterKey: false,
    }).then((confirm) => {
        if (confirm.isConfirmed) {
            // Agrega el token CSRF al formulario
            form.append(
                '<input type="hidden" name="_token" value="' + csrf_token + '">'
            );
            form.submit(); // Envía el formulario
        }
    });
});


