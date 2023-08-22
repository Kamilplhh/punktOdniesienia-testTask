import $, { error } from 'jquery';
window.$ = $;

function test(){
    let x = ($('body').text()).replace(/\s/g, '');

    let p = "TWOJAKWOTADOZAPŁATY";
    let b = "Nrrachunku:";
    let t = "Terminpłatności:"

    let priceArray = x.split(p);
    let bankArray = x.split(b);
    let timeArray = x.split(t);

    let priceText = priceArray.pop();
    let bankText = bankArray.pop();
    let timeText = timeArray.pop();

    let price = priceText.split('PLN').shift();
    let bank = bankText.slice(0,26);
    let time = timeText.slice(0,10);


}

function data(){
    $.ajax({
        url: 'getScanText',
        type: 'get',
        dataType: 'json',
        success: function(response){
           console.log(response);
        },
        error: function () {
            alert('Something went wrong');
        }
      });
}

data();