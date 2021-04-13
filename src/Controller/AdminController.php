<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Education;
use App\Entity\Project;
use App\Entity\Skill;
use App\Entity\Technology;
use App\Form\ArticleType;
use App\Form\EducationType;
use App\Form\ProjectType;
use App\Form\SkillType;
use App\Form\TechnologyType;
use App\Form\UserType;
use App\Repository\ArticleRepository;
use App\Repository\EducationRepository;
use App\Repository\ProjectRepository;
use App\Repository\SkillRepository;
use App\Repository\TechnologyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/admin", name="admin_")
 * @IsGranted("ROLE_ADMIN")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(TechnologyRepository $technologyRepository,
                          EducationRepository $educationRepository,
                          ProjectRepository $projectRepository,
                          SkillRepository $skillRepository ): Response
    {

        $technologies = $technologyRepository->findALL();
        $educations   = $educationRepository->findAll();
        $projects     = $projectRepository->findAll();
        $skills       = $skillRepository->findAll();
        $user         = $this->getUser();

        return $this->render('admin/index.html.twig',[
            'technologies' => $technologies,
            'educations'   => $educations,
            'projects'     => $projects,
            'skills'       => $skills,
            'user'         => $user,
        ]);
    }

    /**
     * @route("/new-technology", methods={"GET","POST"}, name="new_technology")
     */
    public function newTechnology(Request $request, EntityManagerInterface $entityManager):Response
    {
        $newTechnology = new Technology();
        $form = $this->createForm(TechnologyType::class, $newTechnology);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $newTechnology = $form->getData();
            $entityManager->persist($newTechnology);
            $entityManager->flush();
            return $this->redirectToRoute('admin_index');
        }
        return $this->render('admin/form_technology.html.twig',[
            'form' => $form->createView(),
        ]);
    }



    /**
     * @route("/edit-technology/{id}", name="edit_technology", methods={"GET","POST"})
     * @ParamConverter("technology", class="App\Entity\Technology", options={"mapping": {"id": "id"}})
     */
    public function editTechnology(Request $request, Technology $technology, EntityManagerInterface $entityManager):Response
    {
        $form = $this->createForm(TechnologyType::class, $technology);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('admin_index');
        }

        return $this->render('admin/form_technology.html.twig',[
            'technology' => $technology,
            'form'       => $form->createView(),
        ]);
    }

    /**
     * @route("/delete-technology/{id}", name="delete_technology", methods={"DELETE"})
     * @ParamConverter("technology", class="App\Entity\Technology", options={"mapping": {"id": "id"}})
     */
    public function deleteTechnology(EntityManagerInterface $entityManager, Technology $technology, Request $request):Response
    {
        if ($this->isCsrfTokenValid('delete'.$technology->getId(), $request->request->get('_token') )) {
            $entityManager->remove($technology);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_index');
    }

    /**
     * @Route ("/new-project", name="new_project", methods={"GET","POST"})
     */
    public function newProject(Request $request, EntityManagerInterface $entityManager):Response
    {

        $newProject = new Project();
        $form = $this->createForm(ProjectType::class, $newProject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $newProject->setIntTime($newProject->getPeriod()->getTimestamp());
            $entityManager->persist($newProject);
            $entityManager->flush();
            return $this->redirectToRoute('admin_index');
        }
        return $this->render('admin/new_project.html.twig', [
            'form' => $form->createView(),

        ]);

    }

    /**
     * @Route ("/edit-project/{id}", name="edit_project", methods={"GET", "POST"})
     * @ParamConverter ("project", class="App\Entity\Project", options={"mapping": {"id": "id"}})
     */
    public function editProject(Request $request, Project $project,ArticleRepository $article, EntityManagerInterface $entityManager)
    {
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $project->setIntTime($project->getPeriod()->getTimestamp());
            $entityManager->flush();
            return $this->redirectToRoute('admin_index');
        }
        return $this->render('admin/edit_project.html.twig',[
            'articles' => $article->findAll(),
            'project'  => $project,
            'form'     => $form->createView(),
        ]);
    }

    /**
     * @Route ("/delete-project/{id}", name="delete_project", methods={"DELETE"})
     * @ParamConverter ("project", class="App\Entity\Project", options={"mapping": {"id": "id"}})
     */
    public function deleteProject(EntityManagerInterface $entityManager, Project $project, Request $request):Response
    {
        if ($this->isCsrfTokenValid('delete'.$project->getId(), $request->request->get('_token') )) {
            $entityManager->remove($project);
            $entityManager->flush();
        }
        return $this->redirectToRoute('admin_index');
    }

    /**
     * @Route ("/edit-profile", name="edit_profile", methods={"GET","POST"})
     */
    public function editProfile(Request $request,
                                EntityManagerInterface $entityManager,
                                UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = $this->getUser();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('admin_index');
        }
        return $this->render('admin/edit_profile.html.twig',[
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/new-skill", name="new_skill", methods={"GET","POST"})
     */
    public function newSkill(Request $request, EntityManagerInterface $entityManager):Response
    {
        $newSkill = new Skill();
        $form = $this->createForm(SkillType::class, $newSkill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($newSkill);
            $entityManager->flush();
            return $this->redirectToRoute('admin_index');
        }
        return $this->render('admin/form_skill.html.twig',[
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route ("/edit-skill/{id}", name="edit_skill", methods={"GET", "POST"})
     * @ParamConverter ("skill", class="App\Entity\Skill", options={"mapping": {"id": "id"}})
     */
    public function editSkill(Request $request, Skill $skill, EntityManagerInterface $entityManager)
    {
        $form = $this->createForm(SkillType::class, $skill);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('admin_index');
        }
        return $this->render('admin/form_skill.html.twig',[
            'skill' => $skill,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @route("/delete-skill/{id}", name="delete_skill", methods={"DELETE"})
     * @ParamConverter("skill", class="App\Entity\Skill", options={"mapping": {"id": "id"}})
     */
    public function deleteSkill(EntityManagerInterface $entityManager, Skill $skill, Request $request):Response
    {
        if ($this->isCsrfTokenValid('delete'.$skill->getId(), $request->request->get('_token') )) {
            $entityManager->remove($skill);
            $entityManager->flush();
        }
        return $this->redirectToRoute('admin_index');
    }

    /**
     * @Route ("/new-education", name="new_education", methods={"GET","POST"})
     */
    public function newEducation(Request $request, EntityManagerInterface $entityManager):Response
    {
        $newEducation = new Education();
        $form = $this->createForm(EducationType::class, $newEducation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($newEducation);
            $entityManager->flush();
            return $this->redirectToRoute('admin_index');
        }
        return $this->render('admin/form_education.html.twig',[
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route ("/edit-education/{id}", name="edit_education", methods={"GET", "POST"})
     * @ParamConverter ("education", class="App\Entity\Education", options={"mapping": {"id": "id"}})
     */
    public function editEducation(Request $request, Education $education, EntityManagerInterface $entityManager)
    {
        $form = $this->createForm(EducationType::class, $education);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('admin_index');
        }
        return $this->render('admin/form_education.html.twig',[
            'education' => $education,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @route("/delete-education/{id}", name="delete_education", methods={"DELETE"})
     * @ParamConverter("education", class="App\Entity\Education", options={"mapping": {"id": "id"}})
     */
    public function deleteEducation(EntityManagerInterface $entityManager, Education $education, Request $request):Response
    {
        if ($this->isCsrfTokenValid('delete'.$education->getId(), $request->request->get('_token') )) {
            $entityManager->remove($education);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_index');
    }

    /**
     * @Route ("/edit-project/{id}/add-article", name="add_article", methods={"GET","POST"})
     * @ParamConverter ("project", class="App\Entity\Project", options={"mapping": {"id": "id"}})
     */

    public function addArticle(Request $request, Project $project,EntityManagerInterface $entityManager): Response
    {
        $newArticle = new Article();
        $form = $this->createForm(ArticleType::class, $newArticle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newArticle->setProject($project);
            $entityManager->persist($newArticle);
            $entityManager->flush();
            return $this->redirect('/admin/edit-project/'.$project->getId());
        }

        return $this->render('admin/_add_article.html.twig',[
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route ("/edit-project/{name}/edit-article/{id}", name="edit_article", methods={"GET", "POST"})
     * @ParamConverter ("project", class="App\Entity\Project", options={"mapping": {"name": "name"}})
     * @ParamConverter ("article", class="App\Entity\Article", options={"mapping": {"id": "id"}})
     * @param Article $article
     */
    public function editArticle(Request $request, Article $article, Project $project ,EntityManagerInterface $entityManager)
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirect('/admin/edit-project/'.$project->getId());
        }
        return $this->render('admin/_add_article.html.twig',[
            'form' => $form->createView(),
        ]);
    }

    /**
     * @route("/edit-project/{name}/delete-article/{id}", name="delete_article", methods={"DELETE"})
     * @ParamConverter ("project", class="App\Entity\Project", options={"mapping": {"name": "name"}})
     * @ParamConverter("article", class="App\Entity\Article", options={"mapping": {"id": "id"}})
     */
    public function deleteArticle(EntityManagerInterface $entityManager, Article $article, Project $project, Request $request):Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token') )) {
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirect('/admin/edit-project/'.$project->getId());
    }

}
