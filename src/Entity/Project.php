<?php

namespace App\Entity;

use App\Repository\ProjectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=ProjectRepository::class)
 * @Vich\Uploadable
 */
class Project
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column (type="string", length=255)
     */
    private $team;

    /**
     * @ORM\Column (type="string", length=255)
     */
    private $client;

    /**
     * @ORM\Column (type="string", length=255, nullable=true)
     */
    private $logoClient;

    /**
     * @Vich\UploadableField(mapping="logos", fileNameProperty="logoClient")
     * @var File
     */
    private $logoClientFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $firstPicture;

    /**
     * @Vich\UploadableField(mapping="pictures", fileNameProperty="firstPicture")
     * @var File
     */
    private $firstPictureFile;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity=Technology::class, inversedBy="projects")
     */
    private $technologies;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $link;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updateAt;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $showProject;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $period;
    /**
     * @ORM\Column (type="date", nullable=true)
     */
    private $periodEnd;
    /**
     * @ORM\Column (type="integer", nullable=true)
     */
    private $intTime;

    /**
     * @ORM\OneToMany(targetEntity=Article::class, mappedBy="project")
     */
    private $articles;

    public function __toString(): string
    {
        return $this->period;
        return $this->periodEnd;
    }

    public function __construct()
    {
        $this->technologies = new ArrayCollection();
        $this->articles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFirstPicture(): ?string
    {
        return $this->firstPicture;
    }

    public function setFirstPicture(?string $firstPicture): self
    {
        $this->firstPicture = $firstPicture;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Technology[]
     */
    public function getTechnologies(): Collection
    {
        return $this->technologies;
    }

    public function addTechnology(Technology $technology): self
    {
        if (!$this->technologies->contains($technology)) {
            $this->technologies[] = $technology;
        }

        return $this;
    }

    public function removeTechnology(Technology $technology): self
    {
        $this->technologies->removeElement($technology);

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(?string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeInterface
    {
        return $this->updateAt;
    }

    public function setUpdateAt(?\DateTimeInterface $updateAt): self
    {
        $this->updateAt = $updateAt;

        return $this;
    }


    public function getFirstPictureFile(): ?File
    {
        return $this->firstPictureFile;
    }


    public function setFirstPictureFile(File $firstPicture = null)
    {
        $this->firstPictureFile = $firstPicture;
        if ($firstPicture) {
            $this->updatedAt = new \DateTime('now');
        }
        return $this;
    }


    public function getShowProject(): ?bool
    {
        return $this->showProject;
    }

    public function setShowProject(?bool $showProject): self
    {
        $this->showProject = $showProject;

        return $this;
    }

    public function getPeriod(): ?\DateTimeInterface
    {
        return $this->period;
    }

    public function setPeriod(?\DateTimeInterface $period): self
    {
        $this->period = $period;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIntTime()
    {
        return $this->intTime;
    }

    /**
     * @param mixed $intTime
     */
    public function setIntTime($intTime): void
    {
        $this->intTime = $intTime;
    }

    /**
     * @return mixed
     */
    public function getTeam()
    {
        return $this->team;
    }/**
 * @param mixed $team
 */
    public function setTeam($team): void
    {
        $this->team = $team;
    }

    /**
     * @return mixed
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param mixed $client
     */
    public function setClient($client): void
    {
        $this->client = $client;
    }

    /**
     * @return mixed
     */
    public function getPeriodEnd()
    {
        return $this->periodEnd;
    }

    /**
     * @param mixed $periodEnd
     */
    public function setPeriodEnd($periodEnd): void
    {
        $this->periodEnd = $periodEnd;
    }

    public function getArticle(): ?Article
    {
        return $this->articles;
    }

    public function setArticle(?Article $articles): self
    {
        $this->articles = $articles;

        return $this;
    }


    public function getLogoClient()
    {
        return $this->logoClient;
    }


    public function setLogoClient($logoClient): void
    {
        $this->logoClient = $logoClient;

    }


    public function getLogoClientFile()
    {
        return $this->logoClientFile;
    }


    public function setLogoClientFile(File $logoClient = null): Project
    {
        $this->logoClientFile = $logoClient;
        if ($logoClient) {
            $this->updateAt = new \DateTime('now');
        }
        return $this;
    }



    /**
     * @return Collection|Article[]
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setProject($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getProject() === $this) {
                $article->setProject(null);
            }
        }

        return $this;
    }
}
