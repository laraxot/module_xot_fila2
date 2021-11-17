<?php

declare(strict_types=1);

namespace Modules\Xot\Services;

use Doctrine\DBAL\Schema\Column;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Modules\Xot\Contracts\PanelContract;

/**
 * Class StubService.
 */
class StubService {
    //-- model (object) or class (string)
    //-- stub_name name of stub
    //-- create yes or not
    private static ?self $_instance = null;

    //public ?Model $model;

    public string $model_class;

    public string $name;

    /**
     * getInstance.
     *
     * this method will return instance of the class
     */
    public static function getInstance() {
        if (! self::$_instance) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public static function setName(string $name): self {
        $instance = self::getInstance();
        $instance->name = $name;

        return $instance;
    }

    public static function setModel(Model $model): self {
        $instance = self::getInstance();
        $instance->model_class = get_class($model);

        return $instance;
    }

    public static function setModelClass(string $model_class): self {
        $instance = self::getInstance();
        $instance->model_class = $model_class;

        return $instance;
    }

    public function get() {
        $file = $this->getClassFile();
        $class = $this->getClass();

        if (File::exists($file)) {
            return $class;
        }
        $this->generate();

        return $class;
    }

    public function getNamespace(): string {
        return dirname($this->getClass());
    }

    public function getModel(): Model {
        return app($this->model_class);
    }

    public function getReplaces(): array {
        $model = $this->getModel();
        $dummy_id = $model->getRouteKeyName();
        $search = [];
        $fields = self::fields($model);
        /*
        dddx(
            [
                'fillable' => $this->getFillable(),
                'columns' => $this->getColumns(),
                'factories' => $this->getFactories(),
            ]
        );
        */
        //$columns = $this->getColumns();
        //dddx($columns);
        //$factories = $this->getFactories();
        //dddx($factories);

        $replaces = [
            'DummyNamespace' => $this->getNamespace(),
            'DummyClass' => basename($this->getClass()),
            'DummyModelClass' => basename($this->model_class),
            'DummyFullModel' => $this->getClass(),
            'dummy_id' => $dummy_id,
            'dummy_title' => 'title', // prendo il primo campo stringa
            'dummy_search' => var_export($search, true),
            'dummy_fields' => var_export($fields, true),
            'dummy_factories' => $this->getFactories(),
            'NamespacedDummyUserModel' => 'Modules\LU\Models\User',
            'NamespacedDummyModel' => $this->model_class,
        ];

        return $replaces;
    }

    public function getFactories() {
        return $this->getColumns()
            ->map(
                function (Column $column) {
                    return $this->mapTableProperties($column);
                    //return $this->getPropertiesFromMethods();
                }
            )->collapse()
            ->values()
            ->implode(',
            ')
            ;
    }

    /**
     * Maps properties.
     */
    protected function mapTableProperties(Column $column): array {
        $key = $column->getName();
        /*
        if (! $this->shouldBeIncluded($column)) {
            return $this->mapToFactory($key);
        }
        */
        /*
        if ($column->isForeignKey()) {
            return $this->mapToFactory(
                $key,
                $this->buildRelationFunction($key)
            );
        }
        */

        if ('password' === $key) {
            return $this->mapToFactory($key, "Hash::make('password')");
        }

        /*
        $value = $column->isUnique()
            ? '$this->faker->unique()->'
            : '$this->faker->';
        */
        $value = '$this->faker->';

        return $this->mapToFactory($key, $value.$this->mapToFaker($column));
    }

    /**
     * Checks if a given column should be included in the factory.
     */
    protected function shouldBeIncluded(Column $column) {
        $shouldBeIncluded = ($column->getNotNull() /*|| $this->includeNullableColumns */)
            && ! $column->getAutoincrement();

        if (! $this->getModel()->usesTimestamps()) {
            return $shouldBeIncluded;
        }

        $timestamps = [
            $this->getModel()->getCreatedAtColumn(),
            $this->getModel()->getUpdatedAtColumn(),
        ];

        if (method_exists($this->getModel(), 'getDeletedAtColumn')) {
            $timestamps[] = $this->getModel()->getDeletedAtColumn();
        }

        return $shouldBeIncluded
            && ! in_array($column->getName(), $timestamps);
    }

    protected function mapToFactory($key, $value = null): array {
        return [
            $key => is_null($value) ? $value : "'{$key}' => $value",
        ];
    }

    /**
     * Map name to faker method.
     *
     * @return string
     */
    protected function mapToFaker(Column $column) {
        return app(TypeGuesser::class)->guess(
            $column->getName(),
            $column->getType(),
            $column->getLength()
        );
    }

    public function getFillable(): \Illuminate\Support\Collection {
        $model = $this->getModel();
        if (! method_exists($model, 'getFillable')) {
            return [];
        }
        $fillables = $model->getFillable();
        if (0 == count($fillables)) {
            $fillables = $model->getConnection()->getSchemaBuilder()->getColumnListing($model->getTable());
        }

        $fillables = collect($fillables)
            ->except([
                'created_at', 'updated_at', 'updated_by', 'created_by', 'deleted_at', 'deleted_by',
                'deleted_ip', 'created_ip', 'updated_ip',
            ]);

        return $fillables;
    }

    public function getColumns() {
        $model = $this->getModel();
        $conn = $model->getConnection();
        $platform = $conn->getDoctrineSchemaManager()->getDatabasePlatform();
        $platform->registerDoctrineTypeMapping('enum', 'string');

        return $this->getFillable()->map(
            function ($input_name) use ($conn, $model) {
                try {
                    $table_name=$conn->getTablePrefix().$model->getTable();
                    return $conn->getDoctrineColumn($table_name, $input_name);
                } catch (\Exception $e) {
                    dddx([
                        'message'=>$e->getMessage(),
                        'name'=>$this->name,
                        'modelClass'=>$this->model_class,
                        'e'=>$e,
                        ]);
                    //return null;
                }
            }
        );
    }

    /**
     * sarebbe create ma in maniera fluent.
     */
    public function generate() {
        $stub_file = __DIR__.'/../Console/stubs/'.$this->name.'.stub';
        $stub = File::get($stub_file);
        $replace = $this->getReplaces();

        $stub = str_replace(array_keys($replace), array_values($replace), $stub);
        $file = $this->getClassFile();

        // dddx($stub);
        File::put($file, $stub);
        $msg = (' ['.$file.'] is under creating , refresh page');

        \Session::flash($msg);
    }

    public function getClassName(): string {
        return class_basename($this->model_class);
    }

    public function getDirModel(): string {
        $autoloader_reflector = new \ReflectionClass($this->model_class);
        //dddx($autoloader_reflector);
        $class_file_name = $autoloader_reflector->getFileName();
        if (false === $class_file_name) {
            throw new \Exception('autoloader_reflector false');
        }

        return dirname($class_file_name);
    }

    public function getClass(): string {
        switch ($this->name) {
            case 'factory':
                return Str::replace('\Models\\', '\Database\Factories\\', $this->model_class).'Factory';
            case 'migration_morph_pivot':
                return '';
            case 'morph_pivot':
                return '';
            case 'repository':
                return Str::replace('\Models\\', '\Repositories\\', $this->model_class).'Repository';
            case 'transformer_collection':
                return Str::replace('\Models\\', '\Transformers\\', $this->model_class).'Collection';
            case 'transformer_resource':
                return Str::replace('\Models\\', '\Transformers\\', $this->model_class).'Resource';
            case 'policy':
                return dirname($this->model_class).'\\Policies\\'.class_basename($this->model_class).'Policy';
            case 'panel':
                return dirname($this->model_class).'\\Panels\\'.class_basename($this->model_class).'Panel';
            default:
                $msg = '['.$this->name.'] Unkwon !['.__LINE__.']['.basename(__FILE__).']';
                //dddx($msg);
                throw new \Exception($msg);
        }
    }

    public function getClassFile(): string {
        $class_name = $this->getClassName();
        $dir = $this->getDirModel();
        /*
        dddx([
            'class_name' => $class_name, //Comment
            'dir' => $dir,              //F:\var\www\base_ptvx\laravel\Modules\Blog\Models
        ]);
        */
        switch ($this->name) {
            case 'factory':
                return $dir.'/../Database/Factories/'.$class_name.'Factory.php';

            case 'migration_morph_pivot':
                return $dir.'/../Database/Migrations/'.date('Y_m_d_Hi00').'_create_'.Str::snake($class_name).'_table.php';

            case 'morph_pivot':
                return $dir.'/'.$class_name.'Morph.php';

            case 'repository':
                return $dir.'/../Repositories/'.$class_name.'Repository.php';

            case 'transformer_collection':
                return $dir.'/../Transformers/'.$class_name.'Collection.php';

            case 'transformer_resource':
                return $dir.'/../Transformers/'.$class_name.'Resource.php';
            case 'policy':
                return $dir.'/Policies/'.$class_name.'Policy.php';
            case 'panel':
                 return $dir.'/Panels/'.$class_name.'Panel.php';
            default:
                $msg = '['.$this->name.'] Unkwon !['.__LINE__.']['.basename(__FILE__).']';
                throw new \Exception($msg);
        }
    }

    /**
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     * @throws \ReflectionException
     *
     * @return false|string|void
     */
    public static function fromModel(array $params) {
        extract($params);

        if (! isset($model)) {
            dddx(['err' => 'model is missing']);

            return;
        }
        if (! isset($stub)) {
            dddx(['err' => 'stub is missing']);

            return;
        }

        if (! is_object($model)) {
            //dddx($model);
            return false;
        }
        $class = get_class($model);
        $class_name = class_basename($model);
        $class_ns = substr($class, 0, -(strlen($class_name) + 1));
        $params['class'] = $class;
        $params['class_name'] = $class_name;
        $params['namespace'] = $class_ns;
        $params['namespace_root'] = substr($params['namespace'], 0, -(strlen('Models') + 1));
        /*
        if(!isset($model)){ // Cannot instantiate abstract class Modules\Food\Models\BaseModel
        $model=new $class;
        $params['model']=$model;
        }
         */
        //$params['dir']=realpath(__DIR__.'/../..');
        $autoloader_reflector = new \ReflectionClass($class);
        //dddx($autoloader_reflector);
        $class_file_name = $autoloader_reflector->getFileName();
        if (false === $class_file_name) {
            throw new \Exception('autoloader_reflector false');
        }
        $dir = dirname($class_file_name);
        $params['dir'] = $dir;
        //$params['dummy_id']=with(new $class)->getRouteKeyName();
        $params['dummy_id'] = '';
        $params['search'] = [];
        $params['fields'] = [];
        //dddx($params);
        $stub_name = $stub;
        $file = '';
        switch ($stub_name) {
            case 'factory':
                $file = $dir.'/../Database/Factories/'.$class_name.'Factory.php';
                $file = str_replace(['\\', '/'], [DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR], $file);
                $params['namespace'] = $params['namespace_root'].'\Database\Factories';
                $params['class_name'] = $params['class_name'].'Factory';
                break;
            case 'migration_morph_pivot':
                $file = $dir.'/../Database/Migrations/'.date('Y_m_d_Hi00').'_create_'.Str::snake($class_name).'_table.php';
                break;
            case 'morph_pivot':
                $file = $dir.'/'.$class_name.'Morph.php';
                $file = str_replace(['\\', '/'], [DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR], $file);
                $params['namespace'] = $params['namespace_root'].'\Models';
                $params['class_name'] = $params['class_name'].'Morph';
                /*
                $msg=[
                    'file'=>$file,
                    'model'=>$model,
                    'class_name'=>$class_name,
                ];
                dddx($msg);
                dddx(get_class($model));
                */
                /*
                $file = $dir . '/' . $class_name . '.php';
                self::missingClass([
                    'class' => $class,
                    'stub' => 'migration_morph_pivot',
                    'model' => $model,
                ]);
                */
                break;
            case 'repository':
                $file = $dir.'/../Repositories/'.$class_name.'Repository.php';
                $params['namespace'] = $params['namespace_root'].'\Repositories';
                $params['class_name'] = $params['class_name'].'Repository';
                break;
            case 'transformer_collection':
                $file = $dir.'/../Transformers/'.$class_name.'Collection.php';
                $file = str_replace(['\\', '/'], [DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR], $file);
                $params['namespace'] = $params['namespace_root'].'\Transformers';
                $params['class_name'] = $params['class_name'].'Collection';
                break;
            case 'transformer_resource':
                $file = $dir.'/../Transformers/'.$class_name.'Resource.php';
                $file = str_replace(['\\', '/'], [DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR], $file);
                $params['namespace'] = $params['namespace_root'].'\Transformers';
                $params['class_name'] = $params['class_name'].'Resource';
                break;
            case 'policy':
                $file = $dir.'/Policies/'.$class_name.'Policy.php';
                $file = str_replace(['\\', '/'], [DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR], $file);
                $params['namespace'] = $params['namespace_root'].'\Models\Policies';
                $params['class_name'] = $params['class_name'].'Policy';
                break;
            default:
                dddx(['['.$stub_name.'] Unkwonn !']);
                break;
        }

        $class_full = $params['namespace'].'\\'.$params['class_name'];

        if (File::exists($file)) {
            return $class_full;
        }
        /*
        if(class_exists($class_full)){ //Cannot instantiate abstract class Modules\Food\Models\BaseModel
        return $class_full;
        }
         */

        $stub_file = __DIR__.'/../Console/stubs/'.$stub_name.'.stub';
        $stub = File::get($stub_file);
        $replace = self::replaces($params);
        $stub = str_replace(array_keys($replace), array_values($replace), $stub);

        //dddx($file);

        //dddx($stub);
        //dddx($autoloader_reflector);
        //dddx($params);
        //

        File::put($file, $stub);
        $msg = (' ['.$class.'] is under creating , refresh page');

        \Session::flash($msg);
    }

    /**
     * @param Model $model
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     * @throws \ReflectionException
     */
    public static function getByModel($model, string $name, bool $create = false): PanelContract {
        if (! is_object($model)) {
            //echo '<h3>Model: ['.$model.']</h3>';
            //$params = optional(\Route::current())->parameters();
            throw new Exception('model is not an object');
            //return null;
        }
        $class_full = get_class($model);
        $class_name = class_basename($model);
        //$class=Str::before($class_full,$class_name);
        $class = substr($class_full, 0, -strlen($class_name));
        $panel = $class.Str::plural(Str::studly($name)).'\\'.$class_name.Str::studly($name);
        if (! class_exists($panel)) {
            self::create($model, $name);
        }

        return app($panel);
    }

    public static function replaces(array $params): array {
        extract($params);
        if (! isset($namespace)) {
            throw new \Exception('namespace is missing');
        }
        if (! isset($class_name)) {
            throw new \Exception('class_name is missing');
        }
        if (! isset($class)) {
            throw new \Exception('class is missing');
        }
        if (! isset($dummy_id)) {
            throw new \Exception('dummy_id is missing');
        }
        if (! isset($search)) {
            throw new \Exception('search is missing');
        }
        if (! isset($fields)) {
            throw new \Exception('fields is missing');
        }
        $replaces = [
            'DummyNamespace' => $namespace,
            'DummyClass' => $class_name,
            'DummyFullModel' => $class,
            'dummy_id' => $dummy_id,
            'dummy_title' => 'title', // prendo il primo campo stringa
            'dummy_search' => var_export($search, true),
            'dummy_fields' => var_export($fields, true),
            'NamespacedDummyUserModel' => 'Modules\LU\Models\User',
            'NamespacedDummyModel' => $class,
        ];

        return $replaces;
    }

    /**
     * @param Model $model
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     * @throws \ReflectionException
     */
    public static function create($model, string $name): void {
        $class_full = get_class($model);
        $class_name = class_basename($model);
        //$class=Str::before($class_full,$class_name);
        $class = substr($class_full, 0, -strlen($class_name));
        $panel_namespace = $class.Str::plural(Str::studly($name));
        $panel = $panel_namespace.'\\'.$class_name.Str::studly($name);
        //---- creazione panel
        $autoloader_reflector = new \ReflectionClass($model);

        $class_filename = $autoloader_reflector->getFileName();
        if (false === $class_filename) {
            throw new \Exception('autoloader_reflector err');
        }
        $model_dir = dirname($class_filename); // /home/vagrant/code/htdocs/lara/multi/laravel/Modules/LU/Models
        $stub_file = __DIR__.'/../Console/stubs/'.$name.'.stub';
        $stub = File::get($stub_file);

        $search = [];
        $fields = self::fields($model);

        $dummy_id = $model->getRouteKeyName();
        /*
        Call to function is_array() with string will always evaluate to false.
        if (is_array($dummy_id)) {
            echo '<h3>not work with multiple keys</h3>';
            $dummy_id = var_export($dummy_id, true);
        }
        */
        $replace = [
            'DummyNamespace' => $panel_namespace,
            'DummyClass' => $class_name.Str::studly($name),
            'DummyFullModel' => $class_full,
            'dummy_id' => $dummy_id,
            'dummy_title' => 'title', // prendo il primo campo stringa
            'dummy_search' => var_export($search, true),
            'dummy_fields' => var_export($fields, true),
            'NamespacedDummyUserModel' => 'Modules\LU\Models\User',
            'NamespacedDummyModel' => get_class($model),
        ];
        $stub = str_replace(array_keys($replace), array_values($replace), $stub);
        $stub = str_replace('stdClass::__set_state', '(object)', $stub);
        //$stub=str_replace('  ','    ',$stub);
        //$stub=str_replace(chr(13),chr(13).'    ',$stub);
        //$stub=str_replace(chr(10),chr(10).'    ',$stub);

        $panel_dir = $model_dir.'/'.Str::plural(Str::studly($name));
        File::makeDirectory($panel_dir, $mode = 0777, true, true);
        $panel_file = $panel_dir.'/'.$class_name.Str::studly($name).'.php';
        $panel_file = str_replace(['/', '\\'], [DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR], $panel_file);
        if (! File::exists($panel_file)) {
            File::put($panel_file, $stub);
        } else {
            echo '<h3>['.$panel_file.'] Just exists</h3>';
            dddx(debug_backtrace());
        }
    }

    /**
     * @param Model $model
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public static function fields($model): array {
        if (! method_exists($model, 'getFillable')) {
            return [];
        }
        $fillables = $model->getFillable();
        if (0 == count($fillables)) {
            $fillables = $model->getConnection()->getSchemaBuilder()->getColumnListing($model->getTable());
            $fillables = collect($fillables)->except([
                'created_at', 'updated_at', 'updated_by', 'created_by', 'deleted_at', 'deleted_by',
                'deleted_ip', 'created_ip', 'updated_ip',
            ])->all();
            $autoloader_reflector = new \ReflectionClass($model);
            $class_filename = $autoloader_reflector->getFileName();
            if (false === $class_filename) {
                throw new \Exception('autoloader_reflector err');
            }
            $fillables_str = chr(13).chr(10).'    protected $fillable=[\''.implode("','", $fillables)."'];".chr(13).chr(10);
            $class_content = File::get($class_filename);
            $class_content_before = Str::before($class_content, '{');
            $class_content_after = Str::after($class_content, '{');
            $class_content_new = $class_content_before.'{'.$fillables_str.$class_content_after;
            File::put($class_filename, $class_content_new);
        }
        $fields = [];
        foreach ($fillables as $input_name) {
            $tmp = new \stdClass();
            try {
                $col = $model->getConnection()->getDoctrineColumn($model->getTable(), $input_name); //->getType();//->getName();
                //dddx(get_class_methods($col->getType()));
                $type = $col->getType();
                /*
                dddx([
                    //$type->getSQLDeclaration(),
                    //$type->getType(),
                    $type->getTypesMap(),
                    $type->getName(),
                    $type->getTypeRegistry(),
                    $type->getBindingType(),
                    //$type->getMappedDatabaseTypes(),
                ]);
                */
                if ($col->getAutoincrement()) {
                    $tmp->type = 'Id';
                } else {
                    $tmp->type = Str::studly($col->getType()->getName());
                    $tmp->type = str_replace('\\', '', $tmp->type);
                }
                $tmp->name = $input_name;
                if ($col->getNotnull() && ! $col->getAutoincrement()) {
                    $tmp->rules = 'required';
                }
                $tmp->comment = $col->getComment();
            } catch (\Exception $e) {
                //$input_type='Text';
                //$tmp=new \stdClass();
                $tmp->type = 'Text';
                $tmp->name = $input_name;
                $tmp->comment = 'not in Doctrine';
            }

            $fields[] = $tmp;
            //debug_getter_obj(['obj'=>$col]);
            /*
            #_type: IntegerType {#983}
            #_length: null
            #_precision: 10
            #_scale: 0
            #_unsigned: true
            #_fixed: false
            #_notnull: true
            #_default: null
            #_autoincrement: true
            #_platformOptions: []
            #_columnDefinition: null
            #_comment: null
            #_customSchemaOptions: []
            #_name: "id"
            #_namespace: null
            #_quoted: false
             */

            /*
        $tmp=new \stdClass();
        $tmp->type=(string)$input_type;
        $tmp->name=$input_name;
        $fields[]=$tmp;
         */
        }

        return $fields;
    }

    /**
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     * @throws \ReflectionException
     */
    public static function updatePanel(array $params): void {
        extract($params);
        if (! isset($func)) {
            dddx(['err' => 'func is missing']);

            return;
        }
        if (! isset($panel)) {
            dddx(['err' => 'panel is missing']);

            return;
        }
        $func_file = __DIR__.'/../Console/stubs/panels/'.$func.'.stub';
        $func_stub = File::get($func_file);
        $autoloader_reflector = new \ReflectionClass($panel);
        $panel_file = $autoloader_reflector->getFileName();
        if (false === $panel_file) {
            throw new \Exception('autoloader_reflector err');
        }
        $panel_stub = File::get($panel_file);
        $panel_stub = Str::replaceLast('}', $func_stub.chr(13).chr(10).'}', $panel_stub);
        File::put($panel_file, $panel_stub);
    }
}