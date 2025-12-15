<?php

namespace NSWDPC\Forms\ImageSelectionField\Tests;

use NSWDPC\Forms\ImageSelectionField\ImageSelectionField;
use SilverStripe\Core\Config\Config;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\Assets\Dev\TestAssetStore;
use SilverStripe\Assets\File;
use SilverStripe\Assets\Folder;
use SilverStripe\Assets\Image;
use SilverStripe\View\SSViewer;

/**
 * Unit test to verify field implementation
 * @author James
 */
class ImageSelectionFieldTest extends SapphireTest
{

    protected $usesDatabase = true;

    protected static $fixture_file = 'ImageSelectionFieldTest.yml';

    #[\Override]
    public function setUp() : void {
        parent::setUp();

        TestAssetStore::activate('imageselectionfield');
        $files = File::get()->exclude('ClassName', Folder::class);
        foreach ($files as $image) {
            $source_path = __DIR__ . '/data/' . $image->Name;
            $image->setFromLocalFile($source_path, $image->Filename);
            $image->write();
        }
    }

    #[\Override]
    public function tearDown() : void
    {
        TestAssetStore::reset();
        parent::tearDown();
    }

    public function testImageSelectionField(): void {

        SSViewer::set_themes(['$public', '$default']);

        $default_thumb_width = 190;
        $default_thumb_height = 160;

        Config::modify()->set(ImageSelectionField::class, 'default_thumb_width', $default_thumb_width);
        Config::modify()->set(ImageSelectionField::class, 'default_thumb_height', $default_thumb_height);

        $images = Image::get();

        $this->assertEquals(3, $images->count());

        $field = ImageSelectionField::create(
            'SelectedImageID',
            'Select an image'
        )->setImageList($images)
        ->setDescription('Some field description');

        $imageCheck = $field->Images();

        $this->assertEquals($images->count(), $imageCheck->count());

        $html = $field->forTemplate();

        $dom = new \DOMDocument();
        $dom->loadHTML($html);

        foreach($imageCheck as $image) {
            /** @var \SilverStripe\Assets\Image $fieldImage */
            $fieldImage = $field->Thumbnail($image->ID);
            $this->assertEquals($field->getImageWidth(), $fieldImage->getWidth());
            $this->assertEquals($field->getImageHeight(), $fieldImage->getHeight());

            $inputElement = $dom->getElementByID("SelectedImageID_{$image->ID}");

            $this->assertNotNull($inputElement);
            $inputValue = $inputElement->getAttribute('value');
            $this->assertEquals($inputValue, $image->ID);

            $parentNode = $inputElement->parentNode;
            $this->assertInstanceOf(\DOMElement::class, $parentNode);
            $imageElement = $parentNode ->getElementsByTagName('img')[0];
            $this->assertEquals( $field->getImageWidth(), $imageElement->getAttribute('width'));
            $this->assertEquals( $field->getImageHeight(), $imageElement->getAttribute('height'));

        }


    }


}
