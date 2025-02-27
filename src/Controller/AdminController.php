<?php

namespace App\Controller;

use App\Entity\Company;
use App\Entity\Excursion;
use App\Entity\Level;
use App\Entity\Material;
use App\Entity\Method;
use App\Entity\School;
use App\Entity\User;
use App\Form\CompanyFilterType;
use App\Form\SchoolType;
use App\Utils\Slugger;
use App\Utils\StringUtils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    private $slugger;
    private $stringUtils;

    public function __construct(Slugger $slugger, StringUtils $stringUtils)
    {
        $this->slugger = $slugger;
        $this->stringUtils = $stringUtils;
    }

    /**
     * @Route("/", name="app_dashboard")
     */
    public function dashboard()
    {
        $user = $this->getUser();

        return $this->render('admin/dashboard.html.twig', [
            'user' => $user
        ]);
    }

    /**
     * @Route("/companies/{page<\d+>?1}", name="app_companies")
     */
    public function companies($page, Request $request)
    {
        $form = $this->createForm(CompanyFilterType::class, [
            'search' => '',
            'order_by' => 'id',
            'order_as' => 'asc',
            'levels' => [],
            'materials' => [],
            'methods' => []
        ]);
        $form->handleRequest($request);
        $filters = $form->getData();
        $orderByOptions = ['id', 'name'];
        $orderBy = $this->stringUtils->oneOf($filters['order_by'], $orderByOptions);
        $orderAsOptions = ['asc', 'desc'];
        $orderAs = $this->stringUtils->oneOf($filters['order_as'], $orderAsOptions);

        $orderUrls = [];

        foreach ($orderByOptions as $order) {
            $orderUrls[$order] = $this->generateUrl('app_companies', array_merge($request->query->all(), [
                'page' => $page,
                'order_by' => $order,
                'order_as' => $this->stringUtils->nextOf($orderAs, $orderAsOptions)
            ]));
        }

        $size = 25;
        $repo = $this->getDoctrine()->getRepository(Company::class);
        $companies = $repo->findAllPaginated($page, $size, $filters, $orderBy, $orderAs);
        $total = ceil($companies->count() / $size);

        if ($total && ($page < 1 || $page > $total)) {
            return $this->redirectToRoute('app_companies');
        }

        return $this->render('admin/companies.html.twig', [
            'page' => $page,
            'total' => max($total, 1),
            'companies' => $companies->getIterator(),
            'form' => $form->createView(),
            'orderBy' => $orderBy,
            'orderAs' => $orderAs == 'asc' ? 'down' : 'up',
            'orders' => $orderUrls
        ]);
    }

    /**
     * @Route("/companies/{slug}", name="app_company")
     */
    public function company($slug)
    {
        $repo = $this->getDoctrine()->getRepository(Company::class);
        $company = $repo->findOneBy(['slug' => $slug]);

        if (!$company) {
            return $this->redirectToRoute('app_companies');
        }

        return $this->render('admin/company.html.twig', [
            'company' => $company
        ]);
    }

    /**
     * @Route("/users/{page<\d+>?1}", name="app_users")
     */
    public function users($page)
    {
        $size = 25;
        $repo = $this->getDoctrine()->getRepository(User::class);
        $users = $repo->findAllPaginated($page, $size);
        $total = ceil($users->count() / $size);

        if ($page < 1 || $page > $total) {
            return $this->redirectToRoute('app_users');
        }

        return $this->render('admin/users.html.twig', [
            'page' => $page,
            'total' => $total,
            'users' => $users->getIterator()
        ]);
    }

    /**
     * @Route("/schools/{page<\d+>?1}", name="app_schools")
     */
    public function schools($page)
    {
        $size = 25;
        $repo = $this->getDoctrine()->getRepository(School::class);
        $schools = $repo->findAllPaginated($page, $size);
        $total = ceil($schools->count() / $size);

        if ($page < 1 || $page > $total) {
            return $this->redirectToRoute('app_schools');
        }

        return $this->render('admin/schools.html.twig', [
            'page' => $page,
            'total' => $total,
            'schools' => $schools->getIterator()
        ]);
    }

    /**
     * @Route("/schools/create", name="app_create_school", methods={"GET", "POST"})
     */
    public function createSchool(Request $request)
    {
        $school = new School();
        $form = $this->createForm(SchoolType::class, $school);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->render('admin/create_school.html.twig', [
                'form' => $form->createView()
            ]);
        }

        $school = $form->getData();
        $repo = $this->getDoctrine()->getRepository(School::class);
        $slug = $this->slugger->slugify($school->getName(), function ($slug) use ($repo) {
            return $repo->findSlugs($slug);
        });
        $school->setSlug($slug);

        $manager = $this->getDoctrine()->getManager();
        $manager->persist($school);
        $manager->flush();

        return $this->redirectToRoute('app_schools');
    }

    /**
     * @Route("/schools/{slug}", name="app_school")
     */
    public function school($slug)
    {
        $repo = $this->getDoctrine()->getRepository(School::class);
        $school = $repo->findOneBy(['slug' => $slug]);

        if (!$school) {
            return $this->redirectToRoute('app_schools');
        }

        return $this->render('admin/school.html.twig', [
            'school' => $school
        ]);
    }

    /**
     * @Route("/excursions/{page<\d+>?1}", name="app_excursions")
     */
    public function excursions($page)
    {
        $size = 25;
        $repo = $this->getDoctrine()->getRepository(Excursion::class);
        $excursions = $repo->findAllPaginated($page, $size);
        $total = ceil($excursions->count() / $size);

        if ($page < 1 || $page > $total) {
            return $this->redirectToRoute('app_excursions');
        }

        return $this->render('admin/excursions.html.twig', [
            'page' => $page,
            'total' => $total,
            'excursions' => $excursions->getIterator()
        ]);
    }
}
