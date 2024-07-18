document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.text-container').forEach(function(container) {
        const textElement = container.querySelector('.text');
        const moreLink = container.querySelector('.more-link');
        const fullText = textElement.getAttribute('data-fulltext');
        const maxLength = 300;  // Define la longitud máxima del texto visible inicialmente

        // Función para inicializar el texto
        function initializeText() {
            if (fullText.length > maxLength) {
                textElement.innerHTML  = fullText.substring(0, maxLength) + "...";
                moreLink.innerHTML  = "Ver más";
                moreLink.style.display = "";  // Asegúrate de que el enlace es visible
            } else {
                moreLink.style.display = "none";  // Oculta el enlace si el texto no es lo suficientemente largo
            }
        }

        // Llamada inicial para configurar el texto y el enlace
        initializeText();

        // Evento click para expandir/colapsar el texto
        moreLink.addEventListener('click', function(event) {
            event.preventDefault(); // Evita que el enlace haga scroll hacia arriba
            if (textElement.innerHTML .includes("...")) {
                textElement.innerHTML  = fullText;  // Muestra todo el texto
                moreLink.innerHTML  = "Ver menos";
            } else {
                textElement.innerHTML  = fullText.substring(0, maxLength) + "...";  // Vuelve a recortar el texto
                moreLink.innerHTML  = "Ver más";
            }
        });
    });
});