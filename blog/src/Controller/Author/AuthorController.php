<?php

declare(strict_types=1);

namespace App\Controller\Author;

use App\Controller\ErrorHandler;
use App\Model\Author\Entity\Author\Author;
use App\ReadModel\Author\AuthorFetcher;
use App\ReadModel\Author\Filter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/authors", name="authors")
 */
class AuthorController extends AbstractController
{
    private const PER_PAGE = 20;

    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }

    /**
     * @Route("", name="")
     * @param Request $request
     * @param AuthorFetcher $fetcher
     * @return Response
     */
    public function index(Request $request, AuthorFetcher $fetcher): Response
    {
        $filter = new Filter\Filter();

        $form = $this->createForm(Filter\Form::class, $filter);
        $form->handleRequest($request);

        $pagination = $fetcher->all(
            $filter,
            $request->query->getInt('page', 1),
            self::PER_PAGE,
            $request->query->get('sort', 'name'),
            $request->query->get('direction', 'asc')
        );

        return $this->render('app/authors/index.html.twig', [
            'pagination' => $pagination,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name=".show", requirements={"id"=Guid::PATTERN})
     * @param Author $author
     * @param AuthorFetcher $fetcher
     * @return Response
     */
    public function show(Author $author, AuthorFetcher $fetcher): Response
    {
        $authors = $fetcher->find($author->getId()->getValue());

        return $this->render('app/authors/show.html.twig', [
            $authors
        ]);
    }
}