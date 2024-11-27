<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $this->renderSection('page_title', true) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
  </style>

    <?= $this->include('partials/navbar.php'); ?>
    <div class="container">
    <?= $this->renderSection('content') ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
