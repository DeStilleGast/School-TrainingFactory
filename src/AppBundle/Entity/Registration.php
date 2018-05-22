<?php
/**
 * Created by PhpStorm.
 * User: Falco
 * Date: 22-5-2018
 * Time: 11:40
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="Registration")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RegistrationRepository")
 */
class Registration
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Assert\Blank()
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $payment; /*heeft betaalt of niet*/

    /**
     * @ORM\ManyToOne(targetEntity="Member", inversedBy="registrations")
     * @ORM\JoinColumn(fieldName="member_id", referencedColumnName="id")
     */
    private $member;

    /**
     * @ORM\ManyToOne(targetEntity="Lesson", inversedBy="registrations")
     * @ORM\JoinColumn(fieldName="lesson_id", referencedColumnName="id")
     */
    private $lesson;

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param integer $payment
     */
    public function setPayment($payment)
    {
        $this->payment = $payment;
    }

    /**
     * @return integer
     */
    public function getPayment()
    {
        return $this->payment;
    }

    /**
     * @return Member
     */
    public function getMember()
    {
        return $this->member;
    }

    /**
     * @param Member
     */
    public function setMember($member)
    {
        $this->member = $member;
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