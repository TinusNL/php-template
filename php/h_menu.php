<?php
class h_menu
{

    public static $pages = [];
    public static $page;
    public static $action;
    public static $params = [];

    public static function addPage(string $class, string $name, string $match, bool $requiresLogin = false, bool $inNav = true)
    {
        self::$pages[] = [
            'class' => $class,
            'name' => $name,
            'match' => $match,
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

        $url = explode('?', $url)[0];
        $url = trim(str_replace(BASE_PATH, '', $url), '/');
        $splitURL = explode('/', $url);

        $bestMatch = null;
        $bestMatchCount = 0;

        foreach (self::$pages as $page) {
            $splitMatch = explode('/', $page['match']);
            $match = [];

            foreach ($splitMatch as $value) {
                if (str_starts_with($value, ':')) {
                    $match[] = '(\w+)';
                } else {
                    $match[] = $value;
                }
            }

            $match = '/' . implode('\/', $match) . '.*/';

            if (preg_match($match, $url, $matches) == 1 && count($splitMatch) >= $bestMatchCount) {
                $bestMatch = $page;
                $bestMatchCount = count($splitMatch);
                $bestMatches = $matches;
            }
        }

        self::$page = $bestMatch;
        self::$action = end($splitURL);

        if (substr_count($bestMatch['match'], ':') > 0) {
            $splitMatch = explode('/', $page['match']);
            array_shift($bestMatches);

            foreach ($splitMatch as $value) {
                if (str_starts_with($value, ':')) {
                    $value = substr($value, 1);

                    self::$params[$value] = array_shift($bestMatches);
                }
            }
        }

        if (self::$page['requiresLogin'] && !h_discord::$user->loggedin) {
            header('Location: ' . BASE_PATH);
            exit();
        }
    }
}
