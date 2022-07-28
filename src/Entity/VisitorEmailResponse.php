<?php

namespace App\Entity;

use App\Repository\VisitorEmailResponseRepository;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VisitorEmailResponseRepository::class)]
class VisitorEmailResponse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'datetime_immutable')]
    private $created_at;

    #[ORM\Column(type: 'text')]
    private $content;

    #[ORM\Column(type: 'string', length: 255)]
    private $subject;

    #[ORM\ManyToOne(targetEntity: VisitorsMessage::class, inversedBy: 'visitorEmailResponses')]
    #[ORM\JoinColumn(nullable: false)]
    private $visitorMessage;

    public function __construct(VisitorsMessage $message)
    {
       $this->created_at = new DateTimeImmutable("now");
       $this->visitorMessage = $message; 
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

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

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getVisitorMessage(): ?VisitorsMessage
    {
        return $this->visitorMessage;
    }

    public function setVisitorMessage(?VisitorsMessage $visitorMessage): self
    {
        $this->visitorMessage = $visitorMessage;

        return $this;
    }
}
