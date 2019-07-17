<?php

declare(strict_types=1);

namespace App\Controller\Author;

use App\Annotation\Guid;
use App\Controller\ErrorHandler;
use App\Model\Author\Entity\Author\Author;
use App\Model\Author\Entity\Author\Id;
use App\Model\Author\UseCase\Edit;
use App\Model\Author\UseCase\Create;
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
     * @Route("/create", name=".create")
     * @param Request $request
     * @param Create\Handler $handler
     * @return Response
     */
    public function create(Request $request, Create\Handler $handler): Response
    {
        $command = new Create\Command(Id::next());

        $form = $this->createForm(Create\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('authors.show', ['id' => $command->id]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/authors/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name=".edit")
     * @param Author $author
     * @param Request $request
     * @param Edit\Handler $handler
     * @return Response
     */
    public function edit(Author $author, Request $request, Edit\Handler $handler): Response
    {
        $command = Edit\Command::fromAuthor($author);

        $form = $this->createForm(Edit\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('authors.show', ['id' => $author->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/authors/edit.html.twig', [
            'author' => $author,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name=".show", requirements={"id"=Guid::PATTERN})
     * @param Author $author
     * @return Response
     */
    public function show(Author $author): Response
    {
        return $this->render('app/authors/show.html.twig', [
            'author' => $author
        ]);
    }
}