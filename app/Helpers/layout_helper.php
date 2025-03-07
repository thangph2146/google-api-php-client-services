<?php
if (!function_exists('get_sidebar')) {
    function get_sidebar($layout = 'admin') {
        return view("layout/{$layout}/sidebar", [], ['return' => true]);
    }
}

if (!function_exists('get_header')) {
    function get_header($layout = 'admin') {
        return view("layout/{$layout}/header", [], ['return' => true]);
    }
}

if (!function_exists('get_footer')) {
    function get_footer($layout = 'admin') {
        return view("layout/{$layout}/footer", [], ['return' => true]);
    }
}

if (!function_exists('get_body')) {
    function get_body($view, $data = []) {
        return view($view, $data, ['return' => true]);
    }
}