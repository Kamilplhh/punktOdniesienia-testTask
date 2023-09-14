import '../css/admin.css';
import $, { error } from 'jquery';
window.$ = $;

$('.submit').on("click", function () {
    let value = parseInt($('.back').attr('value')) + 1;
    if (value < 3) {
        $('.back').val(value);
        backButton();
    }else{
        checkForm();
    }
})

$('.back').on("click", function () {
    let value = parseInt($('.back').attr('value')) - 1;
    if(value < 0){
        window.location.href = '/login';
    }else{
        $('.back').val(value);
        backButton();
    }
})


function backButton() {
    let button = $('.back').attr('value');

    if (button == 2) {
        $('#skip').removeClass("off");
    } else {
        $('#skip').addClass("off");
    }

    $('#' + button).removeClass("off");
    $(".block:not(#" + button + ")").addClass("off");
}

function checkForm() {
    let status = 0;
    let password = $('#password').val();
    let password2 = $('.passwordRepeat').val();

    $(":input").not(".skip").each(function( index ) {
        if(!$(this).val()) {
            status = status +1;
            $(this).addClass('is-invalid'); 
        }
      });

    if(status === 0 ){
        if(password != password2){
            $('.passwordRepeat').addClass('is-invalid');
            alert('Hasła się nie zgadzają');
    
            $('.back').val(0);
            backButton();
        }
    
        if(password > 7){
            $('#password').addClass('is-invalid');
            alert('Hasło jest za krótkie');
    
            $('.back').val(0);
            backButton();
        }
    
        let email = $('#emailto').val();
    
        if(email.search('@') === -1){
            $('.passwordRepeat').addClass('is-invalid');
            alert('Email nie jest poprawny');
    
            $('.back').val(1);
            $('#emailto').addClass('is-invalid');
            $('#invoiceemail').addClass('is-invalid');
            backButton();
        }
    } else {
        alert('Prosze uzupełnić wszystkie pola');
        $('.back').val(0);
        backButton();
    }
    
}