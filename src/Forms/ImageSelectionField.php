<?php

namespace NSWDPC\Forms\ImageSelectionField;

use SilverStripe\Forms\FormField;
use SilverStripe\Forms\OptionsetField;
use SilverStripe\ORM\DataList;
use SilverStripe\Assets\Image;
use SilverStripe\Assets\Storage\AssetContainer;
use SilverStripe\View\Requirements;

/**
 * Image selection field with radio buttons
 * @author James
 */
class ImageSelectionField extends OptionsetField
{

    /**
     * @var int
     */
    private static $default_thumb_width = 150;

    /**
     * @var int
     */
    private static $default_thumb_height = 120;

    /**
     * Image width
     * @var int|null
     */
    protected $imageWidth = null;

    /**
     * Image height
     * @var int|null
     */
    protected $imageHeight = null;


    /**
     * List of images for this field
     * @var DataList|null
     */
    protected $imageList = null;

    /**
     * This function is used by the template processor. If you refer to a field as a $ variable, it
     * will return the $Field value.
     *
     * @return string
     */
    public function forTemplate()
    {
        Requirements::css(
            "nswdpc/silverstripe-imageselection-field:client/static/styles/field.css"
        );
        return parent::forTemplate();
    }

    /**
     * Sets the image list for use, and set the source map for the field based on this list
     */
    public function setImageList(DataList $imageList, string $mapTitle = "Title") : self {
        $this->imageList = $imageList;
        return parent::setSource( $this->imageList->map("ID", $mapTitle) );
    }

    /**
     * Return images set
     */
    public function Images() : ?DataList {
        return $this->imageList;
    }

    /**
     * Based on the ID value, return the Image record from the imageList array
     * This is used in templates e.g {$Image($Value)}
     */
    public function Image($id) : ?Image {
        $image = null;
        if($this->imageList) {
            $image = $this->imageList->byId($id);
        }
        return ($image instanceof Image) ? $image : null;
    }

    /**
     * Based on the ID value, return a thumbnail of the image record
     * This is used in templates e.g {$Thumbnail($Value)}
     */
    public function Thumbnail($id) : ?AssetContainer {
        if($image = $this->Image($id)) {
            return $image->Fill( $this->getImageWidth(), $this->getImageHeight() );
        } else {
            return null;
        }
    }

    /**
     * Set a specific thumbnail width
     */
    public function setImageWidth(int $width) : self {
        $this->imageWidth = abs($width);
        return $this;
    }

    /**
     * Set a specific thumbnail height
     */
    public function setImageHeight(int $height) : self {
        $this->imageHeight = abs($height);
        return $this;
    }

    /**
     * Set a specific thumbnail dimension
     */
    public function setImageDimensions(int $width, int $height) : self {
        $this->imageWidth = abs($width);
        $this->imageHeight = abs($height);
        return $this;
    }

    /**
     * Return image width to use for thumbnailing
     */
    public function getImageWidth() : int {
        $width =  $this->imageWidth ?? self::config()->get('default_thumb_width');
        if(!is_int($width)) {
            $width = static::$default_thumb_width;
        }
        return $width;
    }

    /**
     * Return image height to use for thumbnailing
     */
    public function getImageHeight() : int {
        $height = $this->imageHeight ?? self::config()->get('default_thumb_height');
        if(!is_int($height)) {
            $height = static::$default_thumb_width;
        }
        return $height;
    }
}
