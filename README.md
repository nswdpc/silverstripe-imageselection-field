# Image Selection field for Silverstripe

This is a basic radio selection field, each item in the set of options can have an image associated with it.

Useful for allowing people to select an option based on an image.

### Usage

```php

$imageList = $app->getImageList();// DataList of Image records
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
)->setImageList($imageList);
```

## Installation

```sh
composer require nswdpc/silverstripe-imageselection-field
```

## License

[BSD-3-Clause](./LICENSE.md)

## Configuration

You can set the default image width/height in your project configuration

## Maintainers

+ [dpcdigital@NSWDPC:~$](https://dpc.nsw.gov.au)

## Bugtracker

We welcome bug reports, pull requests and feature requests on the Github Issue tracker for this project.

Please review the [code of conduct](./code-of-conduct.md) prior to opening a new issue.

## Security

If you have found a security issue with this module, please email digital[@]dpc.nsw.gov.au in the first instance, detailing your findings.

## Development and contribution

If you would like to make contributions to the module please ensure you raise a pull request and discuss with the module maintainers.

Please review the [code of conduct](./code-of-conduct.md) prior to completing a pull request.
