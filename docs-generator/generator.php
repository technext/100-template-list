<?php
require_once __DIR__ . '/vendor/autoload.php';

$dir = dirname(__DIR__);

printf('Start generation of documentation file for directory "%s".'.PHP_EOL, $dir);

$finder = new \Symfony\Component\Finder\Finder();
$finder
    ->files()
    ->in($dir)
    ->depth('== 1')
    ->sortByName(true)
    ->exclude('docs')
    ->name('screenshot.png')
;

if (!$finder->hasResults()) {
    throw new RuntimeException(sprintf('No result found in "%s"', $dir));
}

printf('Ready to generate documentation file for %d templates.'.PHP_EOL, $finder->count());

$screenshots = '';
foreach ($finder as $index => $file) {
    $path = rawurlencode($file->getRelativePath());
    $screenshot = sprintf(
        './%s/%s',
        $path,
        $file->getFilename()
    );
    $url = sprintf('./%s/', $path);

    $screenshots .= <<<EOF

<div class="masonry-item">
    <div class="masonry-content" data-src="{$screenshot}">
        <a href="{$url}">
            <h3 class="masonry-title">{$file->getRelativePath()}</h3>
        </a>
        <a href="{$screenshot}" class="lightgallery">
            <img src="{$screenshot}" alt="Screenshot of template {$file->getRelativePath()}" />
        </a>
        <p class="masonry-description">Watch preview of template "{$file->getRelativePath()}".</p>
    </div>
</div>

EOF;
}

$html = <<<EOF
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>100 template list</title>
    <link rel="stylesheet" href="asset/masonry.css">
    <link rel="stylesheet" href="asset/lightgallery.min.css">
</head>
<body>
    <div class="masonry-wrapper">
        <div class="masonry">
            {$screenshots}
        </div>
        <div class="masonry-footer">
            <p>Created with &#10084; by <a href="//defro.github.io" target="_blank" rel="external">Jo&euml;l Gaujard</a></p>
        </div>
    </div>
    <script src="//npmcdn.com/imagesloaded@4.1/imagesloaded.pkgd.js"></script>
    <script src="asset/masonry.js"></script>
    <script src="asset/lightgallery.min.js"></script>
    <script>
        let gallery = document.getElementsByClassName('lightgallery');
        for (let i=0; i < gallery.length; i++) {
            gallery[i].lightGallery({
                selector: 'this'
            });
        }
    </script>
</body>
</html>
EOF;

$generatedFile = $dir . '/index.html';

$fileSystem = new \Symfony\Component\Filesystem\Filesystem();
$fileSystem->dumpFile($generatedFile, $html);

if ($fileSystem->exists($generatedFile)) {
    exit('Generation done!' . PHP_EOL);
}

throw new RuntimeException(sprintf('File "%s" has not been generated.', $generatedFile));
