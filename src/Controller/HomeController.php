<?php 
namespace App\Controller;

class HomeController
{
    public function index(array $macthes)
    {
        render_template('index.html.twig', [
            'name' => 'World'
        ]);
    }
}