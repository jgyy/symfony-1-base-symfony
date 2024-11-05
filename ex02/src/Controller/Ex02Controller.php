<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\MessageType;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Form\FormFactoryInterface;

class Ex02Controller extends AbstractController
{
    private $params;
    private $formFactory;

    public function __construct(
        ParameterBagInterface $params,
        FormFactoryInterface $formFactory
    ) {
        $this->params = $params;
        $this->formFactory = $formFactory;
    }

    #[Route('/e02', name: 'ex02')]
    public function index(Request $request): Response
    {
        $messageData = [
            'message' => '',
            'includeTimestamp' => false
        ];

        $form = $this->createForm(MessageType::class, $messageData);
        $form->handleRequest($request);
        $lastLine = null;

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $message = $data['message'];
            $includeTimestamp = $data['includeTimestamp'];
            
            // Get file path from config
            $filePath = $this->params->get('app.notes_file');
            
            // Create line content
            $line = $includeTimestamp ? 
                sprintf("[%s] %s\n", date('Y-m-d H:i:s'), $message) :
                sprintf("%s\n", $message);
            
            // Append to file
            file_put_contents($filePath, $line, FILE_APPEND);
            
            // Store last line for display
            $lastLine = trim($line);
        }

        return $this->render('ex02/index.html.twig', [
            'form' => $form->createView(),
            'lastLine' => $lastLine
        ]);
    }
}
