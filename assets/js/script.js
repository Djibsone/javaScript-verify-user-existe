/*const eye = document.querySelector(".fa-eye");
const eyeslash = document.querySelector(".fa-eye-slash");
const passwordField = document.querySelector("input[type=password]");

eye.addEventListener("click", () => {
  eyeslash.style.display = "block";
  eye.style.display = "none";
  passwordField.type = "password";
});

eyeslash.addEventListener("click", () => {
  eye.style.display = "block";
  eyeslash.style.display = "none";
  passwordField.type = "text";
});*/


const eye = document.querySelectorAll(".fa-eye");
const eyeslash = document.querySelectorAll(".fa-eye-slash");
const passwordFields = document.querySelectorAll("input[type=password]");

eye.forEach((item, index) => {
  item.addEventListener("click", () => {
    eyeslash[index].style.display = "block";
    item.style.display = "none";
    passwordFields[index].type = "password";
  });
});

eyeslash.forEach((item, index) => {
  item.addEventListener("click", () => {
    item.style.display = "none";
    eye[index].style.display = "block";
    passwordFields[index].type = "text";
  });
});

const msgError = document.querySelector('.error');
const errorpassword = document.querySelector('.errorpassword');
// append
$(document).ready( () => {
  
  $('#email').on('input', function() {
    let email = $(this).val();

      $.ajax({
          url: './controllers/search.php',
          type: 'post',
          data: { email:email },
          dataType: 'json',
          success: function(data) {
            if (data.length > 0) {
              msgError.style.visibility = "visible";
              msgError.textContent = "Utilisateur existe déjà.";
              msgError.style.color = "red";
            } else {

              if (email.length > 0) {
                msgError.style.visibility = "visible";
                msgError.textContent = "Nouvel utilisateur.";
                msgError.style.color = "green";
              } else {
                msgError.style.visibility = "hidden"
              }
              
            }
          }
      });  
  });

  //password verify 8 caracteres au moins
  $('#password').on('input', function() {
    let password = $(this).val();

    if (password.length < 8) {
      errorpassword.style.visibility = "visible";
      errorpassword.textContent = "Le mot de passe doit contenir au moins 8 caractères.";
      errorpassword.style.color = "red";
    } else {
      if (password === 0) {
        errorpassword.style.visibility = "hidden";
        errorpassword.style.visibility = "visible";
        errorpassword.textContent = "Mot de passe valide.";
        errorpassword.style.color = "green";
      } else {
        errorpassword.style.visibility = "hidden";
      }
      
    }
  }); 

});