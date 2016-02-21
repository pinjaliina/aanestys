# Tietokantasovelluksen esittelysivu

Yleisiä linkkejä:

* [linkki sovellukseeni](https://pjalkane.users.cs.helsinki.fi/aanestys)
* [linkki dokumentaatiooni](https://github.com/pinjaliina/aanestys/tree/master/doc/dokumentaatio.pdf)

## Työn aihe

Valitsemani aihe on [Äänestys](http://advancedkittenry.github.io/suunnittelu_ja_tyoymparisto/aiheet/Aanestys.html).

* Tähän asti tehtyä (21.2.2016):
 * [Äänestysten listaussivu](http://pjalkane.users.cs.helsinki.fi/aanestys/poll).
   * Koko sovelluksen [etusivu](http://pjalkane.users.cs.helsinki.fi/aanestys) on toistaiseksi niin ikään ohjattu tänne. Lopullinen etusivu tulee olemaan ns. oma versio yksittäisen käyttäjän tarkastelusivusta, kunhan käyttöoikeuksien tarkistuksesta saadaan toteutettua autentikoinnin lisäksi myös auktorisointi.
 * Äänestysten ja niiden vaihtoehtojen tarkastelu/lisäys/muokkaus/poisto.
 * Käyttäjien lisääminen äänestyksiin ja poistaminen niistä.
 * [Käyttäjänhallinta](http://pjalkane.users.cs.helsinki.fi/aanestys/user). Pääsy kuitenkin tarkistetaan vielä toistaiseksi vain sillä tasolla, että muut näkymät kirjautumista lukuunottamatta on suljettu anonyymeilta käyttäjiltä. Mitään auktorisointitarkistuksia ei siis vielä tehdä, eli kaikilla käyttäjillä on yhtäläiset oikeudet.
   * Kirjautumista voi yrittää käyttäjätunnuksella ```pinjaliina``` ja salasanalla ```TOP SECRET```.

* Tekemättä (21.2.2016) on vielä erityisesti äänestyssivu, jolla itse äänestäminen tapahtuu, sekä äänioikeuden merkkaaminen käytetyksi.
* Joitakin muita puutteita on listattuna [tämän repon tiketeissä](https://github.com/pinjaliina/aanestys/issues). Siellä ei kuitenkaan ole listattuna vielä toteuttamattomia suuria kokonaisuuksia, vaan lähinnä pikkuasioita, joihin olisi hyvä palata myöhemmin.

* Demosivuja:
 * [kirjautumissivun demo](http://pjalkane.users.cs.helsinki.fi/aanestys/login)
 * [listasivun demo](http://pjalkane.users.cs.helsinki.fi/aanestys/poll_list)
 * [muokkaus/esittelysivun demo](http://pjalkane.users.cs.helsinki.fi/aanestys/poll_manage_options)

* [Bootstrapin (käytetty HTML/CSS/Javascript-kehys) CSS-dokumentaatio.](http://getbootstrap.com/css/) Joitakin alakohtia:
 * [typografia](http://getbootstrap.com/css/#type)
 * [taulukot](http://getbootstrap.com/css/#tables)
 * [lomakkeet](http://getbootstrap.com/css/#forms)
 * [painikkeet](http://getbootstrap.com/css/#buttons)

* Tämä ohjelmisto on lisensoitu [MIT-lisenssillä](https://github.com/pinjaliina/aanestys/LICENSE.txt).
