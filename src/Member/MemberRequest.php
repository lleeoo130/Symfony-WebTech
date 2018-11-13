<?php


namespace App\Member;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class MemberRequest
 * @package App\Member
 */
class MemberRequest
{

    /**
     * @Assert\NotBlank     (message="Enter your first name")
     * @Assert\Length       (max="50",  maxMessage="Your first name must be less than {{ limit }} characters")
     */
    private $firstName;

    /**
     * @Assert\NotBlank     (message="Enter your last name")
     * @Assert\Length       (max="50",  maxMessage="Your last name must be less than {{ limit }} characters")
     */
    private $lastName;

    /**
     * @Assert\Email        (message="Please check your email")
     * @Assert\NotBlank     (message="Enter your email")
     * @Assert\Length       (max="80",  maxMessage="Your email must be less than {{ limit }} characters")
     */
    private $email;

    /**
     * @Assert\NotBlank     (message="Enter your password")
     * @Assert\Length       (min="8",   minMessage="Your password must be more than {{ limit }} characters",
     *                       max="20",   maxMessage="Your password must be less than {{ limit }} characters")
     * @Assert\Regex        (pattern="/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])[a-zA-Z0-9]+$/",
     *                      message="Your password must be at least 8 characters long, contain a number and a capital letter")
     */
    private $password;

    /**
     * @Assert\IsTrue       (message="You must validate the Terms of Use.")
     */
    private $conditions;

    /**
     * @var \DateTime
     */
    private $dateRegistration;
    /**
     * @var array
     */
    private $roles = [];


    /**
     * MemberRequest constructor.
     * @param string $role
     */
    public function __construct(string $role = 'ROLE_MEMBER')
    {
        $this->addRole($role);
        $this->dateRegistration = new \DateTime();
    }

    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getConditions()
    {
        return $this->conditions;
    }

    /**
     * @param mixed $conditions
     */
    public function setConditions($conditions): void
    {
        $this->conditions = $conditions;
    }


    /**
     * @return array
     */
    public function getRoles(): ?array
    {
        return $this->roles;
    }

    /**
     * @param array $roles
     */
    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    /**
     * @param string $role
     * @return bool
     */
    public function addRole(string $role): bool
    {
        if (!in_array($role, $this->roles))
        {
            $this->roles[]  = $role;
            return true;
        }
        else { return false; }
    }


}