<?php
class Router
{
    private static array $pages = [];
    private static array $components = [];
    public static string $url = '';

    // Load all pages from the given directory
    public static function loadPages(string $pagesDir): void
    {
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($pagesDir));

        foreach ($iterator as $file) {
            if (!$file->isFile() || $file->getExtension() != 'php') {
                continue;
            }

            $pagePath = str_replace('pages/', '', $file->getPathname());
            $pagePath = str_replace('.php', '', $pagePath);
            self::$pages[$pagePath] = $file->getPathname();
        }
    }

    // Load all components from the directory
    public static function loadComponents(): void
    {
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator('components'));

        foreach ($iterator as $file) {
            if (!$file->isFile() || $file->getExtension() != 'php') {
                continue;
            }

            $componentPath = str_replace('components/', '', $file->getPathname());
            $componentPath = str_replace('.php', '', $componentPath);
            self::$components[$componentPath] = $file->getPathname();
        }
    }

    // Strip the url from the prefix and query string
    public static function loadUrl(string $url): void
    {
        $url = explode('?', $url)[0];
        $url = strstr($url, '/');
        $url = str_replace(URL_PREFIX, '', $url);
        $url = ltrim($url, '/');

        Router::$url = $url;
    }

    // Get the offset for the css and js files
    public static function getOffset(): string
    {
        $url = explode('/', Router::$url);

        return str_repeat('../', count($url) - 1);
    }

    // Get the url for the given path
    public static function getUrl(string $path): string
    {
        return '/' . URL_PREFIX . $path;
    }

    // Get the content of the current page
    public static function getContent(): string
    {
        $url = trim(Router::$url, '/');

        // Start the output buffer
        ob_start();

        // Check if the page exists. If not, load the 404 page
        if (array_key_exists($url, Router::$pages)) {
            include Router::$pages[$url];
        } else if ($url == '') {
            include Router::$pages['home'];
        } else {
            include Router::$pages['404'];
        }

        // Return the output buffer
        return ob_get_clean();
    }

    // Get the content of the given component
    public static function getComponent(string $component): string
    {
        // Start the output buffer
        ob_start();

        // Include the component
        include Router::$components[$component];

        // Return the output buffer
        return ob_get_clean();
    }

    // Check if the current page is an api
    public static function isApi(): bool
    {
        return str_starts_with(Router::$url, 'api/');
    }
}
