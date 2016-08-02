jQuery.extend(jQuery.validator.messages, {
    required: "Campo obligatorio.",
    remote: "Error.",
    email: "Entre una dirección de correo válida.",
    url: "Entre una URL válida.",
    date: "Entre una fecha válida.",
    dateISO: "Please enter a valid date (ISO).",
    number: "Entre un número válido.",
    digits: "Entre solo dígitos.",
    creditcard: "Please enter a valid credit card number.",
    equalTo: "Los valores no coinciden.",
    accept: "Extensión no válida.",
    maxlength: jQuery.validator.format("Entre menos de {0} caracteres."),
    minlength: jQuery.validator.format("Entre al menos {0} caracteres."),
    rangelength: jQuery.validator.format("Introduzca un valor de longitud entre {0} y {1} caracteres."),
    range: jQuery.validator.format("Introduzca un valor entre {0} y {1}."),
    max: jQuery.validator.format("Entre un valor menor o igual que {0}."),
    min: jQuery.validator.format("Entre un valor mayor o igual que {0}.")
});