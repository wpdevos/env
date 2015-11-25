<?php

class wpdevos
{
    public static function getDefaultSettings()
    {
        $default_env = array(
            'db' => array(
                'name' => '',
                'user' => '',
                'password' => '',
                'host' => '',
                'charset' => '',
                'collate' => ''
            ),
            'wp' => array(
                'debug' => ''
            ),
            'site' => array(
                'url' => '',
                'protocol' => '',
            )
        );

        return array(
            'envs' => array(
                'default' => $default_env
            )
        );
    }

    public static function makeConfigFiles()
    {
        global $wpdb;

        /**
         * LOAD FILES
         */

        $siteUrl = parse_url(get_option('siteurl'));

        $wpConfig = file_get_contents(__DIR__ . '/envs_skeletons/wp-config.php');
        $defaultConfig = file_get_contents(__DIR__ . '/envs_skeletons/wp-config.settings.php');
        $sampleConfig = file_get_contents(__DIR__ . '/envs_skeletons/.wpdenv.sample.php');
        $envConfig = file_get_contents(__DIR__ . '/envs_skeletons/.wpdenv.env.php');

        if (is_writeable(ABSPATH . 'wp-config.php') && !defined('WP_ENV')) {

            /**
             * REPLACE WP-CONFIG
             */
            if (!file_exists(ABSPATH . 'wp-config.backup.php')) {
                rename(ABSPATH . 'wp-config.php', ABSPATH . 'wp-config.backup.php');
            }

            file_put_contents(ABSPATH . 'wp-config.php', $wpConfig);

            /**
             * DEFAULT
             */

            $newKeys = '';

            $keys = array('AUTH_KEY', 'SECURE_AUTH_KEY', 'LOGGED_IN_KEY', 'NONCE_KEY', 'AUTH_SALT', 'SECURE_AUTH_SALT', 'LOGGED_IN_SALT', 'NONCE_SALT');

            foreach ($keys as $key) {
                $newKeys .= "define('$key', '".constant($key)."');" . PHP_EOL;
            }

            $defaultConfig = preg_replace('/_WP_DEVOS_CONSTANTS_/', $newKeys, $defaultConfig);
            $defaultConfig = preg_replace('/_WP_DEVOS_TABLE_PREFIX_/', $wpdb->prefix, $defaultConfig);
            file_put_contents(ABSPATH . 'wp-config.settings.php', $defaultConfig);

            /**
             * DEV
             */

            $dbKeys = array('DB_USER', 'DB_PASSWORD', 'DB_NAME', 'DB_HOST', 'DB_COLLATE', 'DB_CHARSET');

            $settings = get_option('wpdevos_env_settings', false);

            if (isset($settings['envs']) && is_array($settings['envs'])) {

                //TODO
                foreach ($dbKeys as $key) {
                    $sampleConfig = preg_replace("/REPLACE_$key/", constant($key), $sampleConfig);
                }

                file_put_contents(ABSPATH . '.wpdenv.dev.php', $sampleConfig);

            } else {

                file_put_contents(ABSPATH . '.wpdenv.dev.php', $sampleConfig);

                /**
                 * ENV
                 */

                $envConfig = preg_replace('@//ENVREPLACE@', "case '".$siteUrl['host']."': define('WP_ENV', 'dev'); break;" . PHP_EOL . '//ENVREPLACE', $envConfig);
                file_put_contents(ABSPATH . '.wpdenv.env.php', $envConfig);
            }
        }

        if (defined('WP_ENV')) {

            $settings = get_option('wpdevos_env_settings', false);

            if ($settings !== false) {
                $settings = unserialize($settings);
            }

            if (isset($settings['envs']) && is_array($settings['envs'])) {

                $envConfig = file_get_contents(__DIR__ . '/envs_skeletons/.wpdenv.env.php');

                $i = 0;
                foreach ($settings['envs'] as $envCode => $envOptions) {

                    $envConfigItem = $sampleConfig;

                    foreach ($envOptions as $envOptionsKey1 => $envOptionsValue1) {

                        foreach ($envOptionsValue1 as $envOptionsKey2 => $envOptionsValue2) {
                            $key = strtoupper($envOptionsKey1) . '_' . strtoupper($envOptionsKey2);
                            $envConfigItem = preg_replace("/REPLACE_$key/", $envOptionsValue2, $envConfigItem);

                        }

                    }

                    file_put_contents(ABSPATH . '.wpdenv.' . $envCode . '.php', $envConfigItem);

                    //env add

                    if ($i > 0) {
                        $envConfig = file_get_contents(ABSPATH . '.wpdenv.env.php');
                    }

                    if (strlen($envCode)) {
                        $envConfig = preg_replace('@//ENVREPLACE@', "case '" . $envOptions['site']['url'] . "': define('WP_ENV', '" . $envCode . "'); break;" . PHP_EOL . '//ENVREPLACE', $envConfig);
                        file_put_contents(ABSPATH . '.wpdenv.env.php', $envConfig);
                    }

                    $i++;
                }

            } else {

                file_put_contents(ABSPATH . '.wpdenv.dev.php', $sampleConfig);

                /**
                 * ENV
                 */

                $envConfig = preg_replace('@//ENVREPLACE@', "case '".$siteUrl['host']."': define('WP_ENV', 'dev'); break;" . PHP_EOL . PHP_, $envConfig);
                file_put_contents(ABSPATH . '.wpdenv.env.php', $envConfig);
            }

        }
    }
}