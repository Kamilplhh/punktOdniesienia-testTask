import $, { error } from 'jquery';
window.$ = $;

//Page onload functions
$(document).ready(function () {
  getMonth(0);
  markEmpty();
  // exceeded()
});

//Get month for calendar
function getMonth(x) {
  const m = ["Styczeń", "Luty", "Marzec", "Kwiecień", "Maj", "Czerwiec", "Lipiec", "Sierpień", "Wrzesień", "Październik", "Listopad", "Grudzień"];

  let date = new Date();
  let d = subtractMonths(date, x);
  let month = m[d.getMonth()];
  let year = d.getFullYear();
  let nextMonth = m[d.getMonth() +1];

  $('.month').html(month + '<sup class="text-secondary">'+ year +'</sup>');
  $('.nextMonth').text(nextMonth);

  let dataDate = year + '-' + (d.getMonth() + 1);
  getDataFromMonth(dataDate);
};

function subtractMonths(date, months) {
  date.setMonth(date.getMonth() - months);
  return date;
};

//Function to switch actual month
$('.arrow').on("click", function () {
  let id = $(this).attr('id');
  let val = parseInt($(this).attr('value'));

  if (id == "back") {
    let newVal = val + 1;
    getMonth(val);

    $(this).attr("value", newVal);
    $('#next').attr("value", val);
  } else {
    let newVal = val - 1;
    getMonth(newVal);

    $(this).attr("value", newVal);
    $('#back').attr("value", val);
  }

  if ($('#next').attr('value') > 0) {
    $('#next').removeClass("disabled");
  } else {
    $('#next').addClass("disabled");
  }

});

function itemsPrice() {
  let x = 0;

  $('.price').each(function () {
    if (!$(this).closest('.dataBlock').hasClass('off') && !$(this).closest('.dataBlock').hasClass('offline'))
      x = x + parseFloat($(this).text());
  });

  // checkBankSet();
  $('.fullPrice').html('Razem: ' + x.toFixed(2) +
  '<small class="ps-1 text-secondary">PLN</small>');
};


//Whole panel navi system
$('.homeNavi').on("click", function () {
  let id = $(this).attr('id');
  
  if (id == "incoming") {
    showIncoming();
  } else if (id == "paid") {
    showPaid();
  } else {
    showAll();
  }
  
  $('#' + id).addClass("text-primary");
  $('#' + id).removeClass("text-secondary");
  $(".homeNavi:not(#" + id + ")").addClass("text-secondary");
  $(".homeNavi:not(#" + id + ")").removeClass("text-primary");
  itemsPrice();
});

function showIncoming() {
  $('span').filter('.status').each(function () {
    if ($(this).attr('id') == "p") {
      $(this).closest('.dataBlock').addClass("off offline");
    } else {
      $(this).closest('.dataBlock').removeClass("off offline");
    }
  })
  
  getMonth($('#next').attr('value'));
  checkIfEmpty();
};

function showPaid() {
  $('span').filter('.status').each(function () {
    if ($(this).attr('id') == "p") {
      $(this).closest('.dataBlock').removeClass("off offline");  
    } else {
      $(this).closest('.dataBlock').addClass("off offline");
    }
  })
  
  getMonth($('#next').attr('value'));
  checkIfEmpty();
};

function showAll() {
  $('span').filter('.status').each(function () {
    $(this).closest('.dataBlock').removeClass("off offline");
  })
  
  getMonth($('#next').attr('value'));
  checkIfEmpty();
};

//Live print data per each month
function getDataFromMonth(data) {
  $('.fileDate').each(function () {
    if (!$(this).closest('.dataBlock').hasClass("offline")) {
      let fileDate = new Date($(this).text());
      fileDate = fileDate.getFullYear() + '-' + (fileDate.getMonth() + 1);
      
      if (fileDate != data) {
        $(this).closest('.dataBlock').addClass("off");
      } else {
        $(this).closest('.dataBlock').removeClass("off");
      }
    }
  })
  checkIfEmpty();
  itemsPrice();
}

//If data panel for selected month is empty show information about that
function checkIfEmpty() {
  let x = 0
  $('.dataBlock').each(function () {
    if (!$(this).hasClass('off')) {
      x = x + 1;
      $('#empty').addClass("off");
      $('#main').removeClass("off");
    }
  })
  if (x === 0) {
    $('#empty').removeClass("off");
    $('#main').addClass("off");
  }
}

