import $, { error } from 'jquery';
window.$ = $;

$('#downloadAll').on('click', function () {
    let files = [];
    $('.dataBlock').each(function () {
        if (!$(this).hasClass('off')) {
            files.push($(this).find('.fileName').text());
        }
    })

    $.ajax({
        url: 'downloadAll',
        type: 'POST',
        data: {
            _token: $('#token').val(),
            files: files,
        },
        success: function (response) {
            window.location.href ='/uploads/zips/'+ response;
        },
        error: function () {
            alert('Something went wrong');
            $(location).prop('href', '/');
        }
    });
})

$('#sendAll').on('click', function () {
    let files = [];
    $('.dataBlock').each(function () {
        if (!$(this).hasClass('off')) {
            files.push($(this).find('.fileName').text());
        }
    })

    $.ajax({
        url: 'sendEmail',
        type: 'POST',
        data: {
            _token: $('#token').val(),
            files: files,
            email: $('#emailTo').attr('value'),
        },
        success: function () {
            alert('Mail został wysłany')
        }
    });
})
