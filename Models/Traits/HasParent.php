<?php
/**
 * @see https://github.com/lazychaser/laravel-nestedset/blob/v5/src/NodeTrait.php
 */

declare(strict_types=1);

namespace Modules\Xot\Models\Traits;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Arr;
use Kalnoy\Nestedset\AncestorsRelation;
use Kalnoy\Nestedset\Collection;
use Kalnoy\Nestedset\DescendantsRelation;
use Kalnoy\Nestedset\NestedSet;
use Kalnoy\Nestedset\QueryBuilder;

trait HasParent
{
    public static Carbon $deletedAt;

    /**
     * Keep track of the number of performed operations.
     */
    public static int $actionsPerformed = 0;
<<<<<<< HEAD

=======
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
    /**
     * Pending operation.
     */
    protected array $pending = [];

    /**
     * Whether the node has moved since last save.
     */
    protected bool $moved = false;

    /**
     * @return self
     */
<<<<<<< HEAD
    public static function scoped(array $attributes): QueryBuilder
    {
        $static = new static();

        $static->setRawAttributes($attributes);

        return $static->newScopedQuery();
=======
    public static function scoped(array $attributes)
    {
        $instance = new static();

        $instance->setRawAttributes($attributes);

        return $instance->newScopedQuery();
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
    }

    /**
     * {@inheritdoc}
     *
     * Use `children` key on `$attributes` to create child nodes.
     */
    public static function create(array $attributes = [], self $parent = null)
    {
        $children = Arr::pull($attributes, 'children');

<<<<<<< HEAD
        $static = new static($attributes);

        if ($parent instanceof \Modules\Xot\Models\Traits\HasParent) {
            $static->appendToNode($parent);
        }

        $static->save();
=======
        $instance = new static($attributes);

        if ($parent) {
            $instance->appendToNode($parent);
        }

        $instance->save();
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a

        // Now create children
        $relation = new EloquentCollection();

        foreach ((array) $children as $child) {
<<<<<<< HEAD
            $relation->add($child = static::create($child, $static));

            $child->setRelation('parent', $static);
        }

        $static->refreshNode();

        return $static->setRelation('children', $relation);
=======
            $relation->add($child = static::create($child, $instance));

            $child->setRelation('parent', $instance);
        }

        $instance->refreshNode();

        return $instance->setRelation('children', $relation);
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
    }

    /**
     * Refresh node's crucial attributes.
     */
    public function refreshNode(): void
    {
        if (! $this->exists || 0 === static::$actionsPerformed) {
            return;
        }

        $attributes = $this->newNestedSetQuery()->getNodeData($this->getKey());

        $this->attributes = array_merge($this->attributes, $attributes);
    }

    /**
     * Relation to the parent.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(static::class, $this->getParentIdName())
            ->setModel($this);
    }

    /**
     * Relation to children.
     */
    public function children(): HasMany
    {
        return $this->hasMany(static::class, $this->getParentIdName())
            ->setModel($this);
    }

    /**
     * Get query for descendants of the node.
     */
    public function descendants(): DescendantsRelation
    {
        return new DescendantsRelation($this->newQuery(), $this);
    }

    /**
     * Get query for siblings of the node.
     */
    public function siblings(): QueryBuilder
    {
        return $this->newScopedQuery()
            ->where($this->getKeyName(), '<>', $this->getKey())
            ->where($this->getParentIdName(), '=', $this->getParentId());
    }

    /**
     * Get the node siblings and the node itself.
<<<<<<< HEAD
=======
     *
     * @return QueryBuilder
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
     */
    public function siblingsAndSelf(): QueryBuilder
    {
        return $this->newScopedQuery()
            ->where($this->getParentIdName(), '=', $this->getParentId());
    }

    /**
     * Get query for the node siblings and the node itself.
     */
    public function getSiblingsAndSelf(array $columns = ['*']): EloquentCollection
    {
        return $this->siblingsAndSelf()->get($columns);
    }

    /**
     * Get query for siblings after the node.
     */
    public function nextSiblings(): QueryBuilder
    {
        return $this->nextNodes()
            ->where($this->getParentIdName(), '=', $this->getParentId());
    }

    /**
     * Get query for siblings before the node.
     */
    public function prevSiblings(): QueryBuilder
    {
        return $this->prevNodes()
            ->where($this->getParentIdName(), '=', $this->getParentId());
    }

