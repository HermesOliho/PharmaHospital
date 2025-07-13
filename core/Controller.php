<?php

namespace HeromTech;

class Controller
{
    private array $vars = [];

    public Request $request;
    public string $layout = "default";

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Rend une vue HTML
     * @param string $view Le nom (ou l'emplacement) de la vue à afficher
     */
    public function render($view)
    {
        extract($this->vars);
        if (strpos($view, '/') === 0) {
            $view = ROOT . DS . 'views' . $view;
        } else {
            $view = ROOT . DS . 'views' . DS . $this->request->controller . DS . $view;
        }
        ob_start();
        require $view . '.php';
        $content_for_layout = ob_get_clean();
        require ROOT . DS . 'views' . DS . 'layouts' . DS . $this->layout . '.php';
    }

    /**
     * Définit des variables pour la vue
     * @param string|array $key Le nom de la variable ou le tableau clé-valeur des variables à définir
     * @param string|null $value La valeur de la variable à définir
     */
    public function set($key, $value = null)
    {
        if (is_array($key)) {
            $this->vars += $key;
        } else {
            $this->vars[$key] = $value;
        }
    }

    /**
     * RespondJSON
     */
    public function respondJSON(mixed $data, int $code = 200)
    {
        // Encode the data to JSON and output it
        if (is_array($data) || is_object($data)) {
            $data = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        } else {
            $data = json_encode(['message' => $data], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }
        if (json_last_error() !== JSON_ERROR_NONE) {
            $data = json_encode(['error' => 'Invalid JSON data'], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
            http_response_code(500);
        }
        // Set the content type header to application/json and the response code
        if ($code < 100 || $code >= 600) {
            $code = 500; // Default to 500 Internal Server Error if the code is invalid
        }
        // Set the HTTP response code
        http_response_code($code);
        // Set the content type to application/json
        header("Content-Type: application/json; charset=UTF-8");
        if (headers_sent()) {
            echo $data;
            exit;
        }
        echo $data;
        exit;
    }
}
