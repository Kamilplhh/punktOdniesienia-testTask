import $, { error } from 'jquery';
window.$ = $;

function test(data) {
    let text = ($('#textFile').text()).replace(/\s/g, '');
    let paid = 0;
    let priceArray = "";
    let bankArray = "";
    let timeArray = "";
    let nipArray = "";
    let invoiceArray = "";
    let p = "";
    let b = "";
    let t = "";
    let n = "";
    let i = "";

    $.each(data, function (index, item) {
        $.each(item, function (index, object) {
            if (object.priceText != 0) p = object.priceText;
            if (object.bankText != 0) b = object.bankText;
            if (object.timeText != 0) t = object.timeText;
            if (object.nipText != 0) n = object.nipText;
            if (object.invoiceText != 0) i = object.invoiceText;

            if (!($.isEmptyObject(text.match(p)))) {
                priceArray = text.split(p);
            }
            if (!($.isEmptyObject(text.match(b)))) {
                bankArray = text.split(b);
            }
            if (!($.isEmptyObject(text.match(t)))) {
                timeArray = text.split(t);
            }
            if (!($.isEmptyObject(text.match(n)))) {
                nipArray = text.split(n);
            }
            if (!($.isEmptyObject(text.match(i)))) {
                invoiceArray = text.split(i);
            }
        })
    });
    //Add all array's to one array and check if any of elements is empty
    if (priceArray === "" || bankArray === "" || timeArray === "" || nipArray === "" || invoiceArray === "") {
        alert('Something went wrong');
        $(location).prop('href', '/');
    } else {
        let adress = ((text.split('-=-')).pop().split('-=-').shift());
        let recipient = ((text.split('+=+')).pop().split('+=+').shift());
        let title = ((text.split('-+=')).pop().split('=+-').shift());
        let fileName = (text.split('===')).pop();

        let priceText = priceArray.pop();
        let bankText = bankArray.pop();
        let timeText = timeArray.pop();
        let nipText = nipArray.pop();
        let invoiceText = invoiceArray.pop();

        let price = priceText.split('PLN').shift();
        let bank = bankText.slice(0, 26);
        let time = timeText.slice(0, 10);
        let nip = nipText.slice(0, 10);
        let invoice = invoiceText.slice(0, 16);

        if (text.match('Paid')) {
            paid = 1;
        }
        $.ajax({
            url: 'send',
            type: 'POST',
            data: {
                _token: $('#signup-token').val(),
                file: fileName,
                title: title,
                price: price,
                date: time,
                bank: bank,
                paid: paid,
                nip: nip,
                invoice_number: invoice,
                adress: adress,
                recipient: recipient,
            },
            success: function () {
                $(location).prop('href', '/');
            },
            error: function () {
                alert('Something went wrong');
                $(location).prop('href', '/');
            }
        });
    }
}

function data() {
    $.ajax({
        url: 'getScanText',
        type: 'get',
        dataType: 'json',
        success: function (response) {
            test(response);
        },
        error: function () {
            alert('Something went wrong');
            $(location).prop('href', '/');
        }
    });
}

$(document).ready(function () {
    data();
});