    /**
     * Get query for nodes after current node.
     */
    public function nextNodes(): QueryBuilder
    {
        return $this->newScopedQuery()
            ->where($this->getLftName(), '>', $this->getLft());
    }

    /**
     * Get query for nodes before current node in reversed order.
     */
    public function prevNodes(): QueryBuilder
    {
        return $this->newScopedQuery()
            ->where($this->getLftName(), '<', $this->getLft());
    }

    /**
     * Get query ancestors of the node.
     */
    public function ancestors(): AncestorsRelation
    {
        return new AncestorsRelation($this->newQuery(), $this);
    }

    /**
     * Make this node a root node.
     */
    public function makeRoot(): self
    {
        $this->setParent(null)->dirtyBounds();

        return $this->setNodeAction('root');
    }

    /**
     * Save node as root.
     */
    public function saveAsRoot(): bool
    {
        if ($this->exists && $this->isRoot()) {
            return $this->save();
        }

        return $this->makeRoot()->save();
    }

    /**
     * Append and save a node.
     */
    public function appendNode(self $node): bool
    {
        return $node->appendToNode($this)->save();
    }

    /**
     * Prepend and save a node.
     */
    public function prependNode(self $node): bool
    {
        return $node->prependToNode($this)->save();
    }

    /**
     * Append a node to the new parent.
     */
    public function appendToNode(self $parent): self
    {
        return $this->appendOrPrependTo($parent);
    }

    /**
     * Prepend a node to the new parent.
     */
    public function prependToNode(self $parent): self
    {
        return $this->appendOrPrependTo($parent, true);
    }

    public function appendOrPrependTo(self $parent, bool $prepend = false): self
    {
        $this->assertNodeExists($parent)
            ->assertNotDescendant($parent)
            ->assertSameScope($parent);

        $this->setParent($parent)->dirtyBounds();

        return $this->setNodeAction('appendOrPrepend', $parent, $prepend);
    }

    /**
     * Insert self after a node.
     *
     * @return $this
     */
    public function afterNode(self $node)
    {
        return $this->beforeOrAfterNode($node, true);
    }

    /**
     * Insert self before node.
     *
     * @return $this
     */
    public function beforeNode(self $node)
    {
        return $this->beforeOrAfterNode($node);
    }

    public function beforeOrAfterNode(self $node, bool $after = false): self
    {
        $this->assertNodeExists($node)
            ->assertNotDescendant($node)
            ->assertSameScope($node);

        if (! $this->isSiblingOf($node)) {
            $this->setParent($node->getRelationValue('parent'));
        }

        $this->dirtyBounds();

        return $this->setNodeAction('beforeOrAfter', $node, $after);
    }

    /**
     * Insert self after a node and save.
     */
    public function insertAfterNode(self $node): bool
    {
        return $this->afterNode($node)->save();
    }

    /**
     * Insert self before a node and save.
     */
    public function insertBeforeNode(self $node): bool
    {
        if (! $this->beforeNode($node)->save()) {
            return false;
        }

        // We'll update the target node since it will be moved
        $node->refreshNode();

        return true;
    }

    /**
     * @return $this
     */
    public function rawNode($lft, $rgt, $parentId)
    {
        $this->setLft($lft)->setRgt($rgt)->setParentId($parentId);

        return $this->setNodeAction('raw');
    }

    /**
     * Move node up given amount of positions.
     */
    public function up(int $amount = 1): bool
    {
        $sibling = $this->prevSiblings()
            ->defaultOrder('desc')
            ->skip($amount - 1)
            ->first();

        if (! $sibling) {
            return false;
        }

        return $this->insertBeforeNode($sibling);
    }

    /**
     * Move node down given amount of positions.
     */
    public function down(int $amount = 1): bool
    {
        $sibling = $this->nextSiblings()
            ->defaultOrder()
            ->skip($amount - 1)
            ->first();

        if (! $sibling) {
            return false;
        }

        return $this->insertAfterNode($sibling);
    }

    /**
     * @since 2.0
     */
<<<<<<< HEAD
    public function newEloquentBuilder($query): QueryBuilder
=======
    public function newEloquentBuilder($query)
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
    {
        return new QueryBuilder($query);
    }

