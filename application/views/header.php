<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $title ?></title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?= CSS ?>style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
</head>

<body>

  <nav class="navbar navbar-expand-lg bg-white shadow-sm">
    <div class="container">
      <a class="navbar-brand" href="<?=BASEURL?>"><img src="<?= IMG . 'logo.png' ?>" width="80" alt=""></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <?php if (isset($_SESSION['user'])): ?>
            <li class="nav-item"><a class="nav-link" href="<?=BASEURL?>">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="view-blacklist">View blacklist</a></li>
            <li class="nav-item"><a class="nav-link" href="add-blacklist">Add blacklist</a></li>
            <li class="nav-item"><a class="nav-link" href="logout">Logout</a></li>
          <?php else: ?>
            <li class="nav-item"><a class="nav-link" href="signin">Sign In</a></li>
            <li class="nav-item"><a class="nav-link" href="signup">Sign Up</a></li>
          <?php endif ?>
        </ul>
      </div>
    </div>
  </nav>