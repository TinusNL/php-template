<?php
class h_menu
{

    public static $pages = [];
    public static $page;
    public static $action;

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

        $url = trim(str_replace(BASE_PATH, '', $url), '/');
        $splitURL = explode('/', $url);

        $bestMatch = null;
        $bestMatchCount = 0;

        foreach (self::$pages as $page) {
            $pageUrl = implode('/', $page['aliases']);

            if (str_starts_with($url, $pageUrl) && count($page['aliases']) > $bestMatchCount) {
                $bestMatch = $page;
                $bestMatchCount = $bestMatchCount;
            }
        }

        self::$page = $bestMatch;
        self::$action = end($splitURL);

        if (self::$page['requiresLogin'] && !h_discord::$user['loggedin']) {
            header('Location: ' . BASE_PATH);
            exit();
        }
    }
}
