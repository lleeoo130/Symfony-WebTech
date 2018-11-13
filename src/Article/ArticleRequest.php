<?php

namespace App\Article;

use App\Entity\Member;
use Symfony\Component\Validator\Constraints as Assert;

class ArticleRequest
{

    const PATH_TO_IMAGE_FOLDER = __DIR__.'\..\..\public\images\product';

    private $id;

    /**
     * @Assert\NotBlank(message="You need to type in a title.")
     * @Assert\Length(
     *     max="255",
     *     maxMessage="Your title is too long. No more than {{ limit }} chars."
     * )
     */
    private $title;
    private $slug;

    /**
     * @Assert\NotBlank(message="Don't forget your article...!")
     */
    private $content;

    /**
     * @Assert\Image(
     *     mimeTypesMessage="File needs to be an image.",
     *     maxSize="2M", maxSizeMessage="Your image is too big, max {{ limit }}"
     * )
     */
    private $featuredImage;
    private $imgUrl;
    private $special;
    private $spotlight;

    /**
     * @Assert\NotNull(message="Don't forget to choose a category.")
     */
    private $category;
    private $author;
    private $dateCreation;


    public function __construct(Member $author)
    {
        $this->author = $author;
        $this->dateCreation = new \DateTime();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getSlug(): string
    {
        return (string)$this->slug;
    }

    public function setSlug()
    {
        $this->slug = self::slugify($this->getTitle());
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content): void
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getFeaturedImage()
    {
        return $this->featuredImage;
    }

    /**
     * @param mixed $featuredImage
     */
    public function setFeaturedImage($featuredImage): void
    {
        $this->featuredImage = $featuredImage;
    }

    public function uploadImage()
    {
        if (null === $this->getFeaturedImage()) {
            return;
        }

        $this->setSlug();
        $imageName = $this->getSlug()."_".$this->getFeaturedImage()->getClientOriginalName();

        $this->getFeaturedImage()->move(
            self::PATH_TO_IMAGE_FOLDER,
            $imageName
        );
        $this->setFeaturedImage($imageName);
    }

    /**
     * @return mixed
     */
    public function getImgUrl()
    {
        return $this->imgUrl;
    }

    /**
     * @param mixed $imgUrl
     */
    public function setImgUrl($imgUrl): void
    {
        $this->imgUrl = $imgUrl;
    }

    /**
     * @return mixed
     */
    public function getSpecial()
    {
        return $this->special;
    }

    /**
     * @param mixed $special
     */
    public function setSpecial($special): void
    {
        $this->special = $special;
    }

    /**
     * @return mixed
     */
    public function getSpotlight()
    {
        return $this->spotlight;
    }

    /**
     * @param mixed $spotlight
     */
    public function setSpotlight($spotlight): void
    {
        $this->spotlight = $spotlight;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category): void
    {
        $this->category = $category;
    }

    /**
     * @return Member
     */
    public function getAuthor(): Member
    {
        return $this->author;
    }

    /**
     * @param Member $author
     */
    public function setAuthor(Member $author): void
    {
        $this->author = $author;
    }

    /**
     * @return \DateTime
     */
    public function getDateCreation(): \DateTime
    {
        return $this->dateCreation;
    }

    /**
     * @param \DateTime $dateCreation
     */
    public function setDateCreation(\DateTime $dateCreation): void
    {
        $this->dateCreation = $dateCreation;
    }

    public static function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }


}