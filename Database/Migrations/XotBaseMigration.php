<?php

declare(strict_types=1);

namespace Modules\Xot\Database\Migrations;

use ReflectionClass;
use Illuminate\Database\Schema\Builder;
use Doctrine\DBAL\Schema\AbstractSchemaManager;
use Doctrine\DBAL\Schema\Table;
use Doctrine\DBAL\Schema\Index;
use Illuminate\Database\Schema\Blueprint;
use Closure;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Nwidart\Modules\Facades\Module;

// ----- models -----

/**
 * Class XotBaseMigration.
 */
abstract class XotBaseMigration extends Migration
{
    protected ?Model $model = null;

    protected ?string $model_class = null;

    // *
    public function __construct()
    {
        if (!$this->model instanceof Model) {
            $model = $this->getModel();
            // 37     Dead catch - Exception is never thrown in the try block.
            // try {
            $this->model = app($model);
            // } catch (\Exception $ex) {
            //    $res = StubService::make()->setModelClass($model)->setName('model')->get();
            //    throw new \Exception('<br><br>Table '.get_class($this).' does not have model '.$model.'<br><br>');
            // }
        }
        
        // $this->model = new $this->model();
    }

    // */

    public function getModel(): string
    {
        if (null !== $this->model_class) {
            return $this->model_class;
        }
        
        $name = class_basename($this);
        $name = Str::before(Str::after($name, 'Create'), 'Table');
        $name = Str::singular($name);
        
        $reflectionClass = new ReflectionClass($this);
        $filename = (string) $reflectionClass->getFilename();
        $mod_path = Module::getPath();

        $mod_name = Str::after($filename, $mod_path);
        $mod_name = explode(\DIRECTORY_SEPARATOR, $mod_name)[1];

        $model_ns = '\Modules\\'.$mod_name.'\Models\\'.$name;
        $model_dir = $mod_path.'/'.$mod_name.'/Models/'.$name.'.php';
        Str::replace('/', \DIRECTORY_SEPARATOR, $model_dir);

        return $model_ns;
    }

    public function getTable(): string
    {
        if (!$this->model instanceof Model) {
            return '';
        }

        return $this->model->getTable();
    }

    public function getConn(): Builder
    {
        // $conn_name=with(new MyModel())->getConnectionName();
        // \DB::reconnect('mysql');
        // dddx(config('database'));
        // \DB::purge('mysql');
        // \DB::reconnect('mysql');
        if (!$this->model instanceof Model) {
            throw new Exception('model is null');
        }

        $connectionName = $this->model->getConnectionName();

        // dddx([$this->model, $conn_name]);
        return Schema::connection($connectionName);
    }

    public function getSchemaManager(): AbstractSchemaManager
    {
        return $this->getConn()
            ->getConnection()
            ->getDoctrineSchemaManager();
    }

    /**
     * @throws \Doctrine\DBAL\Exception
     */
    public function getTableDetails(): Table
    {
        return $this->getSchemaManager()
            ->listTableDetails($this->getTable());
    }

    /**
     * @throws \Doctrine\DBAL\Exception
     *
     * @return array<Index>
     */
    public function getTableIndexes(): array
    {
        return $this->getSchemaManager()
            ->listTableIndexes($this->getTable());
    }

    /**
     * ---.
     */
    public function tableExists(string $table = null): bool
    {
        if (null === $table) {
            $table = $this->getTable();
        }

        return $this->getConn()->hasTable($table);
    }

    public function hasColumn(string $col): bool
    {
        return $this->getConn()->hasColumn($this->getTable(), $col);
    }

    /**
     * Get the data type for the given column name.
     */
    public function getColumnType(string $column): string
    {
        return $this->getConn()->getColumnType($this->getTable(), $column);
    }

    /**
     * Undocumented function.
     */
    public function isColumnType(string $column, string $type): bool
    {
        if (! $this->hasColumn($column)) {
            return false;
        }

        return $this->getColumnType($column) === $type;
    }

    /**
     * ---.
     */
    public function query(string $sql): void
    {
        $this->getConn()->getConnection()->statement($sql);
    }

    public function hasIndex(string $index, string $type = 'index'): bool
    {
        /*
        $tbl = $this->getTable();
        $conn = $this->getConn()->getConnection();
        $dbSchemaManager = $conn->getDoctrineSchemaManager();
        $doctrineTable = $dbSchemaManager->listTableDetails($tbl);
        */
        $table = $this->getTable();
        $doctrineTable = $this->getTableDetails();

        // $indexes=$this->getTableIndexes();
        return $doctrineTable->hasIndex($table.'_'.$index.'_'.$type);
    }

    public function dropIndex(string $index): void
    {
        $table = $this->getTable();
        $doctrineTable = $this->getTableDetails();
        $exists = $doctrineTable->hasIndex($table.'_'.$index);
        if ($exists) {
            $doctrineTable->dropIndex($table.'_'.$index);
        }
    }

    public function hasIndexName(string $name): bool
    {
        $doctrineTable = $this->getTableDetails();

        return $doctrineTable->hasIndex($name);
    }

    /**
     * ---.
     */
    public function hasPrimaryKey(): bool
    {
        $table_details = $this->getTableDetails();

        return $table_details->hasPrimaryKey();
    }

    public function dropPrimaryKey(): void
    {
        $table_details = $this->getTableDetails();
        $table_details->dropPrimaryKey();
        
        $sql = 'ALTER TABLE '.$this->getTable().' DROP PRIMARY KEY;';
        $this->query($sql);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $this->getConn()->dropIfExists($this->getTable());
    }

    public function tableDrop(string $table): void
    {
        $this->getConn()->dropIfExists($table);
    }

    public function rename(string $from, string $to): void
    {
        $this->getConn()->rename($from, $to);
    }

    public function renameTable(string $from, string $to): void
    {
        if ($this->tableExists($from)) {
            $this->getConn()->rename($from, $to);
        }
    }

    // da rivedere
    public function renameColumn(string $from, string $to): void
    {
        // Call to an undefined method Illuminate\Database\Schema\Builder::renameColumn().
        /**
         * @var Blueprint
         */
        $builder = $this->getConn();
        $builder->renameColumn($from, $to);
    }

    /**
     * Undocumented function.
     */
    public function tableCreate(Closure $next): void
    {
        if (! $this->tableExists()) {
            $this->getConn()->create(
                $this->getTable(),
                $next
            );
        }
    }

    /**
     * Undocumented function.
     */
    public function tableUpdate(Closure $next): void
    {
        $this->getConn()->table(
            $this->getTable(),
            $next
        );
    }
}// end XotBaseMigration
