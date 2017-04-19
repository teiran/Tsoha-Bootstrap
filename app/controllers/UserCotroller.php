<?php

class UserController extends BaseController {

    public static function login() {
        View::make('user/login.html');
    }
    
    public static function create() {
        View::make('user/newuser.html');
    }
    
    public static function store() {
        // POST-pyynnön muuttujat sijaitsevat $_POST nimisessä assosiaatiolistassa
        $params = $_POST;
        // Alustetaan uusi Game-luokan olion käyttäjän syöttämillä arvoilla
        $user = new User(array(
            'nimi' => $params['nimi'],
            'salasana' => $params['salasana'],
            'tili' => $params['tili'],
            'kate' => $params['kate']
        ));
        $errors = $user->errors();

        if (count($errors) == 0) {
            // Peli on validi, hyvä homma!
            $user->tallenna();

            Redirect::to('/login', array('message' => 'Uusi käyttäjä on luotu'));
        } else {
            // Pelissä oli jotain vikaa :(
            View::make('asia/newuser.html', array('errors' => $errors, 'attributes' => $user));
        }



        // Ohjataan käyttäjä lisäyksen jälkeen pelin esittelysivulle
    }

    public static function handle_login() {
        $params = $_POST;

        $user = User::authenticate($params['username'], $params['password']);

        if (!$user) {
            View::make('user/login.html', array('error' => 'Väärä käyttäjätunnus tai salasana!', 'username' => $params['username']));
        } else {
            $_SESSION['user'] = $user->id;

            Redirect::to('/', array('message' => 'Tervetuloa takaisin ' . $user->nimi . '!'));
        }
    }

    public static function logout() {
        $_SESSION['user'] = null;
        Redirect::to('/login', array('message' => 'Olet kirjautunut ulos!'));
    }

}
