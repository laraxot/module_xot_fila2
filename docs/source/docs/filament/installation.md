---
title: Installazione Filament
description: Installazione Filament
extends: _layouts.documentation
section: content
---

# Installazione Filament {#installazione-filament}

- composer require filament/filament

- php artisan vendor:publish --tag=filament-config

- php artisan migrate

- composer require artmin96/filament-jet:*

- php artisan filament-jet:install --teams

- npm run dev

- npm run build

- php artisan migrate

- php artisan vendor:publish --tag="filament-jet-views"

- mettere in composer 

```bash
"repositories": [
    {
        "type": "path",
        "url": "./packages/ArtMin96/FilamentJet"
    }
],
```

- nella cartella /packages/ArtMin96/FilamentJet git submodule add https://github.com/laraxot/filament-jet.git FilamentJet

- nella cartella /laravel/Modules/ git submodule add https://github.com/laraxot/module-user.git User

- disabilitare tutti i moduli (soprattutto Cms)

- su xra disabilitare routes frontend e backend

```bash
'disable_admin_dynamic_route' => true,
'disable_frontend_dynamic_route' => true,
```

- composer require savannabits/filament-modules versione 1.1

- php artisan module:use Modulo
- 
- php artisan module:make-filament-context Filament


- vedi doc savanna e crea le resource con:

```bash
#Page: Pass the Module name as an argument and the name of page.
php artisan module:make-filament-page {module?} {name?} {--R|resource=} {--T|type=} {--F|force}

#Resources: Pass the Module name as an argument and the name of resources.
php artisan module:make-filament-resource {module?} {name?} {--soft-deletes} {--view} {--G|generate} {--S|simple} {--F|force}

#Widgets: Pass the Module name as an argument and the name of widget.
php artisan module:make-filament-widget {module?} {name?} {--R|resource=} {--C|chart} {--T|table} {--S|stats-overview} {--F|force}

#RelationManagers: Pass the Module name as an argument and the name of RelationManager.
php artisan module:make-filament-relation-manager {module?} {resource?} {relationship?} {recordTitleAttribute?} {--attach} {--associate} {--soft-deletes} {--view} {--F|force}
```

- aggiungi Traits di Savanna alle resource:

namespace YourNamespace\Resources;

use Savannabits\FilamentModules\Concerns\ContextualResource;
use Filament\Resources\Resource;

```bash
class UserResource extends Resource
{
    use ContextualResource;
}

```

- php artisan make:filament-user per creare utente