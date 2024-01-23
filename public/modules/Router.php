<?php
class Router
{
    private static array $pages = [];
    public static string $url = '';

    // Load all pages from the given directory
    public static function loadPages(string $pagesDir): void
    {
        $dirs = Router::recursiveGrub($pagesDir);

        foreach ($dirs as $dir) {
            if (file_exists($dir . '/index.php')) {
                self::$pages[str_replace('pages/', '', $dir)] = $dir . '/index.php';
            }
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

    // Recursively get all directories
    private static function recursiveGrub(string $path): array
    {
        $dirs = glob($path . '/*', GLOB_ONLYDIR);

        foreach ($dirs as $dir) {
            $dirs = array_merge($dirs, self::recursiveGrub($dir));
        }

        return $dirs;
    }

    // Check if the current page is an api
    public static function isApi(): bool
    {
        return str_starts_with(Router::$url, 'api/');
    }
}
