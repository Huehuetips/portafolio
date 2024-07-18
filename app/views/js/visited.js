// Esta implementación utiliza sessionStorage, que es completamente independiente de las cookies.
window.onload = function() {
    sessionStorage.setItem("isReloading", "true");
    if (!sessionStorage.getItem("visited")) {
        sessionStorage.setItem("visited", "true");
        const visitTime = new Date().toISOString();
        sessionStorage.setItem("visitTime", visitTime);
        console.log("Visitante registrado con fecha:", visitTime);
    }
};

window.onbeforeunload = function() {
    if (sessionStorage.getItem("isReloading") === "true") {
        sessionStorage.setItem("isReloading", "false");
    } else {
        sessionStorage.removeItem("visited");
        console.log("Clave 'visited' eliminada del sessionStorage al cerrar la pestaña.");
    }
};

window.addEventListener("pagehide", function(event) {
    // Solo elimina el item si la página no se está almacenando en el caché
    if (!event.persisted) {
        sessionStorage.removeItem("isReloading");
    }
});