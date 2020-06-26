<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\StudentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     collectionOperations={
 *         "get"={
 *             "normalization_context"={"groups"={"studentRead"}}
 *         },
 *         "post"={
 *             "normalization_context"={"groups"={"studentWrite"}}
 *         }
 *     },
 *     itemOperations={
 *         "get"={
 *             "normalization_context"={"groups"={"oneStudentRead"}}
 *         },
 *         "put"={
 *             "normalization_context"={"groups"={"studentWrite"}}
 *         },
 *         "patch"={
 *             "normalization_context"={"groups"={"studentWrite"}}
 *         },
 *         "delete"
 *     }
 * )
 * @ORM\Entity(repositoryClass=StudentRepository::class)
 */
class Student
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"studentRead", "oneStudentRead", "ratingRead"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150)
     * @Groups({"studentRead", "studentWrite", "oneStudentRead", "ratingRead"})
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=150)
     * @Groups({"studentRead", "studentWrite", "oneStudentRead", "ratingRead"})
     */
    private $lastname;

    /**
     * @ORM\Column(type="date")
     * @Groups({"studentRead", "studentWrite", "oneStudentRead", "ratingRead"})
     */
    private $birthdate;

    /**
     * @ORM\OneToMany(targetEntity=Rating::class, mappedBy="student", orphanRemoval=true)
     * @Groups({"oneStudentRead"})
     */
    private $ratings;

    public function __construct()
    {
        $this->ratings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(\DateTimeInterface $birthdate): self
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    /**
     * @return Collection|Rating[]
     */
    public function getRatings(): Collection
    {
        return $this->ratings;
    }

    public function addRating(Rating $rating): self
    {
        if (!$this->ratings->contains($rating)) {
            $this->ratings[] = $rating;
            $rating->setStudent($this);
        }

        return $this;
    }

    public function removeRating(Rating $rating): self
    {
        if ($this->ratings->contains($rating)) {
            $this->ratings->removeElement($rating);
            // set the owning side to null (unless already changed)
            if ($rating->getStudent() === $this) {
                $rating->setStudent(null);
            }
        }

        return $this;
    }

    /**
     * @return int|null
     * @Groups("oneStudentRead")
     */
    public function getAverageRating() : ?float
    {
        $ratings = $this->getRatings();
        $ratingsCount = count($ratings);

        if ( $ratingsCount > 0 ) {

            $average = 0.00;

            return array_reduce($ratings->toArray(), function(float $average, Rating $rating) use ($ratingsCount) {
                return ($average ?? 0.00) + $rating->getValue()/$ratingsCount;
            }, $average);

        }

        return null;
    }
}
