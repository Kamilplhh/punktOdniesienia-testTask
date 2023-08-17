import $, { error } from 'jquery';
window.$ = $;

function test(){
    let x = ($('body').text()).trim();
    let y = "TWOJA KWOTA DO ZAPŁATY";

    let array = x.split(y);

    let result = array.pop();


    
console.log(result);
}

test();