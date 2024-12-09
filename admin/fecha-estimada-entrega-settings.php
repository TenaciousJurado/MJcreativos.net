<?php
// Añadir un menú de configuración en el administrador
function fecha_estimada_entrega_menu() {
    add_menu_page(
        __('Fecha Estimada de Entrega', 'fecha-estimada-entrega'),
        __('Fecha Entrega', 'fecha-estimada-entrega'),
        'manage_options',
        'fecha-estimada-entrega',
        'fecha_estimada_entrega_settings_page',
        'dashicons-calendar-alt', // Dashicons relacionado con la fecha
        26
    );
}
add_action('admin_menu', 'fecha_estimada_entrega_menu');

// Página de configuración
function fecha_estimada_entrega_settings_page() {
    ?>
    <div class="wrap">
        <h1><?php _e('Configuración de Fecha Estimada de Entrega', 'fecha-estimada-entrega'); ?></h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('fecha_estimada_entrega_settings');
            do_settings_sections('fecha-estimada-entrega');
            submit_button();
            ?>
        </form>
        <hr>
        <h2><?php _e('Apoya el desarrollo del plugin', 'fecha-estimada-entrega'); ?></h2>
        <p><?php _e('Si encuentras útil este plugin, considera hacer una donación para apoyar su desarrollo continuo.', 'fecha-estimada-entrega'); ?></p>
        <form action="https://www.paypal.com/donate" method="post" target="_top">
            <input type="hidden" name="hosted_button_id" value="YLCXJTHQCZJ6L" />
            <input type="submit" value="<?php _e('Donar con PayPal', 'fecha-estimada-entrega'); ?>" class="button button-primary" />
        </form>
    </div>
    <?php
}

// Registrar ajustes
function fecha_estimada_entrega_settings_init() {
    register_setting('fecha_estimada_entrega_settings', 'fecha_estimada_entrega_options');

    add_settings_section(
        'fecha_estimada_entrega_settings_section',
        __('Configuración General', 'fecha-estimada-entrega'),
        'fecha_estimada_entrega_settings_section_cb',
        'fecha-estimada-entrega'
    );

    add_settings_field(
        'fecha_estimada_entrega_field_days',
        __('Días para la estimación de entrega', 'fecha-estimada-entrega'),
        'fecha_estimada_entrega_field_days_cb',
        'fecha-estimada-entrega',
        'fecha_estimada_entrega_settings_section'
    );

    add_settings_field(
        'fecha_estimada_entrega_field_emoji',
        __('Emoji para la estimación de entrega', 'fecha-estimada-entrega'),
        'fecha_estimada_entrega_field_emoji_cb',
        'fecha-estimada-entrega',
        'fecha_estimada_entrega_settings_section'
    );

    add_settings_field(
        'fecha_estimada_entrega_field_date_format',
        __('Formato de fecha', 'fecha-estimada-entrega'),
        'fecha_estimada_entrega_field_date_format_cb',
        'fecha-estimada-entrega',
        'fecha_estimada_entrega_settings_section'
    );
}
add_action('admin_init', 'fecha_estimada_entrega_settings_init');

// Callbacks para las secciones y campos
function fecha_estimada_entrega_settings_section_cb() {
    echo '<p>' . __('Este plugin calcula y muestra la fecha estimada de entrega para los pedidos realizados en tu tienda. Puedes configurar la cantidad de días para la estimación de entrega, el emoji que se mostrará junto con la fecha y el formato de la fecha. Ten en cuenta que el cálculo de la fecha de entrega solo considera los días laborales (de lunes a viernes), omitiendo fines de semana.', 'fecha-estimada-entrega') . '</p>';
}

function fecha_estimada_entrega_field_days_cb() {
    $options = get_option('fecha_estimada_entrega_options');
    ?>
    <input type="number" name="fecha_estimada_entrega_options[delivery_days]" value="<?php echo isset($options['delivery_days']) ? esc_attr($options['delivery_days']) : 2; ?>" min="1" max="30" />
    <p class="description"><?php _e('Ingrese la cantidad de días laborales para la estimación de entrega.', 'fecha-estimada-entrega'); ?></p>
    <?php
}

function fecha_estimada_entrega_field_emoji_cb() {
    $options = get_option('fecha_estimada_entrega_options');
    $selected_emoji = isset($options['delivery_emoji']) ? esc_attr($options['delivery_emoji']) : '📦';
    $emojis = ['📦', '🚚', '🛒', '📅', '🗓️', '🚀'];
    ?>
    <select name="fecha_estimada_entrega_options[delivery_emoji]">
        <?php foreach ($emojis as $emoji): ?>
            <option value="<?php echo esc_attr($emoji); ?>" <?php selected($selected_emoji, $emoji); ?>><?php echo esc_html($emoji); ?></option>
        <?php endforeach; ?>
    </select>
    <p class="description"><?php _e('Seleccione el emoji que se mostrará junto con la fecha estimada de entrega.', 'fecha-estimada-entrega'); ?></p>
    <?php
}

function fecha_estimada_entrega_field_date_format_cb() {
    $options = get_option('fecha_estimada_entrega_options');
    $date_format = isset($options['date_format']) ? esc_attr($options['date_format']) : 'l, d F Y';
    ?>
    <input type="text" name="fecha_estimada_entrega_options[date_format]" value="<?php echo $date_format; ?>" />
    <p class="description">
        <?php _e('Ingrese el formato de la fecha usando la sintaxis de PHP. Ejemplo: "l, d F Y". Para más información, visite', 'fecha-estimada-entrega'); ?>
        <a href="https://www.php.net/manual/es/function.date.php" target="_blank"><?php _e('la documentación oficial de formatos de fecha en PHP', 'fecha-estimada-entrega'); ?></a>.
    </p>
    <?php
}
