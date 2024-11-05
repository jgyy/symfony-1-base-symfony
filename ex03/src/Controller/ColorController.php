<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/e03', name: 'e03_')]
class ColorController extends AbstractController
{
    #[Route('/', name: 'colors')]
    public function index(): Response
    {
        $numberOfColors = $this->getParameter('e03.number_of_colors');

        $colors = ['black', 'red', 'blue', 'green'];

        $shades = [];
        foreach ($colors as $color) {
            $shades[$color] = $this->generateShades($color, $numberOfColors);
        }
        
        return $this->render('e03/colors.html.twig', [
            'colors' => $colors,
            'shades' => $shades,
            'numberOfColors' => $numberOfColors
        ]);
    }
    
    private function generateShades(string $color, int $count): array
    {
        $shades = [];
        
        switch ($color) {
            case 'black':
                for ($i = 0; $i < $count; $i++) {
                    $value = (255 * $i) / ($count - 1);
                    $shades[] = sprintf('rgb(%d, %d, %d)', $value, $value, $value);
                }
                break;
                
            case 'red':
                for ($i = 0; $i < $count; $i++) {
                    $value = (255 * $i) / ($count - 1);
                    $shades[] = sprintf('rgb(255, %d, %d)', $value, $value);
                }
                break;
                
            case 'blue':
                for ($i = 0; $i < $count; $i++) {
                    $value = (255 * $i) / ($count - 1);
                    $shades[] = sprintf('rgb(%d, %d, 255)', $value, $value);
                }
                break;
                
            case 'green':
                for ($i = 0; $i < $count; $i++) {
                    $value = (255 * $i) / ($count - 1);
                    $shades[] = sprintf('rgb(%d, 255, %d)', $value, $value);
                }
                break;
        }
        
        return $shades;
    }
}
