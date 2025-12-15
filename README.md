# Image Selection field for Silverstripe

This is a basic radio selection field, each item in the set of options can have an image associated with it.

Useful for allowing people to select an option based on an image uploaded to the file library.

## Usage

```php
$imageList = $app->getImageList();// DataList of Image records
$width = $app->getImageWidth();
$height = $app->getImageHeight();
$sampleImageField = ImageSelectionField::create(
    'SelectedImageID',
    _t(
        'myapp.CHOOSE_AN_IMAGE',
        'Choose an image'
    )
)->setDescription(
    _t(
        'myapp.CHOOSE_AN_IMAGE_HELP',
        'Choose an image that is most relevant.'
    )
)->setImageList($imageList)
->setImageDimensions($width, $height);
```

The module provides a stylesheet using an example flexbox layout.

### Styling and templating

You will almost definitely want to use your own stylesheet, so use `Requirements::block` to block loading of the field.css stylesheet and then require your own stylesheet in your project.

To include your own template, override it in your project or theme in the usual Silverstripe way using the same file path, then flush cache.

[More information](./docs/en/001_index.md).

## Template methods

In the scope of the field:

+ `{$Thumbnail($ID)}` return the current image resized to the requested image width/height, pass an Image.ID value to the method
+ `{$Image($ID)}` return the current image, pass an Image.ID value to the method
+ `{$Images}` return the image list
+ `{$ImageWidth}` return the specified image width
+ `{$ImageHeight}` return the specified image height

## Installation

```sh
composer require nswdpc/silverstripe-imageselection-field
```

## License

[BSD-3-Clause](./LICENSE.md)

## Configuration

You can set the default image width/height in your project configuration

## Maintainers

+ PD Web Team

## Bugtracker

We welcome bug reports, pull requests and feature requests on the Github Issue tracker for this project.

Please review the [code of conduct](./code-of-conduct.md) prior to opening a new issue.

## Security

If you have found a security issue with this module, please email digital[@]dpc.nsw.gov.au in the first instance, detailing your findings.

## Development and contribution

If you would like to make contributions to the module please ensure you raise a pull request and discuss with the module maintainers.

Please review the [code of conduct](./code-of-conduct.md) prior to completing a pull request.
