<?php

namespace App\Controller;

use App\Entity\Company;
use App\Entity\Excursion;
use App\Entity\Level;
use App\Entity\Material;
use App\Entity\Method;
use App\Entity\School;
use App\Entity\User;
use App\Form\SchoolType;
use App\Utils\Slugger;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    private $slugger;

    public function __construct(Slugger $slugger)
    {
        $this->slugger = $slugger;
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
        $searchFilter = $request->query->get('search', '');
        $levelFilter = $request->query->get('level', []);
        $materialFilter = $request->query->get('material', []);
        $methodFilter = $request->query->get('method', []);

        $size = 25;
        $repo = $this->getDoctrine()->getRepository(Company::class);
        $companies = $repo->findAllPaginated($page, $size, $searchFilter, $levelFilter, $materialFilter, $methodFilter);
        $total = ceil($companies->count() / $size);

        if ($total && ($page < 1 || $page > $total)) {
            return $this->redirectToRoute('app_companies');
        }

        $repo = $this->getDoctrine()->getRepository(Level::class);
        $levels = $repo->findAll();

        $repo = $this->getDoctrine()->getRepository(Material::class);
        $materials = $repo->findAll();

        $repo = $this->getDoctrine()->getRepository(Method::class);
        $methods = $repo->findAll();

        return $this->render('admin/companies.html.twig', [
            'page' => $page,
            'total' => max($total, 1),
            'companies' => $companies->getIterator(),
            'levels' => $levels,
            'materials' => $materials,
            'methods' => $methods,
            'filters' => [
                'search' => $searchFilter,
                'level' => $levelFilter,
                'material' => $materialFilter,
                'method' => $methodFilter
            ]
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