    /**
     * Get a new base query that includes deleted nodes.
     *
     * @since 1.1
<<<<<<< HEAD
     */
    public function newNestedSetQuery($table = null): QueryBuilder
=======
     *
     * @return QueryBuilder
     */
    public function newNestedSetQuery($table = null)
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
    {
        $builder = $this->usesSoftDelete()
            ? $this->withTrashed()
            : $this->newQuery();

        return $this->applyNestedSetScope($builder, $table);
    }

<<<<<<< HEAD
    public function newScopedQuery(string $table = null): QueryBuilder
=======
    /**
     * @param string $table
     *
     * @return QueryBuilder
     */
    public function newScopedQuery($table = null)
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
    {
        return $this->applyNestedSetScope($this->newQuery(), $table);
    }

<<<<<<< HEAD
    public function applyNestedSetScope($query, string $table = null)
=======
    /**
     * @param string $table
     */
    public function applyNestedSetScope($query, $table = null)
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
    {
        if (! $scoped = $this->getScopeAttributes()) {
            return $query;
        }

        if (! $table) {
            $table = $this->getTable();
        }

        foreach ($scoped as $attribute) {
            $query->where(
                $table.'.'.$attribute,
                '=',
                $this->getAttributeValue($attribute)
            );
        }

        return $query;
    }

<<<<<<< HEAD
    public function newCollection(array $models = []): Collection
=======
    public function newCollection(array $models = [])
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
    {
        return new Collection($models);
    }

    /**
     * Get node height (rgt - lft + 1).
<<<<<<< HEAD
     */
    public function getNodeHeight(): int
=======
     *
     * @return int
     */
    public function getNodeHeight()
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
    {
        if (! $this->exists) {
            return 2;
        }

        return $this->getRgt() - $this->getLft() + 1;
    }

    /**
     * Get number of descendant nodes.
<<<<<<< HEAD
     */
    public function getDescendantCount(): int
=======
     *
     * @return int
     */
    public function getDescendantCount()
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
    {
        return ceil($this->getNodeHeight() / 2) - 1;
    }

