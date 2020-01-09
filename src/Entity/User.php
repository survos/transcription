<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use MsgPhp\User\User as BaseUser;
use MsgPhp\User\UserId;
use MsgPhp\Domain\Event\DomainEventHandler;
use MsgPhp\Domain\Event\DomainEventHandlerTrait;
use MsgPhp\User\Credential\EmailPassword;
use MsgPhp\User\Model\EmailPasswordCredential;
use MsgPhp\User\Model\ResettablePassword;
use MsgPhp\User\Model\RolesField;

/**
 * @ORM\Entity()
 */
class User extends BaseUser implements DomainEventHandler
{
    use DomainEventHandlerTrait;
    use EmailPasswordCredential;
    use ResettablePassword;
    use RolesField;

    /** @ORM\Id() @ORM\GeneratedValue() @ORM\Column(type="msgphp_user_id", length=191) */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserTranscript", mappedBy="user", orphanRemoval=true)
     */
    private $userTranscripts;

    public function __construct(UserId $id, string $email, string $password)
    {
        $this->id = $id;
        $this->credential = new EmailPassword($email, $password);
        $this->userTranscripts = new ArrayCollection();
    }

    public function getId(): UserId
    {
        return $this->id;
    }

    /**
     * @return Collection|UserTranscript[]
     */
    public function getUserTranscripts(): Collection
    {
        return $this->userTranscripts;
    }

    public function addUserTranscript(UserTranscript $userTranscript): self
    {
        if (!$this->userTranscripts->contains($userTranscript)) {
            $this->userTranscripts[] = $userTranscript;
            $userTranscript->setUser($this);
        }

        return $this;
    }

    public function removeUserTranscript(UserTranscript $userTranscript): self
    {
        if ($this->userTranscripts->contains($userTranscript)) {
            $this->userTranscripts->removeElement($userTranscript);
            // set the owning side to null (unless already changed)
            if ($userTranscript->getUser() === $this) {
                $userTranscript->setUser(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getEmail();
    }
}
