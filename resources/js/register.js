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

    $(".form-control").not(".skip").each(function() {
        if(!$(this).val()) {
            console.log($(this).attr('id'));
            status = status +1;
            $(this).addClass('is-invalid'); 
        }
      });

    if(status === 0 ){
        if(password != password2){
            $('.passwordRepeat').addClass('is-invalid');
            alert('Hasła się nie zgadzają');
    
            back();
        }
    
        if(password > 7){
            $('#password').addClass('is-invalid');
            alert('Hasło jest za krótkie');
    
            back();
        }
    
        let email = $('#emailTo').val();
    
        if(email.search('@') === -1){
            alert('Email nie jest poprawny');
    
            $('#emailTo').addClass('is-invalid');
            $('#invoiceEmail').addClass('is-invalid');
            back();
        }
        else {
            $('.submit').attr("type", "submit");
        }
    } else {
        alert('Prosze uzupełnić wszystkie pola');
        back();
    }
}

function back() {
    $('.back').val(0);
        backButton();
}