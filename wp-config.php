<?php
/**
 * As configurações básicas do WordPress
 *
 * O script de criação wp-config.php usa esse arquivo durante a instalação.
 * Você não precisa usar o site, você pode copiar este arquivo
 * para "wp-config.php" e preencher os valores.
 *
 * Este arquivo contém as seguintes configurações:
 *
 * * Configurações do MySQL
 * * Chaves secretas
 * * Prefixo do banco de dados
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Configurações do MySQL - Você pode pegar estas informações com o serviço de hospedagem ** //
/** O nome do banco de dados do WordPress */
define( 'DB_NAME', 'desafiom_wp' );

/** Usuário do banco de dados MySQL */
define( 'DB_USER', 'desafiom_wp' );

/** Senha do banco de dados MySQL */
define( 'DB_PASSWORD', 'ehxG4YFCRvPWq8S' );

/** Nome do host do MySQL */
define( 'DB_HOST', 'localhost' );

/** Charset do banco de dados a ser usado na criação das tabelas. */
define( 'DB_CHARSET', 'utf8mb4' );

/** O tipo de Collate do banco de dados. Não altere isso se tiver dúvidas. */
define( 'DB_COLLATE', '' );

/**#@+
 * Chaves únicas de autenticação e salts.
 *
 * Altere cada chave para um frase única!
 * Você pode gerá-las
 * usando o {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org
 * secret-key service}
 * Você pode alterá-las a qualquer momento para invalidar quaisquer
 * cookies existentes. Isto irá forçar todos os
 * usuários a fazerem login novamente.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         ' isA,5>?jw.wlGyVr0p/x<IVBgJ79`#Z}OR7oIp<|C:jb|p0Y|dLSSIBwH5*DvYS' );
define( 'SECURE_AUTH_KEY',  'Q}%S[s}_B#RsCVHa8ENt=DFzSqx/>LV71&6F>~kSUVX1pUH&3~CjD[AUrM|NE#5_' );
define( 'LOGGED_IN_KEY',    '(3Qiy[ZwdmZ;0ar1&x)Bi{T0jqWJ1b#d#1c&!=xJ{[b!^,g:O$K[}Kbs;tZH7Hx*' );
define( 'NONCE_KEY',        'yg#VgW7U8?t$XFBGn~O$d!yY-_6U_HpLM-<<|&TP??p4>|0gE=,?H)/E+xMa ZYL' );
define( 'AUTH_SALT',        'F+I$0PL7c;FEP0{Eu`l~*f~lvvc|%^f;*ke?*)|V<jnmdUkL8w?=Eq;+1Sirfq`+' );
define( 'SECURE_AUTH_SALT', '|e<NTH=C}fpr4D+F4~:wE.DM;%|_]Y9F}nA3nsYU4gqb/Rd|[v#XQE A@[c}&7r2' );
define( 'LOGGED_IN_SALT',   '!sjlN3^6Bvl/vpl]!jVL<F@3r$jfP$|1<C L;Y=r~Xv/hAYV>z]khUzv8&g5iP8P' );
define( 'NONCE_SALT',       '}A?6jq BgNx.}UxETg~GnESr_aJrzJ{u7D6tdorJcnL;yemDJy+s^5^Dti! +:3/' );

/**#@-*/

/**
 * Prefixo da tabela do banco de dados do WordPress.
 *
 * Você pode ter várias instalações em um único banco de dados se você der
 * um prefixo único para cada um. Somente números, letras e sublinhados!
 */
$table_prefix = 'wp_';

/**
 * Para desenvolvedores: Modo de debug do WordPress.
 *
 * Altere isto para true para ativar a exibição de avisos
 * durante o desenvolvimento. É altamente recomendável que os
 * desenvolvedores de plugins e temas usem o WP_DEBUG
 * em seus ambientes de desenvolvimento.
 *
 * Para informações sobre outras constantes que podem ser utilizadas
 * para depuração, visite o Codex.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Isto é tudo, pode parar de editar! :) */

/** Caminho absoluto para o diretório WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Configura as variáveis e arquivos do WordPress. */
require_once ABSPATH . 'wp-settings.php';
