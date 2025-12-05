<?php
// Exit if accessed directly.
defined('ABSPATH') || exit;

/**
 * SVG upload – tylko dla administratorów + fix MIME + podgląd w mediach
 */

// 1) Dopuść SVG/SVGZ w uploaderze
add_filter(
    'upload_mimes',
    function ($mimes) {
        //    if (current_user_can('manage_options')) {
        $mimes['svg'] = 'image/svg+xml';
        $mimes['svgz'] = 'image/svg+xml';
        //    }
        return $mimes;
    }
);

// 2) Naprawa sprawdzania typu pliku (starsze WP czasem widzi SVG jako text/plain)
add_filter(
    'wp_check_filetype_and_ext',
    function ($data, $file, $filename, $mimes, $real_mime = null) {
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        if ('svg' === $ext || 'svgz' === $ext) {
            $data['ext'] = 'svg';
            $data['type'] = 'image/svg+xml';
        }
        return $data;
    },
    10,
    5
);

// 3) Lepszy podgląd SVG w bibliotece (wymiary z width/height lub viewBox)
add_filter(
    'wp_prepare_attachment_for_js',
    function ($response, $attachment, $meta) {
        if (isset($response['mime']) && 'image/svg+xml' === $response['mime']) {
            $file = get_attached_file($attachment->ID);
            $width = 0;
            $height = 0;
            if (is_readable($file)) {
                // Próbujemy wyczytać width/height lub viewBox z pliku
                $svg = @simplexml_load_file($file);
                if (false !== $svg) {
                    $attrs = $svg->attributes();
                    if (!empty($attrs->width) && !empty($attrs->height)) {
                        $width = (int)preg_replace('/[^0-9.]/', '', (string)$attrs->width);
                        $height = (int)preg_replace('/[^0-9.]/', '', (string)$attrs->height);
                    } elseif (!empty($attrs->viewBox)) {
                        $vb = preg_split('/\s+/', (string)$attrs->viewBox);
                        if (4 === count($vb)) {
                            $width = (int)round((float)$vb[2]);
                            $height = (int)round((float)$vb[3]);
                        }
                    }
                }
            }

            // Uzupełnij sizes, żeby WordPress miał sensowny podgląd
            $response['sizes'] = array(
                'full' => array(
                    'url' => $response['url'],
                    'width' => $width ?: 512,
                    'height' => $height ?: 512,
                    'orientation' => ($height > $width) ? 'portrait' : 'landscape',
                ),
            );
        }
        return $response;
    },
    10,
    3
);

// (Opcjonalnie) 4) Zaostrzenie sanitizacji treści SVG przy wklejaniu do edytora
// WordPress i tak filtruje skrypty, ale można jawnie wskazać dozwolone atrybuty:
add_filter(
    'wp_kses_allowed_html',
    function ($tags, $context) {
        if ('post' === $context) {
            $tags['svg'] = array(
                'class' => true,
                'xmlns' => true,
                'viewBox' => true,
                'width' => true,
                'height' => true,
                'fill' => true,
                'stroke' => true,
                'stroke-width' => true,
                'role' => true,
                'aria-hidden' => true,
                'focusable' => true,
                'style' => true,
            );
            $tags['g'] = array(
                'class' => true,
                'fill' => true,
                'stroke' => true,
                'transform' => true,
                'style' => true,
            );
            $tags['path'] = array(
                'class' => true,
                'd' => true,
                'fill' => true,
                'stroke' => true,
                'stroke-width' => true,
                'transform' => true,
                'style' => true,
            );
            $tags['circle'] = array(
                'cx' => true,
                'cy' => true,
                'r' => true,
                'fill' => true,
                'stroke' => true,
                'stroke-width' => true,
                'style' => true,
            );
            $tags['rect'] = array(
                'x' => true,
                'y' => true,
                'width' => true,
                'height' => true,
                'rx' => true,
                'ry' => true,
                'fill' => true,
                'style' => true,
            );
            $tags['line'] = array(
                'x1' => true,
                'y1' => true,
                'x2' => true,
                'y2' => true,
                'stroke' => true,
                'stroke-width' => true,
                'style' => true,
            );
            $tags['polyline'] = array(
                'points' => true,
                'fill' => true,
                'stroke' => true,
                'stroke-width' => true,
                'style' => true,
            );
            $tags['polygon'] = array(
                'points' => true,
                'fill' => true,
                'stroke' => true,
                'stroke-width' => true,
                'style' => true,
            );
            $tags['ellipse'] = array(
                'cx' => true,
                'cy' => true,
                'rx' => true,
                'ry' => true,
                'fill' => true,
                'stroke' => true,
                'stroke-width' => true,
                'style' => true,
            );
            $tags['defs'] = array();
            $tags['title'] = array();
            $tags['desc'] = array();
        }
        return $tags;
    },
    10,
    2
);