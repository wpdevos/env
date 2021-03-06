<?php
/**
 * Podstawowa konfiguracja WordPressa.
 *
 * Skrypt wp-config.php używa tego pliku podczas instalacji.
 * Nie musisz dokonywać konfiguracji przy pomocy przeglądarki internetowej,
 * możesz też skopiować ten plik, nazwać kopię "wp-config.php"
 * i wpisać wartości ręcznie.
 *
 * Ten plik zawiera konfigurację:
 *
 * * ustawień MySQL-a,
 * * tajnych kluczy,
 * * prefiksu nazw tabel w bazie danych,
 * * ABSPATH.
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** Ustawienia MySQL-a - możesz uzyskać je od administratora Twojego serwera ** //
/** Nazwa bazy danych, której używać ma WordPress */
define('DB_NAME', 'dev_wp');

/** Nazwa użytkownika bazy danych MySQL */
define('DB_USER', 'dev_wp');

/** Hasło użytkownika bazy danych MySQL */
define('DB_PASSWORD', 'zaq12wsx');

/** Nazwa hosta serwera MySQL */
define('DB_HOST', 'localhost');

/** Kodowanie bazy danych używane do stworzenia tabel w bazie danych. */
define('DB_CHARSET', 'utf8mb4');

/** Typ porównań w bazie danych. Nie zmieniaj tego ustawienia, jeśli masz jakieś wątpliwości. */
define('DB_COLLATE', '');

/**#@+
 * Unikatowe klucze uwierzytelniania i sole.
 *
 * Zmień każdy klucz tak, aby był inną, unikatową frazą!
 * Możesz wygenerować klucze przy pomocy {@link https://api.wordpress.org/secret-key/1.1/salt/ serwisu generującego tajne klucze witryny WordPress.org}
 * Klucze te mogą zostać zmienione w dowolnej chwili, aby uczynić nieważnymi wszelkie istniejące ciasteczka. Uczynienie tego zmusi wszystkich użytkowników do ponownego zalogowania się.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'LMCc|Fty--TqegoHd-XAuDxHTWT~3@m!&ukg8vKq[k7Pfs3kmW#Z#/`DjcHdh7ab');
define('SECURE_AUTH_KEY',  'oxFm.>4ig7l|wv&b:B-,Q!o}-6/1R*,ALO53TIl,%B|i~zSq_I!`^|!/%V.;|I=A');
define('LOGGED_IN_KEY',    '_]5u85rw2J?5jdSZ>jy>;s5UyGaFeXV!=+EN[(^CU`5wR8!4J>^uTh&(XtVA4kpS');
define('NONCE_KEY',        'C2.AAw]|~VA/-jntLX$T}x49_|74-PE{xa-E+P2:zkrQqv<Q{+T$g)Z.?mhWVCbZ');
define('AUTH_SALT',        '|vY)j^W)A$.n2`_=Q!?In%5fJ#c|)vCo;MnzInMUQF_GF_ZdU`TKiFlPo<he=&.V');
define('SECURE_AUTH_SALT', 'twJc`V4hZQpLCIdc:uIw5kB2Zhor-+DqAJCQ(!+L.|,j:DN5n+O@(g-q$So>#^+:');
define('LOGGED_IN_SALT',   ']#@}t;,Qa)JhyX/cl%8zwU~+m?([+xyZfCUD)e7~sQv`clXhr?QK;Ao.naesB3=b');
define('NONCE_SALT',       'tF*vH)Y$Lwzil*Sx1,3X-7j$){v-:>=^SzNt|~c~&[g^S[%6;U7tZ-{,4i]3_2VB');

/**#@-*/

/**
 * Prefiks tabel WordPressa w bazie danych.
 *
 * Możesz posiadać kilka instalacji WordPressa w jednej bazie danych,
 * jeżeli nadasz każdej z nich unikalny prefiks.
 * Tylko cyfry, litery i znaki podkreślenia, proszę!
 */
$table_prefix  = 'wp_';

/**
 * Dla programistów: tryb debugowania WordPressa.
 *
 * Zmień wartość tej stałej na true, aby włączyć wyświetlanie
 * ostrzeżeń podczas modyfikowania kodu WordPressa.
 * Wielce zalecane jest, aby twórcy wtyczek oraz motywów używali
 * WP_DEBUG podczas pracy nad nimi.
 *
 * Aby uzyskać informacje o innych stałych, które mogą zostać użyte
 * do debugowania, przejdź na stronę Kodeksu WordPressa.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', 1);

/* To wszystko, zakończ edycję w tym miejscu! Miłego blogowania! */

/** Absolutna ścieżka do katalogu WordPressa. */
if ( !defined('ABSPATH') )
    define('ABSPATH', dirname(__FILE__) . '/');

/** Ustawia zmienne WordPressa i dołączane pliki. */
require_once(ABSPATH . 'wp-settings.php');

