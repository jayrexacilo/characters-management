  <!-- Navbar -->
<!-- <?= uri_string(); ?> -->
  <nav class="navbar navbar-expand-lg">
    <div class="container">
      <a class="navbar-brand" href="#">
        <img src="https://placehold.co/120x40?text=Hello+World" alt="Logo" width="120" height="40" class="d-inline-block align-text-top">
      </a>
      <ul class="navbar-nav ms-auto">
        <?php if(uri_string() == "login" || !session()->get('is_logged_in')) { ?>
            <li class="nav-item me-4">
                <a class="nav-link" href="<?= route_to('AuthController::signup') ?>">Sign Up</a>
            </li>
        <?php } ?>
        <?php if(uri_string() == "sign-up" || !session()->get('is_logged_in')) { ?>
            <li class="nav-item me-4">
                <a class="nav-link" href="<?= route_to('AuthController::login') ?>">Log In</a>
            </li>
        <?php } ?>
        <?php if (session()->get('is_logged_in')): ?>
            <li class="nav-item me-4">
              <a class="nav-link" href="<?= route_to('Character::index') ?>">List Characters</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?= route_to('Character::savedCharacters') ?>">Saved Characters</a>
            </li>

            <?php if (session()->get('is_logged_in')): ?>
                <li class="nav-item">
                  <a class="nav-link" href="<?= route_to('AuthController::logout') ?>">Log Out</a>
                </li>
            <?php endif; ?>
        <?php endif; ?>

      </ul>
    </div>
  </nav>
<!--<nav class="navbar bg-body-tertiary">
  <div class="container">
    <a class="navbar-brand" href="#">
      <img src="https://placehold.co/120x40" alt="Bootstrap" width="120" height="40">
    </a>
		<ul class="nav justify-content-end">
      <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="#">Sign Up</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">List Characters</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Saved Characters</a>
      </li>
    </ul>
  </div>
</nav>-->
