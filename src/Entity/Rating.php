<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\RatingRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=RatingRepository::class)
 */
class Rating
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"oneStudentRead"})
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"oneStudentRead"})
     * /**
     * @Assert\Range(
     *      min = 0,
     *      max = 20,
     *      notInRangeMessage = "Rating value must be between {{ min }}cm and {{ max }} out of 20.",
     * )
     */
    private $value;

    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({"oneStudentRead"})
     */
    private $subject;

    /**
     * @ORM\ManyToOne(targetEntity=Student::class, inversedBy="ratings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $student;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setValue(int $value): self
    {
        $this->value = $value;

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

    public function getStudent(): ?Student
    {
        return $this->student;
    }

    public function setStudent(?Student $student): self
    {
        $this->student = $student;

        return $this;
    }
}
