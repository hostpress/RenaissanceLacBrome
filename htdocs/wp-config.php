<?php
/**
 * La configuration de base de votre installation WordPress.
 *
 * Ce fichier contient les réglages de configuration suivants : réglages MySQL,
 * préfixe de table, clefs secrètes, langue utilisée, et ABSPATH.
 * Vous pouvez en savoir plus à leur sujet en allant sur 
 * {@link http://codex.wordpress.org/Editing_wp-config.php Modifier
 * wp-config.php} (en anglais). C'est votre hébergeur qui doit vous donner vos
 * codes MySQL.
 *
 * Ce fichier est utilisé par le script de création de wp-config.php pendant
 * le processus d'installation. Vous n'avez pas à utiliser le site web, vous
 * pouvez simplement renommer ce fichier en "wp-config.php" et remplir les
 * valeurs.
 *
 * @package WordPress
 */

// ** Réglages MySQL - Votre hébergeur doit vous fournir ces informations. ** //
/** Nom de la base de données de WordPress. */
define('DB_NAME', 'renaissa_ncelb01');

/** Utilisateur de la base de données MySQL. */
define('DB_USER', 'renaissa_labrome');

/** Mot de passe de la base de données MySQL. */
define('DB_PASSWORD', 'S.2dO!X8{7JL');

/** Adresse de l'hébergement MySQL. */
define('DB_HOST', 'localhost');

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define('DB_CHARSET', 'utf8');

/** Type de collation de la base de données. 
  * N'y touchez que si vous savez ce que vous faites. 
  */
define('DB_COLLATE', '');

/**#@+
 * Clefs uniques d'authentification et salage.
 *
 * Remplacez les valeurs par défaut par des phrases uniques !
 * Vous pouvez générer des phrases aléatoires en utilisant 
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clefs secrètes de WordPress.org}.
 * Vous pouvez modifier ces phrases à n'importe quel moment, afin d'invalider tous les cookies existants.
 * Cela forcera également tous les utilisateurs à se reconnecter.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'plW`{M;+nS%O3^IJ w16PgFe~H%x3/8+l+<;FP;}oxPerHyMh)|3Sd2lzMJ(YDe.');
define('SECURE_AUTH_KEY',  'Arqc7[cJ(UwjJWMJ+=frjOMA9S,_09PtbWAc1::C(#/c^VbS?8K5LM|W`kfID}R2');
define('LOGGED_IN_KEY',    'Rz?IpmN]l^y/ +j(m+@+!59@_h~$/bN:Ij.h+,yq|Sv+4oQhLJ|JUxAO81o]m)9N');
define('NONCE_KEY',        'p5^wxNu^NH!UGmGJy+<kZ_#el5?Nqt{XZtw^#j&4Wq&%^3|9F4OUpX:*y_y{6:Z|');
define('AUTH_SALT',        '/r;~(M`f5@/aem3tHsVR>`b+jv?LQ4q,j<rw:CW&^U|SQ)xjYxvRp0{#;,0W3u+y');
define('SECURE_AUTH_SALT', '%2sE]c6sOjPL*Ik8L0yzI@zc`rtX;Nd MTDAf*cJ$esi!M#Ft2}NJ]|V,F6e~p($');
define('LOGGED_IN_SALT',   ':C3,3}FK|XQI,b4}HgK%v{pemd@P{R#D2@~m$F&abUj)6|O%H;} 8CKr^Bq:LgLd');
define('NONCE_SALT',       ':fcoGDdH)dNo!h,lj[<qV!_D9.@j :`R0wUx0x(,xs1^`:y#|=aw:*5dE$e r=v@');

/**#@-*/

/**
 * Préfixe de base de données pour les tables de WordPress.
 *
 * Vous pouvez installer plusieurs WordPress sur une seule base de données
 * si vous leur donnez chacune un préfixe unique. 
 * N'utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés!
 */
$table_prefix  = 'rlb_';

define('WP_SITEURL', 'http://renaissancelbl.com');
define('WP_HOME', 'http://renaissancelbl.com');

/**
 * Langue de localisation de WordPress, par défaut en Anglais.
 *
 * Modifiez cette valeur pour localiser WordPress. Un fichier MO correspondant
 * au langage choisi doit être installé dans le dossier wp-content/languages.
 * Par exemple, pour mettre en place une traduction française, mettez le fichier
 * fr_FR.mo dans wp-content/languages, et réglez l'option ci-dessous à "fr_FR".
 */
define('WPLANG', 'fr_FR');

/** 
 * Pour les développeurs : le mode deboguage de WordPress.
 * 
 * En passant la valeur suivante à "true", vous activez l'affichage des
 * notifications d'erreurs pendant votre essais.
 * Il est fortemment recommandé que les développeurs d'extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de 
 * développement.
 */ 
define('WP_DEBUG', true); 
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);
define('WP_POST_REVISIONS', 3);
/* Disable evil background wp-cron */
define('DISABLE_WP_CRON', false);

/* C'est tout, ne touchez pas à ce qui suit ! Bon blogging ! */

/** Chemin absolu vers le dossier de WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once(ABSPATH . 'wp-settings.php');