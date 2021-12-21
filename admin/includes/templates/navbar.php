<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
  <a class="navbar-brand" href="dashboard.php"><?php echo lang('HOME_ADMIN') ?></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">

      <li class="nav-item">
        <a class="nav-link" aria-current="page" href="categories.php"><?php echo lang('CATEGORIES') ?></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" aria-current="page" href="items.php"><?php echo lang('ITEMS') ?></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" aria-current="page" href="members.php"><?php echo lang('MEMBERS') ?></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" aria-current="page" href="comments.php"><?php echo lang('COMMENTS') ?></a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          mohmmad
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="../index.php"><?php echo lang('VISIT_SHOP') ?></a>
          <a class="dropdown-item" href="members.php?do=Edit&userid=<?php echo $_SESSION['ID'] ?>"><?php echo lang('EDIT_PROFILE') ?></a>
          <a class="dropdown-item" href="#"><?php echo lang('SETTINGS') ?></a>
          <a class="dropdown-item" href="logout.php"><?php echo lang('LOGOUT') ?></a>
        </div>
      </li>
    </ul>
  </div>
</div>
</nav>
