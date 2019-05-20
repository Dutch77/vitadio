<?php
/**
 * Created by PhpStorm.
 * User: Michal Kolář
 * Date: 19. 5. 2019
 * Time: 18:51
 */

namespace App\Entity\User;

use App\Entity\Forum\Thread;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Forum\ThreadUserAccess;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->threadUserAccesses = new ArrayCollection();
    }

    /**
     * @var ThreadUserAccess[]|Collection|null
     * @ORM\OneToMany(targetEntity="App\Entity\Forum\ThreadUserAccess", mappedBy="thread", cascade={"all"}, orphanRemoval=true)
     */
    protected $threadUserAccesses;

    /**
     * @param Thread $thread
     *
     * @return bool
     */
    public function hasAccessToThread(Thread $thread): bool
    {
        return count($this->getThreadUserAccesses()->filter(function (ThreadUserAccess $threadUserAccess) use ($thread) {
                return $threadUserAccess->getThread() === $thread;
            })) > 0;
    }

    /**
     * @return ThreadUserAccess[]|Collection|null
     */
    public function getThreadUserAccesses()
    {
        return $this->threadUserAccesses;
    }

    /**
     * @param ThreadUserAccess[]|Collection|null $threadUserAccesses
     *
     * @return User
     */
    public function setThreadUserAccesses($threadUserAccesses)
    {
        $this->threadUserAccesses = $threadUserAccesses;
        return $this;
    }

}