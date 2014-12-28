mustache-extensions
===================

Extensions to the mustache library

## Variable Partial Loader

Allow Mustache partials to be defined within the ViewModel and pass in as the data.

Partials will check to see if there’s a variable with that name first, if there is then the content of that variable will be used, otherwise it will revert to the standard behaviour of using the name as the partial. This means you have to take this into consideration when naming your variables and partials.

If you want to load a template named `header.mustache` then a template who’s name is set by the variable `$content` then the `footer.mustache` template, you can simply do this:

```html
{{> header}}
{{> content}}
{{> footer}}
```

### Usage as an extension of the Mustache Engine

```php
$mustache = new \Adric\Mustache\MustacheEngine(array(
    'template_directory' => '/path/to/template/directory',
    'template_extension' => 'mustache'
);
$vars = array(
    'content' => 'about',
    'title' => 'About Us'
);

echo $mustache->render('
    {{> header}}
    {{> content}}
    {{> footer}}
', $vars);

// Or render from file index.mustache
echo $mustache->renderFromFile('index', $vars);
```

### Usage with the existing Mustache Engine

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
