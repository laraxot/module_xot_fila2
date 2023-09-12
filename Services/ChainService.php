<?php

declare(strict_types=1);

namespace Modules\Xot\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * https://github.com/Tinyportal/TinyPortal/blob/master/Sources/TPSubs.php.
 */

/* example to use
$ordered = chain('category_id', 'parent_id', 'category_position', $rows);

foreach($ordered as $item){
    echo str_repeat('------', $item['indent']).$item['category_name'].'<br>';
}

*/

function chain(string $primary_field, string $parent_field, string $sort_field, Collection $rows, int $root_id = 0, int $maxlevel = 25): array
{
    $c = new ChainService($primary_field, $parent_field, $sort_field, $rows, $root_id, $maxlevel);

    return $c->chain_table;
}

/**
 * Class ChainService.
 */
final class ChainService
{
    public array $table = [];

    public array $chain_table = [];

    /**
     * ChainService constructor.
     *
     * @return void
     * @param (Collection & \iterable<Model>) $rows
     */
    public function __construct(public string $primary_field, public string $parent_field, public string $sort_field, /**
     * Undocumented variable.
     *
     */
    public Collection $rows, int $root_id = 0, int $maxlevel = 25)
    {
        $this->buildChain($root_id, $maxlevel);
    }

    public function buildChain(int $rootcatid, int $maxlevel): void
    {
        foreach ($this->rows as $row) {
            // considerando che ChainService viene utilizzato da XotBasePanel->optionsTree()
            // che a sua volta viene utilizzato in FormX\Resources\views\collective\fields\select\field_parent.blade.php
            // che vuole parent_id (radice) uguale a 0
            // controllo che la row radice non abbia parent_id uguale a null, in caso...
            if (null === $row[$this->parent_field]) {
                $row[$this->parent_field] = 0;
                $row->save();
            }
            
            $this->table[$row[$this->parent_field]][$row[$this->primary_field]] = $row;
        }
        
        $this->makeBranch($rootcatid, 0, $maxlevel);
    }

    public function makeBranch(int $parent_id, int $level, int $maxlevel): void
    {
        if (! \is_array($this->table)) {
            $this->table = [];
        }
        
        // dddx([$this->table, $parent_id]);
        if (! \array_key_exists($parent_id, $this->table)) {
            return;
        }
        
        $rows = $this->table[$parent_id];
        foreach ($rows as $key => $value) {
            $rows[$key]['key'] = $this->sort_field;
        }
        
        usort($rows, fn(array $a, array $b): int => $this->chainCMP($a, $b));
        foreach ($rows as $row) {
            $row['indent'] = $level;
            $this->chain_table[] = $row;
            if (!isset($this->table[$row[$this->primary_field]])) {
                continue;
            }
            if ($maxlevel <= $level + 1 && 0 !== $maxlevel) {
                continue;
            }
            $this->makeBranch($row[$this->primary_field], $level + 1, $maxlevel);
        }
    }

    public function chainCMP(array $a, array $b): int
    {
        return $a[$a['key']] <=> $b[$b['key']];
    }
}

/*
function chainCMP($a, $b){
    if($a[$a['key']] == $b[$b['key']]){
        return 0;
    }
    return($a[$a['key']] < $b[$b['key']]) ? -1 : 1;
}
*/
