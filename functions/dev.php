<?php

function trim_root_dir(string $file_path): string
{
    try {
        return str_ireplace(ROOT, "", $file_path);
    } catch (\Exception $e) {
        return $file_path;
    }
}

function debug(mixed ...$vars)
{
    if (Conf::$debug > 0) {
        foreach ($vars as $var) {
            $backtrace = debug_backtrace();
            $file = trim_root_dir($backtrace[0]['file']);
            echo '<div style="border: 1px solid grey;border-radius: 6px;margin: 1rem; padding: 0.5rem;background:rgba(6, 30, 38, 0.0625);">';
            echo '<style>.d-debugBacktraceHidden{display: none;}</style>';
            echo '<p style="margin: 0;cursor: pointer;" onclick="this.nextElementSibling.classList.toggle(\'d-debugBacktraceHidden\')">&gt;&gt;&gt;&nbsp;<strong>' . $file . '</strong> on line <strong>' . $backtrace[0]['line'] . '</strong></p>';
            echo '<ol class="d-debugBacktraceHidden">';
            foreach ($backtrace as $k => $v) {
                if ($k > 0 && isset($v['file'])) {
                    echo '<li><strong>' . trim_root_dir($v['file']) . '</strong> on line <strong>' . $v['line'] . '</strong></li>';
                }
            }
            echo '</ol>';
            echo '<hr/>';
            echo '<pre style="margin: 0;overflow-x: auto;">';
            if (is_bool($var)) {
                echo $var ? 'true' : 'false';
            } elseif (is_null($var)) {
                echo "null";
            } else {
                print_r($var);
            }
            echo '</pre>';
            echo '</div>';
        }
    }
}

function debug_n_die(mixed ...$vars)
{
    debug(...$vars);
    die;
}
