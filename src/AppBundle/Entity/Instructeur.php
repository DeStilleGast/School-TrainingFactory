<?php
/**
 * Created by PhpStorm.
 * User: Falco
 * Date: 22-5-2018
 * Time: 11:47
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity
 */
class Instructeur extends User
{
    /**
     * @ORM\Column(type="date")
     */
    private $hire_date;

    /**
     * @ORM\Column(type="decimal", precision=6, scale=2)
     */
    private $salary;


    /**
     * @ORM\OneToMany(targetEntity="Lesson", mappedBy="instructeur")
     * @ORM\JoinColumn(fieldName="lesson_id", referencedColumnName="id")
     */
    private $lessons;

    /**
     * @return \DateTime
     */
    public function getHireDate()
    {
        return $this->hire_date;
    }

    /**
     * @param \DateTime $hire_date
     */
    public function setHireDate($hire_date)
    {
        $this->hire_date = $hire_date;
    }

    /**
     * @return float
     */
    public function getSalary()
    {
        return $this->salary;
    }

    /**
     * @param float $salary
     */
    public function setSalary($salary)
    {
        $this->salary = $salary;
    }

    /**
     * @return Lesson
     */
    public function getLessons()
    {
        return $this->lessons;
    }

    /**
     * @param Lesson $lessons
     */
    public function setLessons($lessons)
    {
        $this->lessons = $lessons;
    }



}