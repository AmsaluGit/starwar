<?php

namespace App\Service;

use App\Entity\Characters;
use App\Entity\Movie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;
 

class StarWarService
{
    private $entityManager;
    private $httpClient;

    public function __construct(EntityManagerInterface $entityManager,HttpClientInterface $httpClient)
    {
        $this->entityManager = $entityManager;
        $this->httpClient = $httpClient;
    }

    public function createCharacter(): void
    {
        $character = new Characters();
        // $httpClient = HttpClient::create();
        $response = $this->httpClient->request('GET', 'https://swapi.dev/api/', [
            'verify_peer' => false,
            'verify_host' => false,
        ]);
        
       /* $films = $this->httpClient->request('GET', 'https://swapi.dev/api/films/', [
            'verify_peer' => false,
            'verify_host' => false,
        ]);
        $films = $films->toArray()['results'];
        dd($films);*/

        $characters = $this->httpClient->request('GET', 'https://swapi.dev/api/people/', [
            'verify_peer' => false,
            'verify_host' => false,
        ]);
        $characters = $characters->toArray()['results'];
 
    
        foreach ($characters as $characterData) {

            // $characterRepo  =  $this->entityManager->getRepository(Characters::class);
            // $character = $characterRepo->find();

            $character = new Characters();
            $character->setName($characterData['name']);
            $character->setMass($characterData['mass']);
            $character->setHeight($characterData['height']);
            $character->setGender($characterData['gender']);
            $character->setPicture("here..");
            $this->entityManager->persist($character);

            $films = $characterData['films'];

            foreach($films as $film)
            {
                $myfilms = $this->httpClient->request('GET', $film, [
                    'verify_peer' => false,
                    'verify_host' => false,
                ]);

                $filmName = $myfilms->toArray()['title'];
               
                $movie = new Movie();
                $movie->setName($filmName);
                $this->entityManager->persist($movie);

                //TODO RALATIONS
            }
     

        }
        
        $this->entityManager->flush();
     
    }
}
