# Tietokantasovelluksen esittelysivu

Yleisiä linkkejä:

* [linkki sovellukseeni](https://pjalkane.users.cs.helsinki.fi/aanestys)
* [linkki dokumentaatiooni](https://github.com/pinjaliina/aanestys/tree/master/doc/dokumentaatio.pdf)

## Työn aihe

Valitsemani aihe on [Äänestys](http://advancedkittenry.github.io/suunnittelu_ja_tyoymparisto/aiheet/Aanestys.html).

* Tähän asti tehtyä (15.2.2016):
 * [Äänestysten listaussivu](http://pjalkane.users.cs.helsinki.fi/aanestys/poll).
   * Koko sovelluksen [etusivu](http://pjalkane.users.cs.helsinki.fi/aanestys) on toistaiseksi niin ikään ohjattu tänne.
    * Myös yksittäisen äänestyksen listaussivu toimii, mutta lisäys/muokkaus/poisto ovat vielä osittain kesken. Tämän mallin näkymien kautta kontrolloidaan myös äänestyksen vaihtoehtoja ja annettuja ääniä, joten niiden rakentaminen ei ole ihan yhtä yksinkertaista kuin käyttäjämallin osin dynaamisine lomakkeineen ja useamman tietokohteen malleihin viittaavine controllereineen.
 * [Käyttäjänhallinta](http://pjalkane.users.cs.helsinki.fi/aanestys/user). Koko ns. CRUD-nelikko periaatteessa toimii, ~~mutta mitään käyttöoikeuksien tarkistusta tai syötteiden validointia ei vielä ole toteutettu~~ syötteiden validointi on toteutettu, ja pääsy tarkistetaan sillä tasolla, että muut näkymät kirjautumista lukuunottamatta on suljettu anonyymeilta käyttäjiltä, mutta mitään auktorisointia ei vielä tarkisteta, eli kaikilla käyttäjillä on samat oikeudet.
   * Kirjautumista voi yrittää käyttäjätunnuksella ```pinjaliina``` ja salasanalla ```TOP SECRET```.

* Demosivuja:
 * [kirjautumissivun demo](http://pjalkane.users.cs.helsinki.fi/aanestys/login)
 * [listasivun demo](http://pjalkane.users.cs.helsinki.fi/aanestys/poll_list)
 * [muokkaus/esittelysivun demo](http://pjalkane.users.cs.helsinki.fi/aanestys/poll_manage_options)

* [Bootstrapin (käytetty HTML/CSS/Javascript-kehys) CSS-dokumentaatio.](http://getbootstrap.com/css/) Joitakin alakohtia:
 * [typografia](http://getbootstrap.com/css/#type)
 * [taulukot](http://getbootstrap.com/css/#tables)
 * [lomakkeet](http://getbootstrap.com/css/#forms)
 * [painikkeet](http://getbootstrap.com/css/#buttons)

