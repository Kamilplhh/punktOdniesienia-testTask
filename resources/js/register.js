import '../css/admin.css';
import $, { error } from 'jquery';
window.$ = $;

$('.submit').on("click", function () {
    let value = parseInt($('.back').attr('value')) + 1;
    if (value < 3) {
        $('.back').val(value);
        backButton();
    } else {
        let y = 0
        $('#2').find('input').each(function () {
            if ($(this).attr('id') === 'invoiceEmail') {
                if ($(this).val().search('@') === -1) {
                    y = y + 1;
                    $(this).addClass('is-invalid');
                    alert('Email nie jest poprawny');
                }
            } else {
                if ($(this).val() === '') {
                    y = y + 1;
                    $(this).addClass('is-invalid');
                }
            }
        })
        if (y === 0) {
            $('#2').find('input').each(function () {
                $(this).removeClass('is-invalid');
            })
            checkForm('.submit');
        } else {
            alert('Prosze uzupełnić poprawnie dane');
        }
    }
})

$('.back').on("click", function () {
    let value = parseInt($('.back').attr('value')) - 1;
    if (value < 0) {
        window.location.href = '/login';
    } else {
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

function checkForm(name) {
    let status = 0;
    let password = $('#password').val();
    let password2 = $('.passwordRepeat').val();

    $(".form-control").not(".skip").each(function () {
        if (!$(this).val()) {
            status = status + 1;
            $(this).addClass('is-invalid');
        }
    });

    if (status === 0) {
        let status2 = 0
        if (password != password2) {
            $('.passwordRepeat').addClass('is-invalid');
            alert('Hasła się nie zgadzają');
            status2 = status2 + 1;
            back();
        }

        if ($('#password').val().length < 8) {
            $('#password').addClass('is-invalid');
            alert('Hasło jest za krótkie');
            status2 = status2 + 1;
            back();
        }

        if (($('#emailTo').val().search('@') === -1) || ($('#email').val().search('@') === -1)) {
            alert('Email nie jest poprawny');
            status2 = status2 + 1;
            back();
        }

        if(status2 === 0) {
            $(name).attr("type", "submit");
        }
    } else {
        alert('Prosze uzupełnić wszystkie pola');
        back();
    }
}

$('#skip').on("click", function () {
    $('#2').find('input').each(function () {
        $(this).val('');
    })

    checkForm('#skip');
})

function back() {
    $('.back').val(0);
    backButton();
}