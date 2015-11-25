<?php

switch ($hostname) {

    case 'wp.dev': define('WP_ENV', 'default'); break;
    case 'aaa.ddd': define('WP_ENV', 'test'); break;
    case '': define('WP_ENV', 'draft'); break;
    //ENVREPLACE

}
