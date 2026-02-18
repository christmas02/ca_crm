/**
* DEV: MASTER ZE KOTCH/
*/
!(function($) {

  //$(document).on("keydown keyup blur input",".telReg",function(e){this.value.length>=10&&$(this).val($(this).val().substr(0,10));var t=String.fromCharCode(e.which)||e.key;if(/[a-z]/i.test(t))return e.preventDefault(),!1});
  //(document).on("keydown keyup blur input",".scdcode",function(e){this.value.length>=4&&$(this).val($(this).val().substr(0,4));var t=String.fromCharCode(e.which)||e.key;if(/[a-z]/i.test(t))return e.preventDefault(),!1});
  //$(document).on("keydown keyup blur input",".numberonly",function(e){this.value.length>=20&&$(this).val($(this).val().substr(0,20));var t=String.fromCharCode(e.which)||e.key;if(/[a-z]/i.test(t))return e.preventDefault(),!1});


   $.fn.inputFilter = function(inputFilter) {
    return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
      if (inputFilter(this.value)) {
        this.oldValue = this.value;
        this.oldSelectionStart = this.selectionStart;
        this.oldSelectionEnd = this.selectionEnd;
      } else if (this.hasOwnProperty("oldValue")) {
        this.value = this.oldValue;
        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
      } else {
        this.value = "";
      }
    });
  };

  $(".telReg").inputFilter(function(value) {
  return /^-?\d*$/.test(value) && (value.length <=10);});

   $(".indicatif").inputFilter(function(value) {
  return /^-?\d*$/.test(value) && (value.length <=5);});

  $(".numberonly").inputFilter(function(value) {
  return /^-?\d*$/.test(value) && (value.length <=20);});

	$(".taille").inputFilter(function(value) {
	  return /^-?\d*$/.test(value) && (value.length <=3);});

	$("#numpassport").inputFilter(function(value) {
    //autorise chiffre caractere alpha et estpace limete a 9
	  return /^[0-9a-z ]*$/i.test(value)&& (value.length <=9); });

  $("#numpiece").inputFilter(function(value) {
    //autorise chiffre caractere alpha limete a 25
    return /^[0-9a-z]*$/i.test(value)&& (value.length <=25); });

	$(".maxlength25").inputFilter(function(value) {
    //autorise chiffre caractere alpha et estpace limete a 25
	  return /^[0-9a-z' -]*$/i.test(value)&& (value.length <=25); });

  $(".maxlength10").inputFilter(function(value) {
    //autorise chiffre caractere alpha et estpace limete a 25
    return /^[0-9a-z' -]*$/i.test(value)&& (value.length <=10); });


})(jQuery);