<?php
/**
 * Created by PhpStorm.
 * User: Michal Kolář
 * Date: 19. 5. 2019
 * Time: 19:18
 */

namespace App\Entity\Forum;


use App\Entity\User\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="forum__thread_user_access")
 * @ORM\Entity()
 */
class ThreadUserAccess
{
    /**
     * @var integer|null
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var Thread|null
     * @ORM\ManyToOne(targetEntity="App\Entity\Forum\Thread", inversedBy="threadUserAccesses")
     */
    protected $thread;

    /**
     * @var User|null
     * @ORM\ManyToOne(targetEntity="App\Entity\User\User", inversedBy="tagEntityRelations")
     */
    protected $user;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     *
     * @return ThreadUserAccess
     */
    public function setId(?int $id): ThreadUserAccess
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Thread|null
     */
    public function getThread(): ?Thread
    {
        return $this->thread;
    }

    /**
     * @param Thread|null $thread
     *
     * @return ThreadUserAccess
     */
    public function setThread(?Thread $thread): ThreadUserAccess
    {
        $this->thread = $thread;
        return $this;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User|null $user
     *
     * @return ThreadUserAccess
     */
    public function setUser(?User $user): ThreadUserAccess
    {
        $this->user = $user;
        return $this;
    }


}