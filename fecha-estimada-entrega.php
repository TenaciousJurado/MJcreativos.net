<?php
/*
Plugin Name: Fecha Estimada de Entrega
Description: Muestra la fecha estimada de llegada del pedido en la página del producto.
Version: 1.0
Author: MJCcreativos.net
Text Domain: fecha-estimada-entrega
Domain Path: /languages
*/

if (!defined('ABSPATH')) {
    exit; // Salir si se accede directamente.
}

// Cargar archivos necesarios
include_once(plugin_dir_path(__FILE__) . 'includes/fecha-estimada-entrega-functions.php');
include_once(plugin_dir_path(__FILE__) . 'admin/fecha-estimada-entrega-settings.php');

// Registrar la función de activación del plugin
register_activation_hook(__FILE__, 'fecha_estimada_entrega_activate');
function fecha_estimada_entrega_activate() {
    // Código de activación
}

// Registrar la función de desactivación del plugin
register_deactivation_hook(__FILE__, 'fecha_estimada_entrega_deactivate');
function fecha_estimada_entrega_deactivate() {
    // Código de desactivación
}

// Cargar text domain para internacionalización
function fecha_estimada_entrega_load_textdomain() {
    load_plugin_textdomain('fecha-estimada-entrega', false, dirname(plugin_basename(__FILE__)) . '/languages');
}
add_action('plugins_loaded', 'fecha_estimada_entrega_load_textdomain');