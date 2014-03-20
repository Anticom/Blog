#Demo Projekt zur Verdeutlichung des MVC Pattern und diversen Tools

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/Anticom/Blog/badges/quality-score.png?s=5ce7987fa49cedbce4af1a48a2c6acb8bb0f6c9a)](https://scrutinizer-ci.com/g/Anticom/Blog/)
[![Code Coverage](https://scrutinizer-ci.com/g/Anticom/Blog/badges/coverage.png?s=6dc81a533147609a87d56b41599057fe44cb7d74)](https://scrutinizer-ci.com/g/Anticom/Blog/)

Abschlussarbeit ITK 2014

##Installation

###Repository clonen
    git clone https://github.com/Anticom/Blog.git

###Abhängigkeiten installieren
    composer install
    cd src/Anticom/ShowcaseBundle/Resources
    bower install

###Assets installieren
    php app/console assets:install

###Datenbank und Schema anlegen
    php app/console doctrine:database:create
    php app/console doctrine:schema:create

###Fixtures laden (optional)
    php app/console doctrine:fixtures:load

###Vagrant Box starten (optional)
    vagrant up
    rm index.html   //durch die apache installation erzeugte index.html datei... die brauchen wir nicht

Folgenden Eintrag zur hosts Datei hinzufügen:

    #vagrant dev
    192.168.56.101	local.dev

Jetzt kann die VM im browser über http://local.dev erreicht werden.