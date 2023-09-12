<?php

declare(strict_types=1);

namespace Modules\Xot\Models;

// ------ ext models---
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;
use Modules\Xot\Database\Factories\WidgetFactory;
use Modules\Xot\Models\Traits\WidgetTrait;

/**
 * Modules\Xot\Models\Widget.
 *
 * @property int                     $id
 * @property string|null             $post_type
 * @property string|null             $layout_position
 * @property string|null             $title
 * @property int|null                $post_id
 * @property string|null             $blade
 * @property string|null             $image_src
 * @property int|mixed               $pos
 * @property string|null             $model
 * @property int|null                $limit
 * @property string|null             $order_by
 * @property Carbon|null             $created_at
 * @property string|null             $created_by
 * @property Carbon|null             $updated_at
 * @property string|null             $updated_by
 * @property Collection<int, Widget> $containerWidgets
 * @property int|null                $container_widgets_count
 * @property Model|\Eloquent         $linked
 * @property Collection<int, Widget> $widgets
 * @property int|null                $widgets_count
 *
 * @method static WidgetFactory  factory($count = null, $state = [])
 * @method static Builder|Widget newModelQuery()
 * @method static Builder|Widget newQuery()
 * @method static Builder|Widget ofLayoutPosition($layout_position)
 * @method static Builder|Widget query()
 * @method static Builder|Widget whereBlade($value)
 * @method static Builder|Widget whereCreatedAt($value)
 * @method static Builder|Widget whereCreatedBy($value)
 * @method static Builder|Widget whereId($value)
 * @method static Builder|Widget whereImageSrc($value)
 * @method static Builder|Widget whereLayoutPosition($value)
 * @method static Builder|Widget whereLimit($value)
 * @method static Builder|Widget whereModel($value)
 * @method static Builder|Widget whereOrderBy($value)
 * @method static Builder|Widget wherePos($value)
 * @method static Builder|Widget wherePostId($value)
 * @method static Builder|Widget wherePostType($value)
 * @method static Builder|Widget whereTitle($value)
 * @method static Builder|Widget whereUpdatedAt($value)
 * @method static Builder|Widget whereUpdatedBy($value)
 *
 * @mixin \Eloquent
 */
class Widget extends BaseModel
{
    use WidgetTrait;

    /**
     * @var string[]
     */
    protected $fillable = [
        'id',
        'post_type', 'post_id', // nullablemorph
        'title',
        // 'subtitle',
        'blade', 'pos', 'model', 'limit',
        'order_by', 'image_src', 'layout_position',
    ];

    public function linked(): MorphTo
    {
        return $this->morphTo('post');
    }

    /**
     * ---.
     */
    public function getPosAttribute(?int $value): ?int
    {
        if (null !== $value) {
            return $value;
        }

        return self::max('pos') + 1;
    }

    public function toHtml(array $params = null): Application|Factory|View
    {
        /**
         * @phpstan-var view-string
         */
        $view = 'pub_theme::layouts.widgets';
        if (null !== $this->layout_position) {
            $view .= '.'.$this->layout_position;
        }

        $view .= '.'.$this->blade;
        $view_params = [
            'lang' => \App::getLocale(),
            'view' => $view,
            'row' => $this->linked,
            'widget' => $this,
        ];
        if (null !== $params) {
            $view_params['params'] = $params;
        }

        if (! view()->exists($view)) {
            dddx(['View ['.$view.'] Not Exists !']);
        }

        try {
            return view($view, $view_params);
        } catch (\Exception $exception) {
            dddx([$exception]);
        }

        return view()->make($view)->with($view_params);
    }
}
