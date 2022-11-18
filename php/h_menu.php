<?php
class h_menu
{

    public static $pages = [];

    public static function addPage(string $class, string $name, array $aliases, bool $requiresLogin = false, bool $inNav = true)
    {
        self::$pages[] = [
            'class' => $class,
            'name' => $name,
            'aliases' => $aliases,
            'requiresLogin' => $requiresLogin,
            'inNav' => $inNav
        ];
    }

    public static function getPageByURL(string $url)
    {
        if (!str_starts_with($url, BASE_PATH)) {
            header('Location: ' . BASE_PATH);
            exit();
        }

        $url = str_replace(BASE_PATH, '', $url);
        $splitURL = explode('/', trim($url, '/'));

        $bestMatch = null;
        $bestMatchCount = 0;

        foreach (self::$pages as $page) {
            $matchCount = array_intersect($splitURL, $page['aliases']);

            if ($matchCount > $bestMatchCount) {
                $bestMatch = $page;
                $bestMatchCount = $matchCount;
            }
        }

        return new $bestMatch['class'](end($splitURL));
    }
}
