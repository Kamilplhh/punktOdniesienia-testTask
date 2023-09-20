import $, { error } from 'jquery';
window.$ = $;

$(document).ready(function () {
  showEmails();
});

$('.edit').on("click", function () {
  let object = $(this).closest('div.dataDiv')
  object.find('input:not(.skip)').each(function () {
    $(this).prop("disabled", false);

  })
  object.find('.buttons').removeClass('off')
})

$('.cancel').on("click", function () {
  let object = $(this).closest('div.dataDiv')
  object.find('input:not(.skip)').each(function () {
    $(this).prop("disabled", true);

  })
  object.find('.buttons').addClass('off')
})

function showEmails() {
  $('.emails').each(function () {
    let block = $(this)
    if (block.find('input').val() === '') {
      block.addClass('off')
    }
  })
}

$('.emailAdd').on("click", function () {
  $(this).parent().parent().find('.emails').each(function () {
    if ($(this).hasClass('off')) {
      $(this).removeClass('off');
      return false;
    }
  })
})

$('.remove').on("click", function () {
  let parent = $(this).parent()
  parent.find('input').attr('value','');
  parent.addClass('off');
})