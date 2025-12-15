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
    private static int $default_thumb_width = 150;

    /**
     * @var int
     */
    private static int $default_thumb_height = 120;

    /**
     * Image width
     */
    protected ?int $imageWidth = null;

    /**
     * Image height
     */
    protected ?int $imageHeight = null;


    /**
     * List of images for this field
     */
    protected ?DataList $imageList = null;

    /**
     * @inheritdoc
     */
    public function Field($properties = [])
    {
        Requirements::css(
            "nswdpc/silverstripe-imageselection-field:client/static/styles/field.css"
        );
        return parent::Field($properties);
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
        $width =  $this->imageWidth > 0 ? $this->imageWidth : self::config()->get('default_thumb_width');
        if(!is_int($width) || $width <= 0) {
            $width = 150;
        }
        return $width;
    }

    /**
     * Return image height to use for thumbnailing
     */
    public function getImageHeight() : int {
        $height = $this->imageHeight > 0 ? $this->imageHeight : self::config()->get('default_thumb_height');
        if(!is_int($height) || $height <= 0) {
            $height = 120;
        }
        return $height;
    }
}
