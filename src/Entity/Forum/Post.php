<?php
/**
 * Created by PhpStorm.
 * User: Michal Kolář
 * Date: 19. 5. 2019
 * Time: 19:17
 */

namespace App\Entity\Forum;

use App\Entity\Serializeable;
use App\Entity\User\User;
use App\Entity\Util\TimestampableInterface;
use App\Entity\Util\TimestampableTrait;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Table(name="forum__post")
 * @ORM\Entity()
 */
class Post implements Serializeable, TimestampableInterface
{
    use TimestampableTrait;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string|null
     * @ORM\Column(name="title", type="string", nullable=false)
     */
    protected $title;

    /**
     * @var string|null
     * @ORM\Column(name="content", type="string", nullable=false)
     */
    protected $content;

    /**
     * @var Thread|null
     * @ORM\ManyToOne(targetEntity="App\Entity\Forum\Thread", inversedBy="posts")
     */
    protected $thread;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     *
     * @return Post
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     *
     * @return Post
     */
    public function setTitle(?string $title): Post
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param string|null $content
     *
     * @return Post
     */
    public function setContent(?string $content): Post
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime|null $createdAt
     *
     * @return Post
     */
    public function setCreatedAt(?\DateTime $createdAt): Post
    {
        $this->createdAt = $createdAt;
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
     * @return Post
     */
    public function setThread(?Thread $thread): Post
    {
        $this->thread = $thread;
        return $this;
    }

    /**
     * @return array
     */
    public function serialize()
    {
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'content' => $this->getContent(),
            'createdAt' => $this->getCreatedAt()
        ];
    }

}