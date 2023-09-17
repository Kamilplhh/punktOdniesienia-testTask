import $, { error } from 'jquery';
window.$ = $;

$('.navi').on("click", function () {
  let id = $(this).attr('id');

  showPanel(id)
});

$('.submit').on("click", function () {
  let password = $('#password1').val();
  let password2 = $('#inputPassword').val();

  if (password != password2) {
    $('#inputPassword').addClass('is-invalid');
    alert('Hasła się nie zgadzają');

    event.preventDefault();
    showPanel("password");
  } else {
    if (password.length > 1 && password.length < 8) {
      $('#password1').addClass('is-invalid');
      alert('Hasło jest za krótkie');
      event.preventDefault();
      showPanel("password");
    }
    else {
      $(this).closest('form').submit();
    }
  }
})

function showPanel(id) {
  $('.' + id).removeClass("off");
  $(".block:not(." + id + ")").addClass("off");

  $('#' + id).addClass("text-primary");
  $('#' + id).removeClass("text-secondary");
  $(".navi:not(#" + id + ")").addClass("text-secondary");
  $(".navi:not(#" + id + ")").removeClass("text-primary");
}

//Contractors page
$('.edit').on("click", function () {
  $(this).closest('form').submit();
})

