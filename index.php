<?php

use App\Config\Config;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require 'vendor/autoload.php';

// Display errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Récupération de l'URL demandée par le client
$url = strtok($_SERVER["REQUEST_URI"], '?');

// Parcours des routes pour trouver une correspondance
foreach (Config::getRoutes() as $route) {
    // Remplacement des paramètres dynamiques par une expression régulière
    $urlPattern = preg_replace('/:[a-z]+/', '([a-zA-Z0-9_-]+)', $route['slug']);

    // Ajout des délimiteurs d'expression régulière
    $urlPattern = '/^' . str_replace('/', '\/', $urlPattern) . '(\/|)$/';

    // Test de correspondance
    if (preg_match($urlPattern, $url, $matches)) {
        render(['route' => $route, 'matches' => $matches]);
        exit();
    }
}

render([], '404');


// Fonction pour afficher le resultat de la requete
function render($data = [])
{

    list($controller, $action) = explode('::', $data['route']['action']);

    $controller = new $controller();
    $controller->$action($data['matches']);    

}

function render_template($template, $data = [])
{
    $loader = new \Twig\Loader\FilesystemLoader('src/templates');
    $twig = new \Twig\Environment($loader, [
        // 'cache' => 'var/cache'
    ]);

    $template = $twig->load($template);
    echo $template->render($data);
}