<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $this->renderSection('page_title', true) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  </head>
  <body>
<style>
    body {
        color: #757575;
    }
    .form-container {
      background-color: #E0E0E0;
      #border-radius: 10px;
      padding: 30px;
      max-width: 400px;
      width: 100%;
    }
    .navbar {
      background-color: #f7f7f7;
      #border-bottom: 1px solid #dee2e6;
    }
    .navbar-nav .nav-link {
      color: #000;
    }
    .form-control {
      border-radius: 0;
    }
    .btn-submit {
      border-radius: 20px;
      background-color: #fff;
      color: #757575;
      border: none;
    }
    #character-details a {
      color: #757575;
    }
    .btn-submit:hover {
      background-color: #fff;
    }
    .navbar-nav .nav-link {
        color: #757575;
        font-weight: bold;
        text-transform: uppercase;
    }
    .character-item {
      background-color: #E0E0E0;
      #border-radius: 10px;
    }
    .row {
      margin-left: 0 !important;
      margin-right: 0 !important;
    }
    .col {
      padding-left: 0 !important;
      padding-right: 0 !important;
    }
    .character-item {
        cursor: pointer;
    }
    .thank-you-container {
        #min-height: 100vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        background-color: #E0E0E0;
        padding: 20px;
    }
    .thank-you-icon {
        font-size: 60px;
        color: #6c757d;
        margin-bottom: 20px;
    }
    .thank-you-button {
        width: 150px;
        height: 40px;
        border-radius: 20px;
        background-color: #e9ecef;
        border: none;
        margin-top: 20px;
    }
    .thank-you-footer {
        margin-top: 40px;
        font-size: 14px;
        color: #6c757d;
    }
    .character-btn-action {
        background-color: #797979;
        color: #fff;
        padding: 8px 50px;
    }
    .rotate-left,
    .rotate-right {
        display: block;
        color: #797979;
    }
    .rotate-left {
        transform: rotate(-90deg);
    }
    .rotate-right {
        transform: rotate(90deg);
    }
    #page-number .btn.active {
        background-color: #797979;
        color: #fff;
    }
  </style>

    <?= $this->include('partials/navbar.php'); ?>
    <div class="container">
        <?php if (session()->get('is_logged_in')): ?>
            <p class="text-end my-2">Welcome, <?= esc(session()->get('firstName')) ?>!</p>
        <?php endif; ?>

    <!-- Display Error Messages -->
    <?php if (session()->get('errors')): ?>
        <ul class="w-50 mx-auto mt-3">
            <?php foreach (session()->get('errors') as $error => $value): ?>
                <?php if($error === 'verification_error'): ?>
                <div class="alert alert-danger" role="alert"><?= esc($value) ?>. Please check your email or <a href="/resend-verification?email=<?= old('email') ?>">resend verification.</a></div>
                <?php else: ?>
                    <div class="alert alert-danger" role="alert"><?= esc($value) ?></div>
                <?php endif; ?>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <!-- Display Flash Message -->
    <?php if (session()->getFlashdata('message')): ?>
        <div class="w-50 mx-auto mt-3 alert alert-success" role="alert"><?= esc(session()->getFlashdata('message')) ?></div>
    <?php endif; ?>

    <?= $this->renderSection('content') ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
