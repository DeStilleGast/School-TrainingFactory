<?php
/**
 * Created by PhpStorm.
 * User: Falco
 * Date: 22-5-2018
 * Time: 09:43
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Table(name="Lesson")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LessonRepository")
 */
class Lesson
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * time
     * date
     * location
     * max_persons
     */

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="string")
     */
    private $location;

    /**
     * @ORM\Column(type="integer")
     */
    private $max_persons;

    /**
     * @ORM\ManyToOne(targetEntity="Training")
     * @ORM\JoinColumn(fieldName="training_id", referencedColumnName="id")
     */
    private $training;

    /**
     * @ORM\OneToMany(targetEntity="Registration", mappedBy="lesson")
     * @ORM\JoinColumn(fieldName="registration_id", referencedColumnName="id")
     */
    private $registrations;

    /**
     * @ORM\ManyToOne(targetEntity="Instructeur", inversedBy="lessons")
     * @ORM\JoinColumn(fieldName="instructeur_id", referencedColumnName="id")
     */
    private $instructeur;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param mixed $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * @return mixed
     */
    public function getMaxPersons()
    {
        return $this->max_persons;
    }

    /**
     * @param mixed $max_persons
     */
    public function setMaxPersons($max_persons)
    {
        $this->max_persons = $max_persons;
    }

    /**
     * @return mixed
     */
    public function getTraining()
    {
        return $this->training;
    }

    /**
     * @param mixed $training
     */
    public function setTraining($training)
    {
        $this->training = $training;
    }

    /**
     * @return mixed
     */
    public function getRegistrations()
    {
        return $this->registrations;
    }

    /**
     * @param mixed $registrations
     */
    public function setRegistrations($registrations)
    {
        $this->registrations = $registrations;
    }

    /**
     * @return Instructeur
     */
    public function getInstructeur()
    {
        return $this->instructeur;
    }

    /**
     * @param Instructeur $instructeur
     */
    public function setInstructeur($instructeur)
    {
        $this->instructeur = $instructeur;
    }



}