---
title: Installazione
description: Come Installare la Base
extends: _layouts.documentation
section: content
---

# Installazione {#installazione}

* Clonare la base in locale nella cartella del server, scaricando i submodules, e senza la storia delle modifiche

    git clone https://base.git –recurse-submodules –depth=1

* dalla cartella "laravel" creare il file delle variabili d'ambiente .env 
    
    cp .env.latest .env
    modificare parametri a seconda delle necessità
    dopo aver messo i nomi dei database, in phpmyadmin creare i database vuoti

* dalla cartella laravel, lanciare in bash il comando

    composer init
    alternativa: composer update
    
    cd Modules/Xot/Services
    composer install
    php artisan key:generate

* vedere la lista dei moduli con il comando

    da url: VIRTUAL_HOST.EXT/?_act=artisan&cmd=module-list
    php artisan module:list 

* abilitare tutti i moduli con il comando

    da url: VIRTUAL_HOST.EXT/?_act=artisan&cmd=module-enable&module=NOME_MODULO
    php artisan module:enable NomeModulo

* fare la migration

    da url: VIRTUAL_HOST.EXT/?_act=artisan&cmd=migrate
    in alternativa provare php artisan migrate

* per compilare il tema (da dentro la cartella laravel/Themes/NOME_TEMA)

    npm install (dove ci sono file package.json)
    npm run dev (se bisogna compilare il tema)

* a questo punto bisogna crearsi il virtual host con il nome del dominio uguale a quello del file di configurazione. Esempio:

    copio la cartella laravel/config/localhost in laravel/config/local/dominio/* e imposto i parametri nei file

    questo significa che il virtual host deve chiamarsi dominio.local

* **IMPORTANTISSIMO** per sincronizzare la base si utilizzano i famosi TRE FILES. 

Questi file si trovano nella cartella BASE/bashscripts.

Vanno lanciati dalla cartella della root della BASE.

Si utilizzano così:

- ./bashscripts/git_pull.sh && ./bashscripts/git_branch.sh per fare il pull
- ./bashscripts/git_pull.sh && ./bashscripts/git_branch.sh per fare il push

Dopo aver fatto push, siccome su git ci sono delle azioni che possono modificare i file, bisogna rilanciare subito il pull, come scritto sopra

* TIPS

Altri trucchi e sistemi per risolvere errori o installare server sono scritti nella cartella ./bashscripts/tips/

* FORMATTAZIONE DEL CODICE

Per formattare il codice in modo corretto bisogna usare cs-fixer global. Per installarlo seguire le istruzioni nel seguente file:

    bashscripts/tips/cs-fixer.txt

* BACKUP DEL PROGETTO

E' possibile fare un backup del progetto con il file

    ./bashscripts/backup.sh