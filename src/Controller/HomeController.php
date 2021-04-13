<?php

namespace App\Controller;

use App\Entity\Project;
use App\Entity\Technology;
use App\Entity\User;
use App\Repository\ArticleRepository;
use App\Repository\EducationRepository;
use App\Repository\PictureRepository;
use App\Repository\ProjectRepository;
use App\Repository\SkillRepository;
use App\Repository\TechnologyRepository;
use App\Repository\UserRepository;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @Route("/", name="home_")
 */
class HomeController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(TechnologyRepository $technologyRepository,
                          EducationRepository $educationRepository,
                          ProjectRepository $projectRepository,
                          SkillRepository $skillRepository,
                          UserRepository $userRepository): Response
    {
        $technologies = $technologyRepository->findBy(array(), ['name' => 'ASC']);
        $timeLine     = $projectRepository->findBy(array(), ['intTime' => 'DESC']);
        $projects     = $projectRepository->findby(['showProject' => true]);
        $educations   = $educationRepository->findAll();
        $skills       = $skillRepository->findAll();
        $user         = $userRepository->findAll();

        return $this->render('home/index.html.twig', [
            'technologies' => $technologies,
            'educations'   => $educations,
            'projects'     => $projects,
            'timeLine'     => $timeLine,
            'skills'       => $skills,
            'user'         => $user[0],
        ]);
    }

    /**
     * @Route ("/project/{name}", name="project")
     */
    public function showProject(UserRepository $userRepository,
                                Project $project,
                                ProjectRepository $projectRepository,
                                TechnologyRepository  $technologyRepository): Response
    {
        $minId = $projectRepository->findOneBy(array(),['id' => 'ASC']);
        $minId = $minId->getId();
        $maxId = $projectRepository->findOneBy(array(),['id' => 'DESC']);
        $maxId = $maxId->getId();

        $nextId = intval($project->getId()) +1;
        $backId = intval($project->getId()) -1;

        if ($nextId > $maxId) {
            $projectNext = $projectRepository->findOneBy(['id' => $minId]);
        } else {
            $projectNext = $projectRepository->findOneBy(['id' => $nextId]);
        }

        if ($backId < $minId) {
            $projectBack = $projectRepository->findOneBy(['id' => $maxId]);
        } else {
            $projectBack = $projectRepository->findOneBy(['id' => $backId]);
        }
        $technologies = $technologyRepository->findby(array(), ['name' => 'ASC']);
        $projects     = $projectRepository->findAll();
        $user         = $userRepository->findAll();
        return $this->render('home/project.html.twig',[
            'technologies' => $technologies,
            'backProject'  => $projectBack,
            'nextProject'  => $projectNext,
            'projects'     => $projects,
            'project'      => $project,
            'user'         => $user[0],
        ]);
    }
}
