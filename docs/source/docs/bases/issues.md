---
title: Issues
description: Come Risolvere gli Errori più Comuni
extends: _layouts.documentation
section: content
---

# Come Risolvere gli Errori più Comuni {#issues}

* Errore **Secret is not set in JWTAuth**. Dalla cartella laravel:

    php artisan jwt:secret

* Errore: include(/var/www/base_BASE/laravel/vendor/composer/../../Modules/NOME_MODULO/Models/FILE.php): Failed to open stream: No such file or directory se il file esiste. Dalla cartella laravel:
    
    composer dump autoload
    alternativa: controllare se il namespace è giusto

* Target class [\Modules\BASE\Models\FILE.php] does not exist. Dalla cartella laravel:

    mettere l'esensione della migrations FILE a .old

* Errore StubService riga 418 (StubService:418). 

Significa che devi spostare il modello dal vendor al nostro modulo ed estenderlo, e cambiare in config la path nel nostro modulo.
Gli stub sono dei file da dove poi vengono generati i modelli, pannelli e altri file di partenza.

* pagina 404 

controlla le route con uno dei seguenti comandi e vedi se esistono:

    VIRTUAL_HOST.EXT/?_act=artisan&cmd=routelist1
    
    VIRTUAL_HOST.EXT/?_act=artisan&cmd=routelist

    php artisan route:list

Se vedi poche route solo di base allora devi abilitare tutti i moduli, forse anche in tutti i file modules_status.json

Se non funzionasse metti in 404.blade.php (guarda il percorso nel quale ti trovi nella debug bar) il seguente codice:

    {{ dddx(get_defined_vars()) }}

potrebbe dare una spiegazione dell’errore nella variabile message. Ad esempio se è un nuovo modulo potrebbe mancare _ModulePanel e /Policies/_ModelPanelPolicy

* *pagina 403 su un modulo

controlla su XotBasePanelPolicy home se hai l’area abilitata.

Per farlo puoi andare su pagina 403 e fare:

    @php
        dddx($profile->hasArea('NOME_AREA'));
    @endphp

* The "/var/www/html/BASE/laravel/Modules/Test/Providers/../Http/Livewire" directory does not exist

Aggiungere la cartella nel MODULO/Http/Livewire con dentro il file .gitkeep

* file_put_contents(/var/www/html/BASE/laravel/Modules/Test/Providers/../Http/Livewire/_components.json): Failed to open stream: Permission denied 

    sudo chmod PERMESSI_CORRETTI -R .

* Errore: Livewire encountered corrupt data when trying to hydrate the [modules.MODULO.http.livewire.form.nexi.payment] component. 

Ensure that the [name, id, data] of the Livewire component wasn't tampered with between requests.

Vedere di non aver passato dati name, id e data o variabili riservate

Analizzare che parametri siano stati passati con la richiesta.

IMPORTANTE: sui modal pro non serve il mount, basta dichiarare le variabili nella classe e passarli come public tramite l’emit

* Errore “Unable to call component method. Public method [METODO] not found on component: [COMPONENTE ESTESO]” 

Il div nella view potrebbe non essere stato chiuso correttamente, o potrebbe essere stato chiuso due volte. Formattare view e controllare

* Errore Cannot declare interface Modules\MODULO\Contracts\PanelContract, because the name is already in use, se non è vero che è già in uso il nome
Dalla cartella laravel:

    composer dumpautoload

* Se lavorando con l’assegnazione dei ruoli hai l’errore “The given role or permission should use guard `` instead of `web`” a volte può essere risolto mettendo nel modello che ha il ruolo da associare:

    protected $guard_name = 'web';
