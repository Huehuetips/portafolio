<main class="form-signin w-100 m-auto ">
  <form class="AjaxForm" action="<?php echo APP_URL; ?>app/ajax/loginAjax.php" method="POST">
    <img class="mb-4" src="<?php echo APP_LOGO; ?>" alt="" width="72" height="57">
    <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

    <input type="hidden" id="log" name="log" value="log">
    <div class="form-floating">
      <input type="text" class="form-control" maxlength="30" id="userName" name="userName" pattern="[a-zA-Z0-9]{7,30}" placeholder="Usuario" autocomplete="on" required>
      <label for="userName">Usuario</label>
    </div>
    <div class="form-floating">
      <input type="password" class="form-control" id="userPassword" name="userPassword" pattern="[a-zA-Z0-9]{8,100}" maxlength="100" autocomplete="off" placeholder="Password" required>
      <label for="userPassword">Password</label>
    </div>

    <div class="form-check text-start my-3">
      <input class="form-check-input" type="checkbox" value="remember-me" id="rememberme" >
      <label class="form-check-label" for="rememberme">
        Remember me
      </label>
    </div>
    <div id="divAlert"></div>
    <button class="btn btn-primary w-100 py-2" type="submit" onclick="lsRememberMe()">Sign in</button>
    <p class="mt-5 mb-3 text-body-secondary">&copy; 2017–2023</p>
  </form>
</main>
<script type="text/javascript" src="<?php echo APP_URL; ?>app/views/js/remember-me.js"></script>
