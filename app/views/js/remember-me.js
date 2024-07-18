const checkRemember = document.getElementById("rememberme"),
      userInput = document.getElementById("userName");

// Cargar datos cuando se recarga la página
window.onload = function() {
    if (localStorage.checkbox && localStorage.checkbox !== "") {
        checkRemember.checked = true;
        userInput.value = localStorage.usernamePortafolio;
    } else {
        checkRemember.checked = false;
        userInput.value = "";
    }
};

// Función para validar el nombre de usuario
function isValidUsername(username) {
    // Permite solo letras, números y guiones bajos
    return /^[a-zA-Z0-9_]+$/.test(username);
}

// Función para manejar el inicio de sesión y almacenar datos
function lsRememberMe() {
    if (checkRemember.checked && userInput.value !== "" && isValidUsername(userInput.value)) {
        localStorage.usernamePortafolio = userInput.value;
        localStorage.checkbox = "checked";
    } else {
        localStorage.removeItem("usernamePortafolio");
        localStorage.removeItem("checkbox");
    }
}