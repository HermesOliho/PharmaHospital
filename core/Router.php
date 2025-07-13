<?php

namespace HeromTech;

class Router
{
    static array $routes = [];

    static function parse(Request $request)
    {
        $request->url = trim($request->url, "/");
        foreach (self::$routes as $r) {
            if (
                preg_match($r['catcher'], $request->url, $match)
                && $r['http_method'] == $_SERVER['REQUEST_METHOD']
            ) {
                $request->controller = $r['controller'];
                $request->action = $r['action'];
                $request->params = [];
                foreach ($r['params'] as $k => $v) {
                    $request->params[$k] = $match[$k];
                }
                return $request;
            }
        }
        return false;
    }

    /**
     * Connect
     * @param string $redirection
     * @param string $url
     * @param 'GET'|'POST'|'PUT'|'PATCH'|'DELETE' $http_method
     */
    static function connect(string $redirection, string $url, string $http_method = 'GET')
    {
        $r = [];
        $r['params'] = [];
        $r['http_method'] = $http_method;
        $r['redirection'] = $redirection;
        $r['origin'] = preg_replace("/([a-z0-9]+):([^\/]+)/", "$1:(?P<$1>$2)", $url);
        $r['origin'] = "/" . str_replace("/", "\/", $r['origin']) . "/";
        $params = explode('/', $url);
        foreach ($params as $k => $v) {
            if (strpos($v, ':')) {
                $p = explode(':', $v);
                $r['params'][$p[0]] = $p[1];
            } else {
                if ($k == 0) {
                    $r['controller'] = $v;
                } elseif ($k == 1) {
                    $r['action'] = $v;
                }
            }
        }
        $r['catcher'] = $redirection;
        foreach ($r['params'] as $k => $v) {
            $r['catcher'] = str_replace(":$k", "(?P<$k>$v)", $r['catcher']);
        }
        $r['catcher'] = "/^" . str_replace("/", "\/", $r['catcher']) . "$/";

        self::$routes[] = $r;
    }

    /**
     * URL
     */
    static function url(string $url)
    {
        foreach (self::$routes as $r) {
            if (preg_match($r['origin'], $url, $match)) {
                // debug($match);
                foreach ($match as $k => $v) {
                    if (!is_numeric($k)) {
                        $r['redirection'] = str_replace(":$k", $v, $r['redirection']);
                    }
                }
                return $r['redirection'];
            }
        }
        return $url;
    }
}
