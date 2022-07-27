<?php

namespace App\Entity;


// use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ArticleRepository;
use JMS\Serializer\Annotation as Serializer;


/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 */
class Article
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * 
     * @Serializer\Groups({"article"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255) 
     * @Serializer\Groups({"article"})
     */
   
    private string $title;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     *@Serializer\Groups({"article"})
     */
    
    private string $content;

    /**
     * @ORM\Column(type="string", length=255)
     *@Serializer\Groups({"article"})
     */
    private string $autor;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getAutor(): ?string
    {
        return $this->autor;
    }

    public function setAutor(string $autor): self
    {
        $this->autor = $autor;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
}
