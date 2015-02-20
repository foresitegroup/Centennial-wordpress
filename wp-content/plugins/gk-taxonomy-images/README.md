GK-Taxonomy-Images
==================

Simple plugin for easy adding featured images in WordPress Tag/Category pages

## Usage on your theme

We suggest to use the following code in the **category.php** file in order to display the image on the category page:

```php
<?php 

if(function_exists('gk_taxonomy_image')) {
    $category = get_the_category();
    $img = gk_taxonomy_image($category[0]->term_id, 'category-image', '', false);

    if($img) {
        echo $img;
    }
}

?>
```

The **gk_taxonomy_image** function retrieves up to 4 parameters:

* term_id
* CSS class names (can be separated by space)
* other attributes (width, height etc.)
* echo - decides if the function will echo the image directly or will return it as a string.
