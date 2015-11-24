<div class="wrap">

    <?php
        $subpage = isset($_GET['subpage']) ? $_GET['subpage'] : false;
    ?>

    <h2 class="nav-tab-wrapper">
        <a class="nav-tab <?php if ($subpage == false) { echo 'nav-tab-active'; } ?>" href="<?php echo admin_url() ?>options-general.php?page=wpdevos_env">Dashboard</a>
        <a class="nav-tab <?php if ($subpage == 'environments') { echo 'nav-tab-active'; } ?>" href="<?php echo admin_url() ?>options-general.php?page=wpdevos_env&subpage=environments">Environments</a>
    </h2>

    <?php

        if ($subpage !== false) {

            if (file_exists(__DIR__.'/'.$subpage.'.php')) {
                include(__DIR__.'/'.$subpage.'.php');
            }

        } else {
            include 'dashboard.php';
        }

    ?>

</div>