import $, { error } from 'jquery';
window.$ = $;

//Page onload functions
$(document).ready(function () {
  getMonth(0);
  markEmpty();
  frequency();
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

//Adding contractor on click
$('.addContractor').on("click", function() {
  $.ajax({
    url: '/addContractor',
    type: 'POST',
    data: {
        _token: $('#token').val(),
        contractor: $(this).closest('div.data').find('input[name="contractor"]').val(),
        address1: $(this).closest('div.data').find('input[name="address1"]').val(),
        address2: $(this).closest('div.data').find('input[name="address2"]').val(),
        bank: $(this).closest('div.data').find('input[name="bank"]').val(),
        nip: $(this).closest('div.data').find('input[name="nip"]').val(),
        email: $(this).closest('div.data').find('input[name="email"]').val(),
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

$('.edit').on("click", function(){
  $(this).closest('div.dataBlock').find('form').trigger('submit');
})

$('li').on("click", function(){
  let object = $(this);
  let id = $(this).val();
  $(this).closest('ul.contractorDiv').find('input[name="contractor_id"]').val(id);

  getContractor(id, object)
})

function getContractor(id, object) {
  $.ajax({
    url: '/getContractor/' + id,
    type: 'GET',
    success: function (response) {
      if(response.length === 0){
        $(object).closest('div.row').find('input[name="contractor"]').val('').prop("disabled", false);
        $(object).closest('div.row').find('input[name="address1"]').val('').prop("disabled", false);
        $(object).closest('div.row').find('input[name="address2"]').val('').prop("disabled", false);
        $(object).closest('div.row').find('input[name="bank"]').val('').prop("disabled", false);
        $(object).closest('div.row').find('input[name="nip"]').val('').prop("disabled", false);
        if($(object).closest('div.row').attr('id') === 'cycle'){
          $(object).closest('div.row').find('input[name="email"]').val('').prop("disabled", false);
        }
      }
      else {
        $(object).closest('div.row').find('input[name="contractor"]').val(response[0].contractor).prop("disabled", true);
        $(object).closest('div.row').find('input[name="address1"]').val(response[0].address1).prop("disabled", true);
        $(object).closest('div.row').find('input[name="address2"]').val(response[0].address2).prop("disabled", true);
        $(object).closest('div.row').find('input[name="bank"]').val(response[0].bank).prop("disabled", true);
        $(object).closest('div.row').find('input[name="nip"]').val(response[0].nip).prop("disabled", true);
        if($(object).closest('div.row').attr('id') === 'cycle'){
          $(object).closest('div.row').find('input[name="email"]').val(response[0].email).prop("disabled", true);
        }
      }
    },
    error: function () {
      alert('Something went wrong');
  }
});
}

$('.showcase').on("click", function() {
  $(this).closest('div').find('.invisible').trigger("click");
})

$('.fileNameAdd').on("click", function() {
  $(this).closest('div').find('.invisible').trigger("click");
})

$('.scanSubmit').on("click", function() {
  if($(this).parent().parent().find('.invisible').val() === ''){
    alert('Please upload file');
    event.preventDefault()
  }
})

$('.search').keyup(function() {
  let text = $(this).val();
  let li = $(this).closest('ul').find('li:not(.skip)')
  li.each(function(){
    if ($(this).text().match("^"+text)) {
      $(this).removeClass('off')
   } else{
     $(this).addClass('off')
   }
  })
})

function frequency() {
  $('.frequencyValue').each(function() {
    let value = $(this).val();
    $(this).closest('div').find('.frequencyOption[value='+value+']').attr("selected","selected");
  })
}