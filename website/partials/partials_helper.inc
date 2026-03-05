<?php
function include_partial(string $path, array $vars = []): string
{
    if (!file_exists($path)) {
        throw new RuntimeException("Partial not found: $path");
    }

    extract($vars, EXTR_SKIP);

    ob_start();
    include $path;
    return ob_get_clean();
}
function esc(string $string): string
{
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}
