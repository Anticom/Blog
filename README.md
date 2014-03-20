#Demo Projekt zur Verdeutlichung des MVC Pattern und diversen Tools

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