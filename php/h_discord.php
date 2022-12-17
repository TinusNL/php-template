<?php
class h_discord
{
    public static object $user;

    public function __construct($action)
    {
        switch ($action) {
            case 'login':
                self::login();
                break;

            case 'logout':
                self::logout();
                break;

            case 'process':
                self::process();
                break;

            default:
                header('Location: ' . BASE_PATH);
                break;
        }
    }

    public static function login()
    {
        $auth_url = 'https://discord.com/api/oauth2/authorize?client_id=' . DISCORD_CLIENT_ID . '&redirect_uri=' . DISCORD_REDIRECT . '&response_type=code&scope=' . DISCORD_CLIENT_SCOPES;
        header('Location: ' . $auth_url);
    }

    public static function logout()
    {
        session_start();
        session_unset();
        session_destroy();

        header('Location: ' . BASE_PATH);
    }

    public static function process()
    {
        if (!isset($_GET['code'])) {
            header('Location: ' . BASE_PATH);
            exit();
        }

        $auth_code = $_GET['code'];

        $curl_payload = array(
            'client_id' => DISCORD_CLIENT_ID,
            'client_secret' => DISCORD_CLIENT_SECRET,
            'grant_type' => 'authorization_code',
            'code' => $auth_code,
            'redirect_uri' => DISCORD_REDIRECT,
            'scope' => DISCORD_CLIENT_SCOPES
        );
        $curl_payload_str = http_build_query($curl_payload);

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, 'https://discord.com/api/oauth2/token');
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_payload_str);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $result = curl_exec($curl);
        $result = json_decode($result, true);

        if (array_key_exists('error', $result)) {
            header('Location: ' . BASE_PATH);
            exit();
        }


        $access_token = $result['access_token'];

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, 'https://discord.com/api/users/@me');
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $access_token, 'Content-Type: application/x-www-form-urlencoded'));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $result = curl_exec($curl);

        $id = 0;
        $perms = 0;

        $stmt = h_database::prepare('SELECT
                            id,
                            perms
                        FROM
                            website_perms
                        WHERE 
                            discord_id = ?;');
        $stmt->bind_param('s', json_decode($result, true)['id']);
        $stmt->bind_result($id, $perms);
        $stmt->execute();
        $stmt->fetch();
        $stmt->close();

        if (!is_null($id) and $perms > 0) {
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['discordUser'] = $result;
            $_SESSION['perms'] = $perms;
        }

        header('Location: ' . BASE_PATH);
    }

    public static function setInfo()
    {
        session_start();

        $tempUser = [];
        $tempUser['loggedin'] = $_SESSION['loggedin'] ?? false;

        if ($tempUser['loggedin']) {
            $tempUser = array_merge($tempUser, json_decode($_SESSION['discordUser'], true));

            $tempUser['id'] = strval($tempUser['id']);
            $tempUser['avatarsmall'] = 'https://cdn.discordapp.com/avatars/' . $tempUser['id'] . '/' . $tempUser['avatar'] . '.png?size=128';
            $tempUser['avatarmedium'] = 'https://cdn.discordapp.com/avatars/' . $tempUser['id'] . '/' . $tempUser['avatar'] . '.png?size=512';
            $tempUser['avatarlarge'] = 'https://cdn.discordapp.com/avatars/' . $tempUser['id'] . '/' . $tempUser['avatar'] . '.png?size=2048';
        }

        self::$user = (object) $tempUser;
    }
}

h_discord::setInfo();
