<?php
// Función para calcular la fecha estimada de entrega
function calcular_fecha_estimacion_entrega() {
    // Obtener la configuración
    $options = get_option('fecha_estimada_entrega_options');
    $dias_entrega = isset($options['delivery_days']) ? intval($options['delivery_days']) : 2;
    $emoji_entrega = isset($options['delivery_emoji']) ? esc_html($options['delivery_emoji']) : '📦';
    $formato_fecha = isset($options['date_format']) ? esc_html($options['date_format']) : 'l, d F Y';

    // Obtener la fecha actual
    $fecha_actual = current_time('timestamp');
    $dia_semana_actual = date('w', $fecha_actual);

    // Inicializar contadores
    $dias_contados = 0;
    $fecha_entrega = $fecha_actual;

    // Contar solo días laborales
    while ($dias_contados < $dias_entrega) {
        $fecha_entrega = strtotime('+1 day', $fecha_entrega);
        $dia_semana = date('w', $fecha_entrega);
        if ($dia_semana >= 1 && $dia_semana <= 5) {
            $dias_contados++;
        }
    }

    // Ajustar la fecha de entrega si cae en un fin de semana
    $dia_semana_entrega = date('w', $fecha_entrega);
    if ($dia_semana_entrega == 6) { // Sábado
        $fecha_entrega = strtotime('next Monday', $fecha_entrega);
    } elseif ($dia_semana_entrega == 0) { // Domingo
        $fecha_entrega = strtotime('next Monday', $fecha_entrega);
    }

    // Formatear la fecha de entrega con el formato proporcionado por el usuario
    $fecha_entrega_formateada = date_i18n($formato_fecha, $fecha_entrega);

    // Crear el HTML para la fecha de entrega con estilos y enlace a las condiciones del envío
    $html_fecha_entrega = '
        <p class="estimacion-entrega" style="color: #27AE60; font-weight: bold; font-size: 1.2em; text-align: center; padding: 10px; border: 2px dashed #27AE60; border-radius: 10px; background-color: #EAF2E3;">
            ' . $emoji_entrega . ' ' . __('Pide ahora y te llega el', 'fecha-estimada-entrega') . ' ' . esc_html($fecha_entrega_formateada) . '
        </p>
    ';

    // Devolver el HTML
    return $html_fecha_entrega;
}

// Función para el shortcode
function shortcode_fecha_estimacion_entrega() {
    return calcular_fecha_estimacion_entrega();
}

// Registrar el shortcode
add_shortcode('fecha_estimacion_entrega', 'shortcode_fecha_estimacion_entrega');
