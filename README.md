# English summary

This is my exercise code for a University of Helsinki course called “Database Application Exercise”. It's a silly polling application with the twist that users can vote only once and saved votes are untraceable to users.

The course was in Finnish, so all the documentation in Finnish. Sorry! The code is commented in English, though. The documentation is over-extensive due to course requirements; just look to the ```sql``` subdirectory to see the DB structure.

Also, due to the course requirements, no real framework is used, but there are still some dependencies like Slim and Twig; for details, see ```composer.json```. The app assumes Apache (2.2+), Postgresql (8.4+) and PHP (5.3; newer versions might also work).

During the course there was an active demo environment, but that's no longer up. I'll just leave the code archived here for anyone interested.

Besides the issues listed on the issues page there is at least one more: accessing non-existing poll paths will crash the application. I actually got the following course feedback mentioning that bug:

”Hyvältä näytti sovellus ja pienet vähennykset otin nyt seuraavista asioista: meneminen olemattoman äänestyksen reittiiin kaataa sovelluksen kuten myös äänestyksen adminin käyttäjän muokkausnäkymässä tuskin pitäisi olla salasanaa.”

# Tietokantasovelluksen esittelysivu

### Yleisiä linkkejä

* [linkki sovellukseeni](https://pjalkane.users.cs.helsinki.fi/aanestys) EDIT: poistettu 2016–10-01
 * Käyttö edellyttää kirjautumista. Ainakin tunnuksen ```pinjaliina``` ja salasanan ```TOP SECRET``` pitäisi toimia, mikäli joku ei kyseistä tunnusta poista.
 * Jos haluaa testata sovellusta suoraan ei-ylläpidollisella tunnuksella, niin voi käyttää esim. tunnusta ```anna``` ja salasanaa ```badpass```.
* [linkki dokumentaatiooni](https://github.com/pinjaliina/aanestys/tree/master/doc/dokumentaatio.pdf)

### Työn aihe

Valitsemani aihe on [Äänestys](http://advancedkittenry.github.io/suunnittelu_ja_tyoymparisto/aiheet/Aanestys.html).

**Tilanne 28.2.2016** ja yleisiä huomioita:
* Kaiken pitäisi olla valmista ja toimia. Minulla ei joka tapauksessa ole aikaa tehdä työn eteen enempää ennen kurssin takarajaa, joten pidän tätä valmiina.
* Pari puutetta – parannuksia, ei bugeja – on listattuna [tämän repon tiketeissä](https://github.com/pinjaliina/aanestys/issues). Nuo ovat kuitenkin pikkupuutteita, enkä aio toteuttaa tällä aikataululla niitäkään, kun ne eivät kerran pakollisiin kurssivaatimuksiin kuulu, enkä ole tässä mitään huippuarvosanaa metsästämässä. Sinänsä erityyppisiä parannuksia olisi helppo keksiä nopeasti niin paljon, että pelkästään tikettien kirjoittamiseen niistä voisi käyttää tunnin.
* Koodin kommentit ja tiketit on kirjoitettu englanniksi. Tämä tiedosto ja PDF-dokumentaatio ovat suomeksi lähinnä siksi, että kaikki kurssin materiaali ja ohjeet olivat vain suomeksi. Sovelluksen käyttöliittymä on niin ikään suomeksi.

Allaolevat linkit demosivuille ja bootstrapin sivuille on listattu tässä lähinnä kurssivaatimusten vuoksi.

* Demosivuja
 * [kirjautumissivun demo](http://pjalkane.users.cs.helsinki.fi/aanestys/login)
 * [listasivun demo](http://pjalkane.users.cs.helsinki.fi/aanestys/poll_list)
 * [muokkaus/esittelysivun demo](http://pjalkane.users.cs.helsinki.fi/aanestys/poll_manage_options)

* [Bootstrapin (käytetty HTML/CSS/Javascript-kehys) CSS-dokumentaatio.](http://getbootstrap.com/css/) Joitakin alakohtia:
 * [typografia](http://getbootstrap.com/css/#type)
 * [taulukot](http://getbootstrap.com/css/#tables)
 * [lomakkeet](http://getbootstrap.com/css/#forms)
 * [painikkeet](http://getbootstrap.com/css/#buttons)

Tämä ohjelmisto on lisensoitu [MIT-lisenssillä](https://github.com/pinjaliina/aanestys/LICENSE.txt).
