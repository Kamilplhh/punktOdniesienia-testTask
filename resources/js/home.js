import $, { error } from 'jquery';
window.$ = $;

//Page onload functions
$(document).ready(function () {
  getMonth(0);
  exceeded()
});

//Get month for calendar
function getMonth(x) {
  const m = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

  let date = new Date();
  let d = subtractMonths(date, x);
  let month = m[d.getMonth()];
  let year = d.getFullYear();

  $('.month').text(month);
  $('.year').text(year);

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
      x = x + parseInt($(this).text());
  })

  $('.cost').text(x + ' PLN');
};

//Check if there is no payment date exceed
function exceeded() {
  let date = new Date();

  $('span').filter('.unpaid').each(function () {
    let block = $(this).next();
    let textDate = new Date(block.text());

    let difference = date - textDate;
    if (difference > 0) {
      difference = Math.round(Math.abs(difference / (1000 * 3600 * 24)) - 1);
      if (difference > 1) {
        block.append('<h6 class="late">exceeded ' + difference + ' days</h6>')
      } else
        block.append('<h6 class="late">exceeded ' + difference + ' day</h6>')
    }
  })
};

//Toggle mail block
$('.fa-eye').on("click", function () {
  $('.mailBlock').toggleClass('off');
})

$('.exit').on("click", function () {
  $('.mailBlock').toggleClass('off');
})

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

  $('#' + id).addClass("selected");
  $(".homeNavi:not(#" + id + ")").removeClass("selected");
  itemsPrice();
});

function showIncoming() {
  $('span').filter('.btn').each(function () {
    if ($(this).text() == "Paid") {
      $(this).closest('.dataBlock').addClass("off offline");
    } else {
      $(this).closest('.dataBlock').removeClass("off offline");
    }
  })
  $('.operations').html('<i class="incoming cost"></i>' +
    '<button class="btn">Pay all <i class="fa-brands fa-google-pay"></i></button>')

  getMonth($('#next').attr('value'));
  checkIfEmpty();
};

function showPaid() {
  $('span').filter('.btn').each(function () {
    if ($(this).text() == "Unpaid") {
      $(this).closest('.dataBlock').addClass("off offline");
    } else {
      $(this).closest('.dataBlock').removeClass("off offline");
    }
  })
  $('.operations').html('<button id="add" class="btn">Add document <i class="fa-solid fa-file-circle-plus"></i></button>' +
    '<button id="scan" class="btn">Scan receipts <i class="fa-solid fa-file-lines"></i></button>')

  getMonth($('#next').attr('value'));
  checkIfEmpty();
};

function showAll() {
  $('span').filter('.btn').each(function () {
    $(this).closest('.dataBlock').removeClass("off offline");
  })
  $('.operations').html('<button class="btn">Send all documents <i class="fa-solid fa-play"></i></button>')
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
      $('#noFiles').addClass("off");
    }
  })
  if (x === 0) {
    $('#noFiles').removeClass("off");
  }
}

//Add document
$('.operations').on('click', '#add', function () {
  $('.document').toggleClass('off');
})

$('.operations').on('click', '#scan', function () {
  $('.scan').toggleClass('off');
})