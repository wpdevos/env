<h1>Environments settings</h1>

<?php if ($hasConfiguration) { ?>

    <?php if (!defined('WP_ENV')) { ?>

        <div class="update-nag notice"><p>Posiadasz skonfigurowane środowiska, możesz teraz zamienić plik wp-config.php</p></div>

    <?php } ?>

    <div>
        <button data-admin-action="add_env" class="button button-primary">Add environment</button>
        <button data-admin-action="sys_replace_wpconfig" class="button button-secondary">Replace wp-config.php</button>
    </div>
<?php } else { ?>
    <div class="update-nag notice">
        <p><?php _e( 'Środowiska nie zostały jeszcze zainicjalizowane. Zalecamy wykonać backup bazy danych i plików konfiguracyjnych przed kontynuacją.', 'wpdevos_env' ); ?></p>
        <p><?php _e( 'Skonfiguruj środowiska przy użyciu poniższego formularza.', 'wpdevos_env' ); ?></p>
    </div>
<?php } ?>

<?php

if (!defined('WP_ENV')) {
    echo '';
}


//    foreach (glob(ABSPATH . '.wpdenv.*') as $path) {
//
//        var_dump($path);
//        var_dump(basename($path));
//    }
//
//    die;

?>

<form method="post" class="save_env_boxes">

    <div style="clear: both; display: block;">
        <?php

        foreach ($settings['envs'] as $envKey => $envOptions) {

            echo '<div class="env_box" style="background: #fff; width: 33%; float: left; margin: 0 10px 10px 0; padding: 20px 30px;">';

            echo '<input class="env_name" type="text" value="' . $envKey . '" '.( !defined('WP_ENV') && $envKey == 'default' ? 'disabled="disabled"' : '' ).' />';

            if ($envKey == 'default') {

                $siteUrl = parse_url(get_option('siteurl'));

                $currentConfigJson = '{';
                $currentConfigJson .= '"db_name":"'.constant('DB_NAME').'",';
                $currentConfigJson .= '"db_user":"'.constant('DB_USER').'",';
                $currentConfigJson .= '"db_password":"'.constant('DB_PASSWORD').'",';
                $currentConfigJson .= '"db_host":"'.constant('DB_HOST').'",';
                $currentConfigJson .= '"db_charset":"'.constant('DB_CHARSET').'",';
                $currentConfigJson .= '"db_collate":"'.constant('DB_COLLATE').'",';
                $currentConfigJson .= '"wp_debug":"'.constant('WP_DEBUG').'",';
                $currentConfigJson .= '"site_url":"'.$siteUrl['host'].'",';
                $currentConfigJson .= '"site_protocol":"'.$siteUrl['scheme'].'"';
                $currentConfigJson .= '}';

                if (!$hasConfiguration) {
                    echo '<span class="delete_on_clone"><a href="" data-admin-action="add_fill_form_old_config" data-current-config=\'' . $currentConfigJson . '\'>Wypełnij danymi z aktualnego pliku wp-config.php</a></span>';
                }
            }

            echo '<table class="form-table"><tbody>';

            foreach ($envOptions as $groupKey => $groupOptions) {

                foreach ($groupOptions as $optionKey => $optionValue) {

                    echo '<tr>';
                    echo '<th scope="row">';
                    echo '<label for="'.$envKey.'_'.$groupKey . '_' . $optionKey.'">' . $groupKey . ' / ' . $optionKey . '</label>';
                    echo '</th>';

                    echo '<td>';
                    echo '<input id="'.$envKey.'_'.$groupKey . '_' . $optionKey.'" class="" type="text" name="wpdevos_env_settings['.$envKey.'][' . $groupKey . '][' . $optionKey . ']" value="' . $optionValue . '" />';
                    echo '</td>';
                    echo '</tr>';

                }
            }

            echo '</tbody></table>';
            echo '</div>';
        }

        ?>

    </div>

    <p class="submit">
        <input type="submit" value="Save" class="button button-primary">
    </p>

</form>