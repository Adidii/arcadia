<?php

namespace App\Controller;

use Kreait\Firebase\Factory;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AvisController extends AbstractController
{
    private $firestore;
    private $logger;

    public function __construct(Factory $firebaseFactory, LoggerInterface $logger)
    {
        $this->logger = $logger;

        try {
            // Full path to the Firebase credentials file
            $serviceAccount = '/Users/sen/Documents/zoo1/config/firebase/zoo1-52a5e-firebase-adminsdk-43lvq-4814f9f99c.json';

            // Check if the credentials file exists
            if (!file_exists($serviceAccount)) {
                throw new \Exception('Firestore credentials file not found at: ' . $serviceAccount);
            }

            // Initialize Firestore
            $this->firestore = $firebaseFactory
                ->withServiceAccount($serviceAccount)
                ->withProjectId('zoo1-52a5e') // Replace with your Firebase project ID
                ->createFirestore()
                ->database();

            $this->logger->info('Firestore initialized successfully.');

        } catch (\Exception $e) {
            // Log the error
            $this->logger->error('Firestore initialization failed: ' . $e->getMessage());
            $this->firestore = null; // Ensure Firestore remains null if initialization fails
        }
    }

    /**
     * @Route("/avis", name="avis")
     */
    public function index(): Response
    {
        try {
            // Ensure Firestore is initialized
            if ($this->firestore === null) {
                throw new \Exception('Firestore is not initialized.');
            }

            // Retrieve reviews from Firestore
            $reviewsCollection = $this->firestore->collection('reviews');
            $reviews = $reviewsCollection->documents();

            return $this->render('avis/index.html.twig', [
                'reviews' => $reviews,
            ]);
        } catch (\Exception $e) {
            // Log the error and return a response
            $this->logger->error('Error retrieving reviews: ' . $e->getMessage());
            return new Response('Error retrieving reviews: ' . $e->getMessage(), 500);
        }
    }

    /**
     * @Route("/avis/submit", name="submit_avis", methods={"POST"})
     */
    public function submit(Request $request): Response
    {
        try {
            // Ensure Firestore is initialized
            if ($this->firestore === null) {
                throw new \Exception('Firestore is not initialized.');
            }

            $name = $request->request->get('name');
            $review = $request->request->get('review');

            // Get the logged-in user or "anonymous" if none
            $user = $this->getUser();
            $userId = $user ? $user->getId() : 'anonymous';

            // Add a new review to Firestore
            $reviewsCollection = $this->firestore->collection('reviews');
            $reviewsCollection->add([
                'name' => $name,
                'review' => $review,
                'userId' => $userId,
                'created_at' => (new \DateTime())->format('Y-m-d H:i:s'),
            ]);

            // Redirect back to the review page
            return $this->redirectToRoute('avis');
        } catch (\Exception $e) {
            // Log the error and return a response
            $this->logger->error('Error submitting review: ' . $e->getMessage());
            return new Response('Error submitting review: ' . $e->getMessage(), 500);
        }
    }
}
