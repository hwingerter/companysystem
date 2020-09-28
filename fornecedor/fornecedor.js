
    $.validator.setDefaults( {
        submitHandler: function (form) {
            form.submit();
            return false;
        }
    } );

	$( document ).ready( function () {

		$('#telefone').mask('(99) 9999-99999');
		$('#cep').mask('99999-999');

        $("#formCadastro").validate( {
            rules: {
                nome_fantasia: {
                    required: true,
                    minlength: 10
                },
            },
            messages: {
                nome_fantasia: {
                    required: "É necessário preencher o Nome Fantasia",
                    minlength: "Pelo menos 10 caracteres"
                },
            },
            errorElement: "em",
            errorPlacement: function ( error, element ) {
                // Add the `help-block` class to the error element
                error.addClass( "help-block" );

                if ( element.prop( "type" ) === "checkbox" ) {
                    error.insertAfter( element.parent( "label" ) );
                } else {
                    error.insertAfter( element );
                }
            },
            highlight: function ( element, errorClass, validClass ) {
                $( element ).parents( ".col-sm-8" ).addClass( "has-error" ).removeClass( "has-success" );
            },
            unhighlight: function (element, errorClass, validClass) {
                $( element ).parents( ".col-sm-8" ).addClass( "has-success" ).removeClass( "has-error" );
            }
        } );


	} );
