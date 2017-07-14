<?php

use Core\Classes\Config;

Config::Set('displayConsole', false);

/**
 * Autocomplete
 */

$this->post('/autocomplete/lokacija', 'AutocompleteController@lokacija');

/**
 * Landing stranice
 */

$this->post('/registracija', 'RegisterController@registracija');
$this->post('/registracija/lokacija', 'RegisterController@lokacija');
$this->post('/registracija/lokacija/sacuvaj', 'RegisterController@lokacijaSacuvaj');
$this->post('/registracija/zavrsi', 'RegisterController@zavrsi');
$this->post('/prijava', 'HomeController@prijava');

/**
 * Profil
 */

$this->post('/profil/feed', 'ProfileController@getFeed');

/**
 * Privatne poruke il ti ga razgovori
 */

$this->post('/razgovori/posalji', 'RazgovoriController@posalji');

/**
 * Sve u vezi instrukcija je ovdje...
 */

$this->post('/instrukcije/zakazi', 'InstrukcijeController@zakazi');
$this->post('/instrukcije/prihvati', 'InstrukcijeController@prihvati');
$this->post('/instrukcije/odbij', 'InstrukcijeController@odbij');

/**
 * Sve oko notifikacija i tako to
 */

$this->post('/notifikacije/ucitaj', 'NotifikacijeController@ucitaj');
$this->post('/notifikacije/prikazi', 'NotifikacijeController@prikazi');

/**
 * Preglednik
 */

$this->post('/oglasi/{predmet}', 'HomeController@oglasi');
$this->post('/oglasi/{predmet}/{sortiranje}', 'HomeController@oglasi');

/**
 * Poruke
 * @pjesma https://www.youtube.com/watch?v=jfgnc6Ey0q0
 */

$this->post('/poruke/razgovori', 'PorukeController@razgovori');
$this->post('/poruke/posalji', 'PorukeController@posalji');

$this->post('/poruke/ucitajrazgovore', 'PorukeController@indexv2');
$this->post('/poruke/ucitajrazgovor', 'PorukeController@razgovorv2');
$this->post('/poruke/brojac', 'PorukeController@brojac');

/**
 * Recenzije
 */

$this->post('/recenzije/posalji', 'RecenzijeController@posalji');

/**
 * Postavke
 */

$this->post('/postavke/ukinisesiju', 'PostavkeController@ukinisesiju');
$this->post('/postavke/sacuvaj', 'PostavkeController@sacuvaj');
$this->post('/postavke/sacuvajpredmete', 'PostavkeController@sacuvajpredmete');
$this->post('/postavke/uploadavatar', 'PostavkeController@uploadavatar');

/**
 * Admin
 */

$this->post('/admin/_prijava', 'AdminController@_prijava');
$this->post('/admin/loadip', 'AdminController@loadip');
$this->post('/admin/loadip', 'AdminController@loadip');
$this->post('/admin/sacuvajkorisnika', 'AdminController@sacuvajkorisnika');
$this->post('/admin/banujkorisnika', 'AdminController@banujkorisnika');
?>
