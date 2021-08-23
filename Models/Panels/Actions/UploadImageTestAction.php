<?php

declare(strict_types=1);

namespace Modules\Xot\Models\Panels\Actions;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

//-------- models -----------

//-------- services --------

//-------- bases -----------

/**
 * Class UploadImageTest.
 *
 * https://artisansweb.net/how-to-upload-images-to-another-server-through-ftp-in-laravel/
 * https://www.youtube.com/watch?v=GCuIUjWIhlA&t=136s
 */
class UploadImageTestAction extends XotBasePanelAction {
    public bool $onItem = true;

    public bool $onContainer = true;

    /**
     * @return mixed
     */
    public function handle() {
        //$view = $this->panel->view();
        //dddx($view);
        //return ThemeService::view($view);

        //Storage::disk('dropbox')->put('file.txt', 'Contents');
        //return 'preso';
        return $this->panel->view();
    }

    public function postHandle() {
        $data = request()->all();
        //dddx(request()->file('test_image'));

        if (request()->hasFile('test_image')) {
            //get filename with extension
            $filenamewithextension = request()->file('test_image')->getClientOriginalName();

            //get filename without extension
            $filename = str_replace(' ', '', pathinfo($filenamewithextension, PATHINFO_FILENAME));
            //dddx($filename);

            //get file extension
            $extension = request()->file('test_image')->getClientOriginalExtension();

            //filename to store
            $filenametostore = $filename.'_'.uniqid().'.'.$extension;

            //Upload File to external server
            //Storage::disk('infinityfree')->put($filenametostore, $filename);
            request()->file()->store('/', 'infinityfree');

            //Store $filenametostore in the database
        }

        /*
        dddx([
            $filenametostore,
            $filename,
            $extension,
            //Storage::disk('infinityfree')->exists($filename.'.'.$extension),
            Storage::disk('infinityfree')->exists($filenametostore),
            //'/htdocs/images/'.$filenametostore,
            //Storage::disk('infinityfree')->exists('/htdocs/images/'.$filenametostore),
            //Image::make(Storage::disk('infinityfree')->get($filenametostore)),
            Storage::disk('infinityfree')->url($filenametostore),
        ]);
        */

        if (Storage::disk('infinityfree')->exists($filenametostore)) {
            /*
            try {
                $img = Image::make(Storage::disk('infinityfree')->url($filenametostore));
            } catch (\Intervention\Image\Exception\NotReadableException $e) {
                dddx('non dovrei essere qui');
            }
            dddx($img);
            */
            return $this->panel->view()->with('image', $filenametostore);
        } else {
            dddx('immagine non trovata');
        }
    }
}
