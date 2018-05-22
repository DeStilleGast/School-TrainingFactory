<?php
/**
 * Created by PhpStorm.
 * User: Falco
 * Date: 22-5-2018
 * Time: 12:09
 */

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity
 */
class Member extends User
{
    /**
     * @ORM\Column(type="string")
     */
    private $street;

    /**
     * @ORM\Column(type="string")
     */
    private $portal_code;

    /**
     * @ORM\Column(type="string")
     */
    private $place;

    /**
     * @ORM\OneToMany(targetEntity="Registration", mappedBy="member")
     * @ORM\JoinColumn(fieldName="registration_id", referencedColumnName="id")
     */
    private $registrations;
}