<?php

declare(strict_types=1);

namespace Modules\Xot\Models\Panels\Actions;

use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Nwidart\Modules\Facades\Module;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use Modules\Xot\Services\ArrayService;
use Modules\Xot\Services\ModelService;
use Illuminate\Database\QueryException;
use Modules\Theme\Services\ThemeService;

//-------- models -----------

//-------- services --------

//-------- bases -----------

/**
 * Class CloneAction.
 */
class DbAction extends XotBasePanelAction
{
    public bool $onItem = true;

    public string $icon = '<i class="fas fa-database"></i>';

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handle(){
        //k$database=config('database');
        $data=$this->getAllTablesAndFields();
        $view='xot::admin.home.acts.db';
        $model=$this->getModel();
        $model_service=ModelService::make()->setModel($model);
        $view_params=[
            'view'=>$view,
            'rows'=>$data,
            'model_service'=>$model_service,
        ];
        return view()->make($view,$view_params);

   }

   public function postHandle(){
        $search=request('search');
        $data=$this->getAllTablesAndFields();
        $data=$data->map(function($item) use($search){
            //$item['sql']=$this->makeSql($item,$search);
            return $item;
        });
        $model=$this->getModel();
        $model_service=ModelService::make()->setModel($model);

        foreach($data as $v){
            try{
                //$res=$model_service->select($v['sql']);
                $res=$model->getConnection()->table($v['name']);
                $valid=false;
                foreach($v['fields'] as $field){
                    if(in_array($field['type'],['string','text'])){
                        $res=$res->orWhere($field['name'],'like','%'.$search.'%');
                        $valid=true;
                    }
                }
                if($valid){
                    $rows=$res->limit(10);
                    $res=$rows->get();
                }

            }catch(QueryException $e){
                echo '<pre>'.$v['sql'].'</pre>';
                echo '<pre>'.$e->getMessage().'</pre>';
                dddx('a');
            } 
            if($res->count()>0 && $valid){
                echo '<hr>';
                echo '<h3>Table: '.$v['name'].'</h3>';
                echo '<h3>Search: '.$search.'</h3>';
                echo '<h3>N ['.count($res).'] Results</h3>';
                //echo '<pre>'.print_r($v['sql'],true).'</pre>';
                $sql = Str::replaceArray('?', $rows->getBindings(), $rows->toSql());
                echo '<pre>'.print_r($sql,true).'</pre>';
                echo ArrayService::make()->setArray($res->toArray())->toHtml();
                //dddx($res);
            }
            
        }
        echo '<h3>+Done Searching ['.$search.']</h3>';
   }

   /**
    * Undocumented function
    *
    * @link https://stackoverflow.com/questions/26181170/laravel-how-to-use-query-builder-dbtable-with-dbconnection
    *
    * @param [type] $item
    * @param [type] $search
    * @return void
    */
   public function makeSql($item,$search){
        //$programs=DB::connection('mysql2')->table('node')->where('type', 'Programs')->get();

        $sql='select * from '.$item['name'].'
        where ';
        $where=[];
        foreach($item['fields'] as $field){
            $name=$field['name'];
            $name='`'.addslashes($name).'`'; //test


            switch($field['type']){
                //case 'string':
                //    $where[]=$name.' like "%'.$search.'%"';
                //break;
                default:
                    $where[]=$name.' = "'.$search.'"';
                break;
            }
        }
       return $sql.'('.implode(chr(13).chr(10).' OR ', $where).') limit 10';
   }

   public function getModel(){
        $module_name=$this->panel->getModuleName();
        $cache_key=Str::slug($module_name.'_model');
        $first_model_class = Cache::rememberForever($cache_key, function () use($module_name){
            
            $module_path=Module::getModulePath($module_name);
            $module_models_path=$module_path.'/Models';
            $models=File::files($module_models_path);
            $i=0;
            $is_abstract=true;
            while($is_abstract){
                $first_model_file=$models[$i++];
                $first_model_class='Modules\\'.$module_name.'\Models\\'.Str::before($first_model_file->getBasename(),'.php');
                $reflect = new \ReflectionClass($first_model_class);
                $is_abstract=$reflect->isAbstract();
            }
            return $first_model_class;
        });
        $first_model=app($first_model_class);
        return $first_model;
   }

   public function getAllTablesAndFields():Collection{
        $first_model=$this->getModel();
        $cache_key=Str::slug(get_class($first_model).'_'.__FUNCTION__);

        $data=Cache::rememberForever($cache_key, function () use($first_model){
            
            return ModelService::make()->setModel($first_model)->getAllTablesAndFields();
        });
        return $data;
   }

}