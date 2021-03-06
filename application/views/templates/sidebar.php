<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('home') ?>">
    <div class="sidebar-brand-icon">
      <img src="<?= base_url('assets/') ?>img/tbc-logo.jpg" class="rounded-circle img-fluid" style="width: 50px;" />
    </div>
    <div class="sidebar-brand-text mx-3">The Babelian Channel</div>
  </a>

  <hr class="sidebar-divider">

  <!-- Query menu -->
  <?php
  $role_id = $user['role_id'];
  $queryMenu = "SELECT `user_menu`.`id`, `menu`
                  FROM `user_menu` JOIN `user_access_menu`
                    ON `user_menu`.`id` = `user_access_menu`.`menu_id`
                 WHERE `user_access_menu`.`role_id` = $role_id
              ORDER BY `user_access_menu`.`menu_id` ASC
              ";
  $menu = $this->db->query($queryMenu)->result_array();
  ?>

  <!-- Looping menu -->
  <?php foreach ($menu as $m) : ?>
    <div class="sidebar-heading">
      <?= $m['menu'] ?>
    </div>

    <!-- submenu sesuai menu -->
    <?php
    $menuId = $m['id'];
    $querySubMenu = "SELECT * 
                     FROM `user_sub_menu`
                    WHERE `menu_id` = $menuId
                      AND `is_active` = 1
                    ";
    $subMenu = $this->db->query($querySubMenu)->result_array();
    ?>
    <?php foreach ($subMenu as $sm) : ?>
      <?php if ($title == $sm['title']) : ?>
        <li class="nav-item active">
        <?php else : ?>
        <li class="nav-item">
        <?php endif; ?>
        <a class="nav-link pb-0" href="<?= base_url($sm['url']) ?>">
          <i class="<?= $sm['icon'] ?>"></i>
          <span><?= $sm['title'] ?></span></a>
        </li>
      <?php endforeach; ?>

      <hr class="sidebar-divider mt-3">

    <?php endforeach; ?>

    <li class="nav-item">
      <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
        <i class="fas fa-fw fa-sign-out-alt"></i>
        <span>Log Out</span></a>
    </li>

    <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>