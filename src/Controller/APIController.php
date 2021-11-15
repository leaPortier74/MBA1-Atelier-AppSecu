<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\SongRepository;
use App\Repository\AlbumRepository;
use App\Repository\ArtistRepository;
use App\Entity\Song;
use App\Entity\Album;
use App\Entity\Artist;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/api", name="api_")
 */
class APIController extends AbstractController
{
    /**
     * @Route("/", name="api")
     */
    public function index()
    {

    }   



    ////// SONGS //////

    /**
     * @Route("/songs/liste", name="songs_liste", methods={"GET"})
     */
    public function songsListe(SongRepository $songsRepo)
    {
        // On récupère la liste des songs
        $songs = $songsRepo->apiFindAll();

        // On spécifie qu'on utilise l'encodeur JSON
        $encoders = [new JsonEncoder()];

        // On instancie le "normaliseur" pour convertir la collection en tableau
        $normalizers = [new ObjectNormalizer()];

        // On instancie le convertisseur
        $serializer = new Serializer($normalizers, $encoders);

        // On convertit en json
        $jsonContent = $serializer->serialize($songs, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);

        // On instancie la réponse
        $response = new Response($jsonContent);

        // On ajoute l'entête HTTP
        $response->headers->set('Content-Type', 'application/json');

        // On envoie la réponse
        return $response;
    }

    /**
    * @Route("/song/see/{id}", name="song_see", methods={"GET"})
    */
    public function getSong(Song $songs)
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($songs, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        $response = new Response($jsonContent);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
    * @Route("/song/add", name="song_add", methods={"POST"})
    */
    public function addSong(Request $request)
    {
        // On vérifie si la requête est une requête Ajax
        if($request->isXmlHttpRequest()) {
            // On instancie un nouvel song
            $song = new Song();

            // On décode les données envoyées
            $donnees = json_decode($request->getContent());

            // On hydrate l'objet
            $song->setTitle($donnees->title);
            $song->setAlbum($donnees->album);
            foreach ($donnees->artist as $key => $value) {
                $song->addArtist($value);
            }

            // On sauvegarde en base
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($song);
            $entityManager->flush();

            // On retourne la confirmation
            return new Response('ok', 201);
        }
        return new Response('Failed', 404);
    }



    ////// ALBUMS //////

    /**
     * @Route("/albums/liste", name="albums_liste", methods={"GET"})
     */
    public function albumsListe(AlbumRepository $albumsRepo)
    {
        // On récupère la liste des albums
        $albums = $albumsRepo->apiFindAll();

        // On spécifie qu'on utilise l'encodeur JSON
        $encoders = [new JsonEncoder()];

        // On instancie le "normaliseur" pour convertir la collection en tableau
        $normalizers = [new ObjectNormalizer()];

        // On instancie le convertisseur
        $serializer = new Serializer($normalizers, $encoders);

        // On convertit en json
        $jsonContent = $serializer->serialize($albums, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);

        // On instancie la réponse
        $response = new Response($jsonContent);

        // On ajoute l'entête HTTP
        $response->headers->set('Content-Type', 'application/json');

        // On envoie la réponse
        return $response;
    }

    /**
    * @Route("/album/see/{id}", name="album_see", methods={"GET"})
    */
    public function getAlbum(Album $albums)
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($albums, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        $response = new Response($jsonContent);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
    * @Route("/album/add", name="album_add", methods={"POST"})
    */
    public function addAlbum(Request $request)
    {
        // On vérifie si la requête est une requête Ajax
        if($request->isXmlHttpRequest()) {
            // On instancie un nouvel album
            $album = new Album();

            // On décode les données envoyées
            $donnees = json_decode($request->getContent());

            // On hydrate l'objet
            $album->setTitle($donnees->title);
            foreach ($donnees->artist as $key => $value) {
                $album->addArtist($value);
            }

            // On sauvegarde en base
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($album);
            $entityManager->flush();

            // On retourne la confirmation
            return new Response('ok', 201);
        }
        return new Response('Failed', 404);
    }




    ////// ARTISTS //////

    /**
     * @Route("/artists/liste", name="artists_liste", methods={"GET"})
     */
    public function artistsListe(ArtistRepository $artistsRepo)
    {
        // On récupère la liste des artists
        $artists = $artistsRepo->apiFindAll();

        // On spécifie qu'on utilise l'encodeur JSON
        $encoders = [new JsonEncoder()];

        // On instancie le "normaliseur" pour convertir la collection en tableau
        $normalizers = [new ObjectNormalizer()];

        // On instancie le convertisseur
        $serializer = new Serializer($normalizers, $encoders);

        // On convertit en json
        $jsonContent = $serializer->serialize($artists, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);

        // On instancie la réponse
        $response = new Response($jsonContent);

        // On ajoute l'entête HTTP
        $response->headers->set('Content-Type', 'application/json');

        // On envoie la réponse
        return $response;
    }

    /**
    * @Route("/artist/see/{id}", name="artist_see", methods={"GET"})
    */
    public function getArtist(Artist $artists)
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $jsonContent = $serializer->serialize($artists, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
        $response = new Response($jsonContent);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
    * @Route("/artist/add", name="artist_add", methods={"POST"})
    */
    public function addArtist(Request $request)
    {
        // On vérifie si la requête est une requête Ajax
        if($request->isXmlHttpRequest()) {
            // On instancie un nouvel artist
            $artist = new Artist();

            // On décode les données envoyées
            $donnees = json_decode($request->getContent());

            // On hydrate l'objet
            $artist->setFirstname($donnees->firstname);
            $artist->setLastname($donnees->lastname);

            // On sauvegarde en base
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($artist);
            $entityManager->flush();

            // On retourne la confirmation
            return new Response('ok', 201);
        }
        return new Response('Failed', 404);
    }
}