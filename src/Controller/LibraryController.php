<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Library;
use App\Repository\LibraryRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\Persistence\ManagerRegistry;

class LibraryController extends AbstractController
{
    #[Route('/library', name: 'app_library')]
    public function index(): Response
    {
        return $this->redirectToRoute('app_library_read_many');
    }
    #[Route('/library/submit', name: 'library_submit', methods: ['POST'])]
    public function submitLibrary(Request $request, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $title = $request->request->get('title');
        $isbn = $request->request->getInt('isbn');
        $author = $request->request->get('author');
        $image = $request->request->get('image');
        $beskrivning = $request->request->get('beskrivning');

        if (empty($image)) {
            $image = 'default.jpg';
        }
        if (empty($beskrivning)) {
            $beskrivning = '';
        }

        $library = new Library();
        $library->setTitel($title);
        $library->setISBN($isbn);
        $library->setFörfattare($author);
        $library->setBild($image);
        $library->setBeskrivning($beskrivning);

        $entityManager->persist($library);
        $entityManager->flush();

        return $this->redirectToRoute('app_library_read_many');
    }
    #[Route('/library/createform', name: 'library_create_form')]
    public function createLibraryForm(
        ManagerRegistry $doctrine
    ): Response {
        $entityManager = $doctrine->getManager();
        return $this->render('library/createform.html.twig', []);
    }
    #[Route('/library/read_many', name: 'app_library_read_many')]
    public function libraryReadMany(
        LibraryRepository $libraryRepository
    ): Response {
        $librarys = $libraryRepository
            ->findAll();

        return $this->render('library/readmany.html.twig', ['books' => $librarys]);
    }
    #[Route('/library/read_one/{id}', name: 'app_library_read_one')]
    public function libraryReadOne(
        LibraryRepository $libraryRepository,
        int $id
    ): Response {
        $librarys = $libraryRepository
            ->find($id);

        return $this->render('library/readone.html.twig', ['book' => $librarys]);
    }
    #[Route('/library/update/{id}', name: 'app_library_update')]
    public function updateLibrary(
        Request $request,
        ManagerRegistry $entityManager,
        LibraryRepository $libraryRepository,
        ManagerRegistry $doctrine,
        int $id
    ): Response {
        $entityManager = $doctrine->getManager();
        $library = $libraryRepository
            ->find($id);
        if (!$library) {
            throw $this->createNotFoundException('Library not found');
        }
        if ($request->isMethod('POST')) {
            $title = $request->request->get('title');
            $isbn = $request->request->get('isbn');
            $author = $request->request->get('author');
            $image = $request->request->get('image');
            $beskrivning = $request->request->get('description');

            if (empty($image)) {
                $image = 'default.jpg';
            }
            if (empty($beskrivning)) {
                $beskrivning = '';
            }

            $library->setTitel($title);
            $library->setISBN($isbn);
            $library->setFörfattare($author);
            $library->setBild($image);
            $library->setBeskrivning($beskrivning);

            $entityManager->flush();

            return $this->redirectToRoute('app_library_read_one', ['id' => $library->getId()]);
        }

        return $this->render('library/update.html.twig', ['book' => $library]);
    }
    #[Route('/api/library/books', name: 'library_show_all')]
    public function showAlllibrary(
        LibraryRepository $libraryRepository
    ): JsonResponse {
        $librarys = $libraryRepository
            ->findAll();

        $response = $this->json($librarys);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
    #[Route('/api/library/book/{isbn}', name: 'library_show_one')]
    public function showByISBN(LibraryRepository $libraryRepository, string $isbn): Response
    {
        $book = $libraryRepository->findOneBy(['ISBN' => $isbn]);

        if (!$book) {
            throw $this->createNotFoundException('Book not found');
        }

        $data = [
            'id' => $book->getId(),
            'title' => $book->getTitel(),
            'isbn' => $book->getISBN(),
            'författare' => $book->getFörfattare(),
            'image' => $book->getBild(),
            'beskrivning' => $book->getBeskrivning(),
        ];

        $response = $this->json($data);
        $response->setEncodingOptions($response->getEncodingOptions() | JSON_PRETTY_PRINT);
        return $response;
    }
    #[Route('/api/library/book/', name: 'library_show_one_P', methods: ['POST'])]
    public function showByISBNP(Request $request, LibraryRepository $libraryRepository): Response
    {
        $isbn = $request->request->get('isbn');
        $book = $libraryRepository->findOneBy(['ISBN' => $isbn]);

        if (!$book) {
            throw $this->createNotFoundException('Book not found');
        }

        return $this->redirectToRoute('library_show_one', ['isbn' => $isbn]);
    }

    #[Route('/library/delete/{id}', name: 'library_delete_by_id')]
    public function deleteLibraryById(
        ManagerRegistry $doctrine,
        int $id
    ): Response {
        $entityManager = $doctrine->getManager();
        $library = $entityManager->getRepository(Library::class)->find($id);

        if (!$library) {
            throw $this->createNotFoundException(
                'No library found for id '.$id
            );
        }

        $entityManager->remove($library);
        $entityManager->flush();

        return $this->redirectToRoute('app_library_read_many');
    }
}
