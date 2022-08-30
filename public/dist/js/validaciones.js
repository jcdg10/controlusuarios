$(document).ready(function () {
  /*Permitir solamente letras*/
  $(".alpha-only").on("input", function () {
    var regexp = /[^a-zA-ZñÑ ]/g;
    if ($(this).val().match(regexp)) {
      $(this).val($(this).val().replace(regexp, ""));
    }
  });

  $(".email-only").on("input", function () {
    var regexp = /[^a-zA-Z0-9 @_.-]/g;
    if ($(this).val().match(regexp)) {
      $(this).val($(this).val().replace(regexp, ""));
    }
  });

  $(".rfc-only").on("input", function () {
    var regexp = /[^a-zA-Z0-9nÑ&]/g;
    if ($(this).val().match(regexp)) {
      $(this).val($(this).val().replace(regexp, ""));
    }
  });

  /*Permitir solamente letras y numeros*/
  $(".alphaNumeric-only").on("input", function () {
    var regexp = /[^a-zA-Z0-9 @.]/g;
    if ($(this).val().match(regexp)) {
      $(this).val($(this).val().replace(regexp, ""));
    }
  });

  /*Permitir solamente letras, numeros,puntos y comas*/
  $(".alphaNumericDot-only").on("input", function () {
    var regexp = /[^a-zA-Z0-9 @.,:]/g;
    if ($(this).val().match(regexp)) {
      $(this).val($(this).val().replace(regexp, ""));
    }
  });

  /*Permitir solamente letras y numeros sin punto*/
  $(".alphaNumericNDot-only").on("input", function () {
    var regexp = /[^a-zA-Z0-9 @]/g;
    if ($(this).val().match(regexp)) {
      $(this).val($(this).val().replace(regexp, ""));
    }
  });
  /*Permitir solamente numeros*/
  $(".numeric-only").on("input", function () {
    var regexp = /[^0-9]/g;
    if ($(this).val().match(regexp)) {
      $(this).val($(this).val().replace(regexp, ""));
    }
  });
  /*Permitir solamente numeros y ":" reloj*/
  $(".time-only").on("input", function () {
    var regexp = /[^0-9:]/g;
    if ($(this).val().match(regexp)) {
      $(this).val($(this).val().replace(regexp, ""));
    }
  });

  /*Permitir numero decimales */
  $(".numericDecimal-only").on("input", function () {
    var regexp = /[^\d.]/g;
    if ($(this).val().match(regexp)) {
      $(this).val($(this).val().replace(regexp, ""));
    }
  });

});
