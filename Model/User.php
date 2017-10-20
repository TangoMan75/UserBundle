<?php

namespace TangoMan\UserBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use TangoMan\EntityHelper\Sluggable;
use TangoMan\EntityHelper\Timestampable;

/**
 * Class User
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(fields={"email"}, message="Cet email est déjà utilisé.")
 * @UniqueEntity(fields={"username"}, message="Ce nom d'utilisateur est déjà utilisé.")
 *
 * @author  Matthias Morin <tangoman@free.fr>
 * @package TangoMan\UserBundle\Entity
 */
abstract class User implements UserInterface
{
    use Sluggable;
    use Timestampable;

    /**
     * @var int User id
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\Expression("value not in ['delete','edit','new','register','unsubscribe']", message="Désolé, ce nom d'utilisateur est réservé.")
     * @Assert\NotBlank(message="Merci de renseigner un nom d'utilisateur.")
     */
    protected $username;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\Email(message="Votre email doit être valide.")
     * @Assert\NotBlank(message="Merci de renseigner votre adresse email.")
     */
    protected $email;

    /**
     * @var string User's password hash
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(min=8, minMessage="Votre mot de passe doit contenir au moins {{ limit }} caractères.")
     * @Assert\Regex(
     *     pattern="/(?=.*\d)(?=.*[a-z])(?=.*[A-Z])/",
     *     message="Votre mot de passe doit au moins contenir une minuscule, une majuscule et un chiffre."
     * )
     */
    protected $password;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->created = new \DateTimeImmutable();
        $this->modified = new \DateTimeImmutable();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set email.
     *
     * @param string $email
     *
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * these methods are required by Symfony\Component\Security\Core\User\UserInterface
     */

    /**
     * Set username and slug.
     *
     * @param string $username
     *
     * @return $this
     */
    public function setUsername($username)
    {
        $this->username = $username;

        if (!$this->slug) {
            $this->setUniqueSlug($this->username);
        }

        return $this;
    }

    /**
     * Get username.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Erase user's credentials.
     * Abstract method required by symfony core
     */
    public function eraseCredentials()
    {
    }

    /**
     * Set password.
     *
     * @param string $password
     *
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Get salt
     * Abstract method required by symfony core
     *
     * @return null
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * Default settings
     */

    /**
     * @ORM\PreFlush()
     */
    public function setDefaults()
    {
        if (!$this->slug) {
            $this->setUniqueSlug($this->username);
        }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->username;
    }
}
