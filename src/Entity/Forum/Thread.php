<?php
/**
 * Created by PhpStorm.
 * User: Michal Kolář
 * Date: 19. 5. 2019
 * Time: 19:17
 */

namespace App\Entity\Forum;

use App\Entity\Serializeable;
use App\Entity\Util\TimestampableInterface;
use App\Entity\Util\TimestampableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Table(name="forum__thread")
 * @ORM\Entity()
 */
class Thread implements Serializeable, TimestampableInterface
{
    use TimestampableTrait;

    /**
     * @var integer|null
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var ThreadUserAccess[]|Collection|null
     * @ORM\OneToMany(targetEntity="App\Entity\Forum\ThreadUserAccess", mappedBy="thread", cascade={"all"}, orphanRemoval=true)
     */
    protected $threadUserAccesses;

    /**
     * @var string|null
     * @ORM\Column(name="title", type="string", nullable=false)
     */
    protected $title;

    /**
     * @var Post[]|Collection|null
     * @ORM\OneToMany(targetEntity="App\Entity\Forum\Post", mappedBy="thread", cascade={"all"}, orphanRemoval=true)
     */
    protected $posts;

    /**
     * @var string|null
     * @ORM\Column(name="slug", type="string", length=64, nullable=true)
     * @Gedmo\Slug(fields={"title"}, unique_base="site")
     */
    protected $slug;

    /**
     * Thread constructor.
     */
    public function __construct()
    {
        $this->threadUserAccesses = new ArrayCollection();
        $this->posts = new ArrayCollection();
    }

    /**
     * @param Post $post
     *
     * @return Thread
     */
    public function addPost(Post $post): Thread
    {
        $post->setThread($this);
        $this->getPosts()->add($post);
        return $this;
    }

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
     * @return Thread
     */
    public function setId(?int $id): Thread
    {
        $this->id = $id;
        return $this;
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
     * @return Thread
     */
    public function setThreadUserAccesses($threadUserAccesses)
    {
        $this->threadUserAccesses = $threadUserAccesses;
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
     * @return Thread
     */
    public function setTitle(?string $title): Thread
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return Post[]|Collection|null
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * @param Post[]|Collection|null $posts
     *
     * @return Thread
     */
    public function setPosts($posts)
    {
        $this->posts = $posts;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @param string|null $slug
     *
     * @return Thread
     */
    public function setSlug(?string $slug): Thread
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @return array
     */
    public function serialize()
    {
        $serializedPosts = [];
        foreach ($this->getPosts() as $post) {
            $serializedPosts[] = $post->serialize();
        }
        return [
            'id' => $this->getId(),
            'slug' => $this->getSlug(),
            'title' => $this->getTitle(),
            'posts' => $serializedPosts
        ];
    }

}