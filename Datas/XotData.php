<?php

declare(strict_types=1);

namespace Modules\Xot\Datas;

use Illuminate\Database\Eloquent\Model;
use Spatie\LaravelData\Data;
use Webmozart\Assert\Assert;

/**
 * Undocumented class.
 */
final class XotData extends Data
{
    public string $main_module;
     // => 'Blog'
    public string $param_name = 'noset';

    public string $adm_home = '01';
    
    public string $adm_theme; // ' => 'AdminLTE',
    // public bool $enable_ads;//' => '1',

    public string $primary_lang = 'it';
    
    // 'pub_theme' => 'DirectoryBs5',
    public string $pub_theme;
     // ' => 'One',
    public string $search_action = 'it/videos';
    
    public bool $show_trans_key = false;
    
    public string $register_type = '0';
    
    public string $verification_type = '';
    
    public bool $login_verified = false;

    public bool $disable_frontend_dynamic_route = false;
    
    public bool $disable_admin_dynamic_route = false;

    public bool $register_adm_theme = false;
    
    public bool $register_pub_theme = false;
    
    public bool $register_collective = false;

    public ?string $super_admin = null;

    public static function make(): self
    {
        $xot = config('xra');

        if (! is_array($xot)) {
            dddx($xot);
        }

        return self::from($xot);
    }

    public function getUserClass(): string
    {
        Assert::classExists($class = config('auth.providers.users.model'), 'check config auth');

        return $class;
    }

    public function getProfileClass(): string
    {
        return 'Modules\\'.$this->main_module.'\Models\Profile';
    }

    public function getHomeController(): string
    {
        return 'Modules\\'.$this->main_module.'\Http\Controllers\HomeController';
    }

    public function getProfileModelByUserId(string $user_id): Model
    {
        $profileClass = $this->getProfileClass();

        return app($profileClass)->firstOrCreate(['user_id' => $user_id]);
    }

    public function getProfileModel(): Model
    {
        $user_id = (string) auth()->id();

        return $this->getProfileModelByUserId($user_id);
    }

    public function update(array $data): self
    {
        foreach ($data as $k => $v) {
            $this->{$k} = $v;
        }
        
        // $this->save();
        return $this;
    }

    public function save(): void
    {
        dddx('wip');
    }
}