function markEmpty(){
  $('input').not(".skip").each(function(){
    if($(this).val().length === 0) $(this).addClass('is-invalid');
  })
}

$('.paidStatus').on("click", function() {
    let name = $(this).attr('class');
    let blue = 'btn-outline-primary';
    let green = 'btn-success';

    if (name.includes('primary')){
      $(this).removeClass(blue);
      $(this).addClass(green);
      $(this).text('Zapłacono')
      $(this).closest('div').find('.paidHidden').val(1);
    } else {
      $(this).removeClass(green);
      $(this).addClass(blue);
      $(this).text('Nie zapłacono')
      $(this).closest('div').find('.paidHidden').val(0);
    }
    
}) 

$('.addContractor').on("click", function() {
  let contractor = $(this).closest('div.data').find('input[name="contractor"]').val();
  let address1 = $(this).closest('div.data').find('input[name="address1"]').val();
  let address2 = $(this).closest('div.data').find('input[name="address2"]').val();
  let bank = $(this).closest('div.data').find('input[name="bank"]').val();
  let nip = $(this).closest('div.data').find('input[name="nip"]').val();
  let email = $(this).closest('div.data').find('input[name="email"]').val();

  $.ajax({
    url: '/addContractor',
    type: 'POST',
    data: {
        _token: $('#token').val(),
        contractor: contractor,
        address1: address1,
        address2: address2,
        bank: bank,
        nip: nip,
        email: email,
    },
    success: function () {
      $(location).prop('href', '/');
    },
    error: function () {
        alert('Something went wrong, remember to fulfill all inputs');
        $(location).prop('href', '/');
    }
});
})

//Check if there is no payment date exceed
// function exceeded() {
//   let date = new Date();

//   $('span').filter('.unpaid').each(function () {
//     let block = $(this).next();
//     let textDate = new Date(block.text());

//     let difference = date - textDate;
//     if (difference > 0) {
//       difference = Math.round(Math.abs(difference / (1000 * 3600 * 24)));
//       if (difference > 1) {
//         block.append('<h6 class="late">exceeded ' + difference + ' days</h6>')
//       } else
//         block.append('<h6 class="late">exceeded ' + difference + ' day</h6>')
//     }
//   })
// };

//Toggle mail block
// $('.fa-eye').on("click", function () {
//   let id = $(this).attr('id');
//   $('#mailBlock' + id).toggleClass('off');
// })

// $('.exit').on("click", function () {
//   $(this).closest('.mailBlock').toggleClass('off');
// })

// function checkBankSet() {
  //   let z = 0;
  
  //   $('.credit').each(function () {
    //     if (!$(this).closest('.dataBlock').hasClass("off")) {
      //       if ($(this).attr('value') == 0) {
        //         $(this).addClass('disabled');
        //         z = z + 1;
        //       }
        //     }
        //   });
        
        //   if (z > 0) {
          //     $('.fa-google-pay').closest('.btn').addClass('disabled');
          //   }
          //   else {
            //     $('.fa-google-pay').closest('.btn').removeClass('disabled');
            //   }
            // }
            
            // $('.credit').on("click", function () {
              //   let id = $(this).attr('id');
              //   let name = $('#name' + id).attr('value');
//   let nameArray = name.split(" ");
//   let firstName = nameArray[0];
//   let lastName = nameArray[1];

//   let bank = $('#bank' + id).attr('value');
//   let email = $('#email' + id).attr('value');
//   let amount = $('#price' + id).attr('value');
//   amount = String(amount);
//   amount = parseInt(amount + '00');

// })


// $('.operations').on('click', '#payAll', function () {
//   let payoutArray = [];
//   let cost = 0;
//   $('.priceI').each(function () {
//     if (!$(this).closest('.dataBlock').hasClass("off")) {
//       let id = $(this).attr('id').slice(-1);

//       let bank = $('#bank' + id).attr('value');
//       let email = $('#email' + id).attr('value');
//       let name = $('#name' + id).attr('value');
//       let nameArray = name.split(" ");
//       let firstName = nameArray[0];
//       let lastName = nameArray[1];
//       let amount = $('#price' + id).attr('value');
//       amount = String(amount);
//       amount = parseInt(amount + '00');

//       cost = cost + parseInt(amount);
//       let object = {
//         id: '',
//         ban: bank,
//         amount: amount,
//         title: '',
//         label: email
//       };
//       payoutArray.push(object);
//     }
//   })
// })