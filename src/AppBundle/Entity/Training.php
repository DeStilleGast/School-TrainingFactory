<?php
/**
 * Created by PhpStorm.
 * User: Falco
 * Date: 22-5-2018
 * Time: 11:05
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="Training")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TrainingRepository")
 */
class Training
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Assert\Blank()
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Er moet een descriptie zijn wat voor training het is of waarvoor het bedoeld is")
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Time()
     * @Assert\NotBlank()
     */
    private $duration; /*Tijd in minuten !!*/

    /**
     * @ORM\Column(type="decimal", precision=2, nullable=true)
     * @Assert\Currency()
     */
    private $extra_costs;

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return String
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param String
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return integer
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @param integer in minutes !!
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;
    }

    /**
     * @return double
     */
    public function getExtraCosts()
    {
        return $this->extra_costs;
    }

    /**
     * @param double
     */
    public function setExtraCosts($extra_costs)
    {
        $this->extra_costs = $extra_costs;
    }

    /**
     * @return Lesson
     */
    public function getLesson()
    {
        return $this->lesson;
    }

    /**
     * @param Lesson
     */
    public function setLesson($lesson)
    {
        $this->lesson = $lesson;
    }


}