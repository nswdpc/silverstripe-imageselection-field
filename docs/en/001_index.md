# Documentation

## Styling and configuration

```yml
---
Name: 'app-imageselection-field'
After:
  - '#nswdpc-imageselection-field'
---
NSWDPC\Forms\ImageSelectionField\ImageSelectionField:
   default_thumb_width: 300
   default_thumb_height: 300
SilverStripe\Core\Injector\Injector:
  NSWDPC\Forms\ImageSelectionField\ImageSelectionField:
    class: 'My\App\Field\CustomImageSelectionField'
```

```php
<?php
namespace My\App\Field;

use NSWDPC\Forms\ImageSelectionField\ImageSelectionField;
use SilverStripe\View\Requirements;

class CustomImageSelectionField extends ImageSelectionField
{

    /**
     * Provide a custom stylesheet from a project theme
     */
    public function Field($properties = [])
    {
        Requirements::block(
            "nswdpc/silverstripe-imageselection-field:client/static/styles/field.css"
        );
        Requirements::css(
            "mytheme:path/to/css/customimageselectionfield.css"
        );
        return parent::Field($properties);
    }
}
```

