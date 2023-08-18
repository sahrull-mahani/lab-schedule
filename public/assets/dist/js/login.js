$('form').on('blur', 'input[required], input.optional, select.required', validator.checkField).on('change', 'select.required', validator.checkField).on('keypress', 'input[required][pattern]', validator.keypress);
$('.multi.required').on('keyup blur', 'input', function () {
  validator.checkField.apply($(this).siblings().last()[0]);
})
var token = $('.csrf-token').val()
var csrf_hash = $('.csrf-hash').val()
var ace = {}
ace[token] = csrf_hash
$.ajaxSetup({ data: ace })
$('form').submit(function (e) {
  e.preventDefault();
  if (!validator.checkAll($(this))) {
    false;
  } else {
    $.ajax({
      url: $(this).attr("action"),
      type: 'post',
      dataType: 'json',
      data: $("form").serialize(),
      beforeSend: function () {
        $('#btn-login').prop('type', 'button')
        $('#btn-login').toggleClass('d-none')
        $('#btn-login').next().toggleClass('d-none')
      },
      success: function (data) {
        console.log(data)
        if (data.type == 'success') {
          toastr.success(
            null,
            data.text,
            {
              timeOut: 1000,
              fadeOut: 1000,
              onclick: function () {
                $('#btn-login').toggleClass('d-none')
                $('#btn-login').next().toggleClass('d-none')
                window.location.replace(`${location.origin}/home`)
              },
              onHidden: function () {
                $('#btn-login').hide()
                $('#btn-login').toggleClass('d-none')
                $('#btn-login').next().toggleClass('d-none')
                window.location.replace(`${location.origin}/home`)
              }
            }
          )
        } else {
          if (data.type == 'error') {
            Swal.fire({
              title: 'Error',
              html: data.text,
              icon: 'error',
              confirmButtonText: 'OKE',
            }).then((result) => {
              /* Read more about isConfirmed, isDenied below */
              if (result.isConfirmed) {
                $('#btn-login').prop('type', 'submit')
                $('#btn-login').toggleClass('d-none')
                $('#btn-login').next().toggleClass('d-none')
              }
            })
          } else {
            toastr.warning(
              null,
              data.text,
              {
                timeOut: 3500,
                fadeOut: 3500,
                onclick: function () {
                  $('#btn-login').prop('type', 'submit')
                  $('#btn-login').toggleClass('d-none')
                  $('#btn-login').next().toggleClass('d-none')
                },
                onHidden: function () {
                  $('#btn-login').prop('type', 'submit')
                  $('#btn-login').toggleClass('d-none')
                  $('#btn-login').next().toggleClass('d-none')
                }
              }
            )
          }
        }
      },
      error: function (jqXHR, exception, thrownError) {
        toastr.error(
          "Error code" + jqXHR.status,
          thrownError + ", " + exception,
          {
            timeOut: 1000,
            fadeOut: 1000,
            onHidden: function () {
              $('#btn-login').prop('type', 'submit')
              $('#btn-login').toggleClass('d-none')
              $('#btn-login').next().toggleClass('d-none')
            }
          }
        )
      }
    })
  }
});

let key = 0
$('#password-icon').on('click', function () {
  if (key == 0) {
    $('#password').prop('type', 'text')
    $(this).removeClass('fas fa-lock').addClass('fas fa-unlock')
    key = 1
  } else {
    $('#password').prop('type', 'password')
    $(this).removeClass('fas fa-unlock').addClass('fas fa-lock')
    key = 0
  }
})

// EMAIL VALID
const email = document.querySelector("#email");
const icon = document.querySelector(".icon");
const icon1 = document.querySelector(".icon1");
const error = document.querySelector(".error-text");
const btn = document.querySelector("button");
let regExp = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
function check() {
  if (email.value.match(regExp)) {
    email.style.borderBottomColor = "#329996";
    icon.style.color = "#329996";
  } else {
    email.style.borderBottomColor = "#e74c3c";
    icon.style.color = "#e74c3c";
  }
  if (email.value == "") {
    email.style.removeProperty('border');
    icon.style.removeProperty('color');
    console.log('okkk');
  }
}

submitBtn.addEventListener("click", () => {
  if (createPw.value === confirmPw.value) {
    confirmPw.style.borderBottomColor = "#329996";
    iconlok.style.color = "#329996";
    iconeye.style.color = "#329996";
  } else {
    confirmPw.style.borderBottomColor = "#e74c3c";
    iconlok.style.color = "#e74c3c";
    iconeye.style.color = "#e74c3c";
  }
});