    /**
     * Set the value of model's parent id key.
     *
     * Behind the scenes node is appended to found parent node.
     *
<<<<<<< HEAD
     * @throws \Exception If parent node doesn't exists
     */
    public function setParentIdAttribute(int $value): void
    {
        if ($this->getParentId() === $value) {
            return;
        }

        if (0 !== $value) {
=======
     * @param int $value
     *
     * @throws \Exception If parent node doesn't exists
     */
    public function setParentIdAttribute($value)
    {
        if ($this->getParentId() == $value) {
            return;
        }

        if ($value) {
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
            $this->appendToNode($this->newScopedQuery()->findOrFail($value));
        } else {
            $this->makeRoot();
        }
    }

    /**
     * Get whether node is root.
<<<<<<< HEAD
     */
    public function isRoot(): bool
=======
     *
     * @return bool
     */
    public function isRoot()
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
    {
        return is_null($this->getParentId());
    }

<<<<<<< HEAD
    public function isLeaf(): bool
    {
        return $this->getLft() + 1 === $this->getRgt();
=======
    /**
     * @return bool
     */
    public function isLeaf()
    {
        return $this->getLft() + 1 == $this->getRgt();
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
    }

    /**
     * Get the lft key name.
<<<<<<< HEAD
     */
    public function getLftName(): string
=======
     *
     * @return string
     */
    public function getLftName()
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
    {
        return NestedSet::LFT;
    }

    /**
     * Get the rgt key name.
<<<<<<< HEAD
     */
    public function getRgtName(): string
=======
     *
     * @return string
     */
    public function getRgtName()
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
    {
        return NestedSet::RGT;
    }

    /**
     * Get the parent id key name.
<<<<<<< HEAD
     */
    public function getParentIdName(): string
=======
     *
     * @return string
     */
    public function getParentIdName()
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
    {
        return NestedSet::PARENT_ID;
    }

    /**
     * Get the value of the model's lft key.
     */
    public function getLft(): int
    {
<<<<<<< HEAD
        return (int) $this->getAttributeValue($this->getLftName());
=======
        return intval($this->getAttributeValue($this->getLftName()));
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
    }

    /**
     * Get the value of the model's rgt key.
     */
    public function getRgt(): int
    {
<<<<<<< HEAD
        return (int) $this->getAttributeValue($this->getRgtName());
=======
        return intval($this->getAttributeValue($this->getRgtName()));
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
    }

    /**
     * Get the value of the model's parent id key.
     */
    public function getParentId()
    {
        return $this->getAttributeValue($this->getParentIdName());
    }

    /**
     * Returns node that is next to current node without constraining to siblings.
     *
     * This can be either a next sibling or a next sibling of the parent node.
<<<<<<< HEAD
     */
    public function getNextNode(array $columns = ['*']): self
=======
     *
     * @return self
     */
    public function getNextNode(array $columns = ['*'])
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
    {
        return $this->nextNodes()->defaultOrder()->first($columns);
    }

    /**
     * Returns node that is before current node without constraining to siblings.
     *
     * This can be either a prev sibling or parent node.
<<<<<<< HEAD
     */
    public function getPrevNode(array $columns = ['*']): self
=======
     *
     * @return self
     */
    public function getPrevNode(array $columns = ['*'])
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
    {
        return $this->prevNodes()->defaultOrder('desc')->first($columns);
    }

<<<<<<< HEAD
    public function getAncestors(array $columns = ['*']): Collection
=======
    /**
     * @return Collection
     */
    public function getAncestors(array $columns = ['*'])
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
    {
        return $this->ancestors()->get($columns);
    }

    /**
<<<<<<< HEAD
     * @return Collection|array<self>
     */
    public function getDescendants(array $columns = ['*']): Collection|array
=======
     * @return Collection|self[]
     */
    public function getDescendants(array $columns = ['*'])
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
    {
        return $this->descendants()->get($columns);
    }

    /**
<<<<<<< HEAD
     * @return Collection|array<self>
     */
    public function getSiblings(array $columns = ['*']): Collection|array
=======
     * @return Collection|self[]
     */
    public function getSiblings(array $columns = ['*'])
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
    {
        return $this->siblings()->get($columns);
    }

    /**
<<<<<<< HEAD
     * @return Collection|array<self>
     */
    public function getNextSiblings(array $columns = ['*']): Collection|array
=======
     * @return Collection|self[]
     */
    public function getNextSiblings(array $columns = ['*'])
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
    {
        return $this->nextSiblings()->get($columns);
    }

    /**
<<<<<<< HEAD
     * @return Collection|array<self>
     */
    public function getPrevSiblings(array $columns = ['*']): Collection|array
=======
     * @return Collection|self[]
     */
    public function getPrevSiblings(array $columns = ['*'])
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
    {
        return $this->prevSiblings()->get($columns);
    }

<<<<<<< HEAD
    public function getNextSibling(array $columns = ['*']): self
=======
    /**
     * @return self
     */
    public function getNextSibling(array $columns = ['*'])
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
    {
        return $this->nextSiblings()->defaultOrder()->first($columns);
    }

<<<<<<< HEAD
    public function getPrevSibling(array $columns = ['*']): self
=======
    /**
     * @return self
     */
    public function getPrevSibling(array $columns = ['*'])
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
    {
        return $this->prevSiblings()->defaultOrder('desc')->first($columns);
    }

    /**
     * Get whether a node is a descendant of other node.
<<<<<<< HEAD
     */
    public function isDescendantOf(self $other): bool
=======
     *
     * @return bool
     */
    public function isDescendantOf(self $other)
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
    {
        return $this->getLft() > $other->getLft()
            && $this->getLft() < $other->getRgt();
    }

    /**
     * Get whether a node is itself or a descendant of other node.
<<<<<<< HEAD
     */
    public function isSelfOrDescendantOf(self $other): bool
=======
     *
     * @return bool
     */
    public function isSelfOrDescendantOf(self $other)
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
    {
        return $this->getLft() >= $other->getLft()
            && $this->getLft() < $other->getRgt();
    }

    /**
     * Get whether the node is immediate children of other node.
<<<<<<< HEAD
     */
    public function isChildOf(self $other): bool
    {
        return $this->getParentId() === $other->getKey();
=======
     *
     * @return bool
     */
    public function isChildOf(self $other)
    {
        return $this->getParentId() == $other->getKey();
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
    }

    /**
     * Get whether the node is a sibling of another node.
<<<<<<< HEAD
     */
    public function isSiblingOf(self $other): bool
    {
        return $this->getParentId() === $other->getParentId();
=======
     *
     * @return bool
     */
    public function isSiblingOf(self $other)
    {
        return $this->getParentId() == $other->getParentId();
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
    }

    /**
     * Get whether the node is an ancestor of other node, including immediate parent.
<<<<<<< HEAD
     */
    public function isAncestorOf(self $other): bool
=======
     *
     * @return bool
     */
    public function isAncestorOf(self $other)
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
    {
        return $other->isDescendantOf($this);
    }

    /**
     * Get whether the node is itself or an ancestor of other node, including immediate parent.
<<<<<<< HEAD
     */
    public function isSelfOrAncestorOf(self $other): bool
=======
     *
     * @return bool
     */
    public function isSelfOrAncestorOf(self $other)
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
    {
        return $other->isSelfOrDescendantOf($this);
    }

    /**
     * Get whether the node has moved since last save.
<<<<<<< HEAD
     */
    public function hasMoved(): bool
=======
     *
     * @return bool
     */
    public function hasMoved()
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
    {
        return $this->moved;
    }

<<<<<<< HEAD
    public function getBounds(): array
    {
        return [$this->getLft(), $this->getRgt()];
    }

    /**
     * @return $this
     */
    public function setLft($value)
    {
        $this->attributes[$this->getLftName()] = $value;

        return $this;
    }

    /**
     * @return $this
     */
    public function setRgt($value)
    {
        $this->attributes[$this->getRgtName()] = $value;

        return $this;
    }

    /**
     * @return $this
     */
    public function setParentId($value)
    {
        $this->attributes[$this->getParentIdName()] = $value;

        return $this;
    }

    public function replicate(array $except = null): Model
    {
        $defaults = [
            $this->getParentIdName(),
            $this->getLftName(),
            $this->getRgtName(),
        ];

        $except = $except ? array_unique(array_merge($except, $defaults)) : $defaults;

        return parent::replicate($except);
    }

    /**
     * Set an action.
     */
    protected function setNodeAction(string $action): self
    {
        $this->pending = func_get_args();

        return $this;
    }

    /**
     * Call pending action.
     */
    protected function callPendingAction(): void
    {
        $this->moved = false;

        if (! $this->pending && ! $this->exists) {
            $this->makeRoot();
        }

        if (! $this->pending) {
            return;
        }

        $method = 'action'.ucfirst((string) array_shift($this->pending));
        $parameters = $this->pending;

        $this->pending = null;

        $callback = [$this, $method];
        $this->moved = call_user_func_array($callback, $parameters);
    }

    protected function actionRaw(): bool
    {
        return true;
    }

    /**
     * Make a root node.
     */
    protected function actionRoot(): bool
    {
        // Simplest case that do not affect other nodes.
        if (! $this->exists) {
            $cut = $this->getLowerBound() + 1;

            $this->setLft($cut);
            $this->setRgt($cut + 1);

            return true;
        }

        return $this->insertAt($this->getLowerBound() + 1);
    }

    /**
     * Get the lower bound.
     */
    protected function getLowerBound(): int
    {
        // Call to private method max() of parent class Illuminate\Database\Eloquent\Builder<Illuminate\Database\Eloquent\Model>
        return (int) $this->newNestedSetQuery()->max($this->getRgtName());
    }

    /**
     * Append or prepend a node to the parent.
     */
    protected function actionAppendOrPrepend(self $parent, bool $prepend = false): bool
    {
        $parent->refreshNode();

        $cut = $prepend ? $parent->getLft() + 1 : $parent->getRgt();

        if (! $this->insertAt($cut)) {
            return false;
        }

        $parent->refreshNode();

        return true;
    }

    /**
     * Apply parent model.
     */
    protected function setParent(?Model $model): self
    {
        $this->setParentId($model instanceof Model ? $model->getKey() : null)
            ->setRelation('parent', $model);

        return $this;
    }

    /**
     * Insert node before or after another node.
     */
    protected function actionBeforeOrAfter(self $node, bool $after = false): bool
    {
        $node->refreshNode();

        return $this->insertAt($after ? $node->getRgt() + 1 : $node->getLft());
    }

    /**
     * Insert node at specific position.
     */
    protected function insertAt(int $position): bool
    {
        ++static::$actionsPerformed;

        return $this->exists
            ? $this->moveNode($position)
            : $this->insertNode($position);
    }

    /**
     * Move a node to the new position.
     *
     * @since 2.0
     */
    protected function moveNode(int $position): int
    {
        $updated = $this->newNestedSetQuery()
            ->moveNode($this->getKey(), $position) > 0;

        if ($updated) {
            $this->refreshNode();
        }

        return $updated;
    }

    /**
     * Insert new node at specified position.
     *
     * @since 2.0
     */
    protected function insertNode(int $position): bool
    {
        $this->newNestedSetQuery()->makeGap($position, 2);

        $height = $this->getNodeHeight();

        $this->setLft($position);
        $this->setRgt($position + $height - 1);

        return true;
    }

    /**
     * Update the tree when the node is removed physically.
     */
    protected function deleteDescendants(): void
    {
        $lft = $this->getLft();
        $rgt = $this->getRgt();

        $method = $this->usesSoftDelete() && $this->forceDeleting
            ? 'forceDelete'
            : 'delete';

        $this->descendants()->{$method}();

        if ($this->hardDeleting()) {
            $height = $rgt - $lft + 1;

            $this->newNestedSetQuery()->makeGap($rgt + 1, -$height);

            // In case if user wants to re-create the node
            $this->makeRoot();

            ++static::$actionsPerformed;
        }
    }

    /**
     * Restore the descendants.
     */
    protected function restoreDescendants($deletedAt): void
    {
        $this->descendants()
            ->where($this->getDeletedAtColumn(), '>=', $deletedAt)
            ->restore();
    }

    protected function getScopeAttributes(): array
    {
        return null;
    }

    protected function getArrayableRelations(): array
    {
        $result = parent::getArrayableRelations();

        // To fix #17 when converting tree to json falling to infinite recursion.
        unset($result['parent']);

        return $result;
    }

    /**
     * Get whether user is intended to delete the model from database entirely.
     */
    protected function hardDeleting(): bool
    {
        if (! $this->usesSoftDelete()) {
            return true;
        }

        return (bool) $this->forceDeleting;
    }

    /**
     * @return Model
     */
    public function replicate(array $except = null)
    {
        $defaults = [
            $this->getParentIdName(),
            $this->getLftName(),
            $this->getRgtName(),
        ];

        $except = $except ? array_unique(array_merge($except, $defaults)) : $defaults;

        return parent::replicate($except);
    }

    /**
     * Set an action.
     */
    protected function setNodeAction(string $action): self
    {
        $this->pending = func_get_args();

        return $this;
    }

    /**
     * Call pending action.
     */
    protected function callPendingAction(): void
    {
        $this->moved = false;

        if (! $this->pending && ! $this->exists) {
            $this->makeRoot();
        }

        if (! $this->pending) {
            return;
        }

        $method = 'action'.ucfirst((string) array_shift($this->pending));
        $parameters = $this->pending;

        $this->pending = null;

        $callback = [$this, $method];
        $this->moved = call_user_func_array($callback, $parameters);
    }

    protected function actionRaw(): bool
    {
        return true;
    }

    /**
     * Make a root node.
     */
    protected function actionRoot(): bool
    {
        // Simplest case that do not affect other nodes.
        if (! $this->exists) {
            $cut = $this->getLowerBound() + 1;

            $this->setLft($cut);
            $this->setRgt($cut + 1);

            return true;
        }

        return $this->insertAt($this->getLowerBound() + 1);
    }

    /**
     * Get the lower bound.
     */
    protected function getLowerBound(): int
    {
        // Call to private method max() of parent class Illuminate\Database\Eloquent\Builder<Illuminate\Database\Eloquent\Model>
        return (int) $this->newNestedSetQuery()->max($this->getRgtName());
    }

    /**
     * Append or prepend a node to the parent.
     */
    protected function actionAppendOrPrepend(self $parent, bool $prepend = false): bool
    {
        $parent->refreshNode();

        $cut = $prepend ? $parent->getLft() + 1 : $parent->getRgt();

        if (! $this->insertAt($cut)) {
            return false;
        }

        $parent->refreshNode();

        return true;
    }

    /**
     * Apply parent model.
     *
     * @param Model|null $value
     */
    protected function setParent($value): self
    {
        $this->setParentId($value instanceof Model ? $value->getKey() : null)
            ->setRelation('parent', $value);

        return $this;
    }

    /**
     * Insert node before or after another node.
     */
    protected function actionBeforeOrAfter(self $node, bool $after = false): bool
    {
        $node->refreshNode();

        return $this->insertAt($after ? $node->getRgt() + 1 : $node->getLft());
    }

    /**
     * Insert node at specific position.
     *
     * @param int $position
     *
     * @return bool
     */
    protected function insertAt($position)
    {
        ++static::$actionsPerformed;

        return $this->exists
            ? $this->moveNode($position)
            : $this->insertNode($position);
    }

    /**
     * Move a node to the new position.
     *
     * @since 2.0
     *
     * @param int $position
     */
    protected function moveNode($position): bool
    {
        $updated = $this->newNestedSetQuery()
            ->moveNode($this->getKey(), $position) > 0;

        if ($updated) {
            $this->refreshNode();
        }

        return $updated;
    }

    /**
     * Insert new node at specified position.
     *
     * @since 2.0
     *
     * @param int $position
     */
    protected function insertNode($position): bool
    {
        $this->newNestedSetQuery()->makeGap($position, 2);

        $height = $this->getNodeHeight();

        $this->setLft($position);
        $this->setRgt($position + $height - 1);

        return true;
    }

    /**
     * Update the tree when the node is removed physically.
     */
    protected function deleteDescendants()
    {
        $lft = $this->getLft();
        $rgt = $this->getRgt();

        $method = $this->usesSoftDelete() && $this->forceDeleting
            ? 'forceDelete'
            : 'delete';

        $this->descendants()->{$method}();

        if ($this->hardDeleting()) {
            $height = $rgt - $lft + 1;

            $this->newNestedSetQuery()->makeGap($rgt + 1, -$height);

            // In case if user wants to re-create the node
            $this->makeRoot();

            ++static::$actionsPerformed;
        }
    }

    /**
     * Restore the descendants.
     */
    protected function restoreDescendants($deletedAt)
    {
        $this->descendants()
            ->where($this->getDeletedAtColumn(), '>=', $deletedAt)
            ->restore();
    }

    /**
     * @return array
     */
    protected function getScopeAttributes()
    {
        return null;
    }

=======
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
    /**
     * @return array
     */
    public function getBounds()
    {
        return [$this->getLft(), $this->getRgt()];
    }

    /**
     * @return $this
     */
    public function setLft($value)
    {
        $this->attributes[$this->getLftName()] = $value;

        return $this;
    }

    /**
     * @return $this
     */
    public function setRgt($value)
    {
        $this->attributes[$this->getRgtName()] = $value;

        return $this;
    }

    /**
     * @return $this
     */
    public function setParentId($value)
    {
        $this->attributes[$this->getParentIdName()] = $value;

        return $this;
    }

    /**
     * @return Model
     */
    public function replicate(array $except = null)
    {
        $defaults = [
            $this->getParentIdName(),
            $this->getLftName(),
            $this->getRgtName(),
        ];

        $except = $except ? array_unique(array_merge($except, $defaults)) : $defaults;

        return parent::replicate($except);
    }

    /**
     * Set an action.
     */
    protected function setNodeAction(string $action): self
    {
        $this->pending = func_get_args();

        return $this;
    }

    /**
     * Call pending action.
     */
    protected function callPendingAction(): void
    {
        $this->moved = false;

        if (! $this->pending && ! $this->exists) {
            $this->makeRoot();
        }

        if (! $this->pending) {
            return;
        }

        $method = 'action'.ucfirst(array_shift($this->pending));
        $parameters = $this->pending;

        $this->pending = null;

        /**
         * @var callable
         */
        $callback = [$this, $method];
        $this->moved = call_user_func_array($callback, $parameters);
    }

    protected function actionRaw(): bool
    {
        return true;
    }

    /**
     * Make a root node.
     */
    protected function actionRoot(): bool
    {
        // Simplest case that do not affect other nodes.
        if (! $this->exists) {
            $cut = $this->getLowerBound() + 1;

            $this->setLft($cut);
            $this->setRgt($cut + 1);

            return true;
        }

        return $this->insertAt($this->getLowerBound() + 1);
    }

    /**
     * Get the lower bound.
     */
    protected function getLowerBound(): int
    {
        // Call to private method max() of parent class Illuminate\Database\Eloquent\Builder<Illuminate\Database\Eloquent\Model>
        return (int) $this->newNestedSetQuery()->max($this->getRgtName());
    }

    /**
     * Append or prepend a node to the parent.
     */
    protected function actionAppendOrPrepend(self $parent, bool $prepend = false): bool
    {
        $parent->refreshNode();

        $cut = $prepend ? $parent->getLft() + 1 : $parent->getRgt();

        if (! $this->insertAt($cut)) {
            return false;
        }

        $parent->refreshNode();

        return true;
    }

    /**
     * Apply parent model.
     *
     * @param Model|null $value
     */
    protected function setParent($value): self
    {
        $this->setParentId($value ? $value->getKey() : null)
            ->setRelation('parent', $value);

        return $this;
    }

    /**
     * Insert node before or after another node.
     */
    protected function actionBeforeOrAfter(self $node, bool $after = false): bool
    {
        $node->refreshNode();

        return $this->insertAt($after ? $node->getRgt() + 1 : $node->getLft());
    }

    /**
     * Insert node at specific position.
     *
     * @param int $position
     *
     * @return bool
     */
    protected function insertAt($position)
    {
        ++static::$actionsPerformed;

        $result = $this->exists
            ? $this->moveNode($position)
            : $this->insertNode($position);

        return $result;
    }

    /**
     * Move a node to the new position.
     *
     * @since 2.0
     *
     * @param int $position
     *
     * @return int
     */
    protected function moveNode($position)
    {
        $updated = $this->newNestedSetQuery()
            ->moveNode($this->getKey(), $position) > 0;

        if ($updated) {
            $this->refreshNode();
        }

        return $updated;
    }

    /**
     * Insert new node at specified position.
     *
     * @since 2.0
     *
     * @param int $position
     *
     * @return bool
     */
    protected function insertNode($position)
    {
        $this->newNestedSetQuery()->makeGap($position, 2);

        $height = $this->getNodeHeight();

        $this->setLft($position);
        $this->setRgt($position + $height - 1);

        return true;
    }

    /**
     * Update the tree when the node is removed physically.
     */
    protected function deleteDescendants()
    {
        $lft = $this->getLft();
        $rgt = $this->getRgt();

        $method = $this->usesSoftDelete() && $this->forceDeleting
            ? 'forceDelete'
            : 'delete';

        $this->descendants()->{$method}();

        if ($this->hardDeleting()) {
            $height = $rgt - $lft + 1;

            $this->newNestedSetQuery()->makeGap($rgt + 1, -$height);

            // In case if user wants to re-create the node
            $this->makeRoot();

            ++static::$actionsPerformed;
        }
    }

    /**
     * Restore the descendants.
     */
    protected function restoreDescendants($deletedAt)
    {
        $this->descendants()
            ->where($this->getDeletedAtColumn(), '>=', $deletedAt)
            ->restore();
    }

    /**
     * @return array
     */
    protected function getScopeAttributes()
    {
        return null;
    }

    /**
     * @return array
     */
    protected function getArrayableRelations()
    {
        $result = parent::getArrayableRelations();

        // To fix #17 when converting tree to json falling to infinite recursion.
        unset($result['parent']);

        return $result;
    }

    /**
     * Get whether user is intended to delete the model from database entirely.
     */
    protected function hardDeleting(): bool
    {
        if (! $this->usesSoftDelete()) {
            return true;
        }

<<<<<<< HEAD
        return (bool) $this->forceDeleting;
    }

=======
>>>>>>> 13f752909684a56d16bf094cd4d92fee7631b04a
    /**
     * @return $this
     */
    protected function dirtyBounds()
    {
        $this->original[$this->getLftName()] = null;
        $this->original[$this->getRgtName()] = null;

        return $this;
    }

    /**
     * @return $this
     */
    protected function assertNotDescendant(self $node)
    {
        if ($node === $this || $node->isDescendantOf($this)) {
            throw new \LogicException('Node must not be a descendant.');
        }

        return $this;
    }

    /**
     * @return $this
     */
    protected function assertNodeExists(self $node)
    {
        if (! $node->getLft() || ! $node->getRgt()) {
            throw new \LogicException('Node must exists.');
        }

        return $this;
    }

    /**
     * Summary of assertSameScope.
     *
     * @throws \LogicException
     */
    protected function assertSameScope(self $node): void
    {
        if (! $scoped = $this->getScopeAttributes()) {
            return;
        }

        foreach ($scoped as $attr) {
            if ($this->getAttribute($attr) !== $node->getAttribute($attr)) {
                throw new \LogicException('Nodes must be in the same scope');
            }
        }
    }
}
