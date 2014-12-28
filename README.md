mustache-extensions
===================

Extensions to the mustache library

## Variable Partial Loader

Allow Mustache partials to be defined within the ViewModel and pass in as the data.

Partials will check to see if there’s a variable with that name first, if there is then the content of that variable will be used, otherwise it will revert to the standard behaviour of using the name as the partial. This means you have to take this into consideration when naming your variables and partials.

If you want to load a template named header.html then a template who’s name is set by the variable $content then the footer.html template, you can simply do this:

```html
{{> header}}
{{> content}}
{{> footer}}
```

### Usage

```php
$templateDirectory = '/path/to/template/directory';
$templateExtension = 'mustache';
$partialLoader = new MustacheVariablePartialLoader(
    $templateDirectory,
    array(
       'extension' => $templateExtension
    )
);

$mustache = new Mustache_Engine(array(
    'partials_loader' => $partialLoader
));

$vars = array(
    'content' => 'about',
    'title' => 'About Us'
);
$partialLoader->setVars($vars);
$mustache->render('
    {{> header}}
    {{> content}}
    {{> footer}}
', $vars);
```
