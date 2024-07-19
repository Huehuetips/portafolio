
<section id="contact" class="py-5 p-3 mt-5 bg-secondary">
    <div class="container text-center mb-3">
        <h2>Contacto</h2>
        <div class="" role="group">
            <a href="https://linkedin.com/in/adonyMontejo" target="_blank" class="btn btn-ellipse"> <span class="text-primary"><i class="bi bi-linkedin"></i></span> Linkedin</a>
            <a href="mailto:contact@emontejodev.com" target="_blank" class="btn btn-ellipse"> <span class="text-warning"><i class="bi bi-envelope-at"></i></span> Gmail</a>
            <a href="https://wa.me/50259692780" target="_blank" class="btn btn-ellipse"> <span class="text-success"><i class="bi bi-whatsapp"></i></span> Whatsapp</a>
            <a href="https://github.com/Huehuetips" target="_blank" class="btn btn-ellipse"> <span><i class="bi bi-github"></i></span> GitHub</a>
            <a href="https://es.stackoverflow.com/users/303939/adony-montejo" target="_blank" class="btn btn-ellipse"> <span class="text-danger"><i class="bi bi-stack-overflow"></i></span> Stack Overflow</a>
            <a href="https://codepen.io/adony-montejo" target="_blank" class="btn btn-ellipse"> <span class=""><i class="bi bi-code-slash"></i></span> CodePen</a>
        </div>
    </div>
    <div class="container">
        
        <h4>Envía un mensaje directo</h4>
        <form class="Loading" action="<?php echo APP_URL; ?>app/ajax/contactAjax.php" method="POST" autocomplete="off" enctype="multipart/form-data">
            <input type="text" id="con" name="con" value="con" required hidden>
            <div class="form-group">
                <label for="email" class="is-required">Correo Electrónico:</label>
                <input type="email" class="form-control is-required" id="email" name="email" pattern="[a-zA-Z0-9@.]{7,50}" minlength="3" maxlength="50"  required autocomplete="off">
            </div>
            <div class="form-group mt-3">
                <label for="message" class="is-required">Mensaje:</label>
                <textarea class="form-control is-required" id="message" pattern=".{15,500}" name="message" minlength="15" maxlength="500" rows="4" required></textarea>
            </div>
            <div id="divAlert" class="mt-2"></div>
            <button type="submit" class="btn btn-primary mt-3">Enviar</button>
        </form>
    </div>
</section>
