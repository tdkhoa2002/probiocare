<?php

namespace Modules\Page\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\NamespacedEntity;
use Modules\Media\Support\Traits\MediaRelation;
use Modules\Tag\Contracts\TaggableInterface;
use Modules\Tag\Traits\TaggableTrait;
use Modules\Page\Entities\Category;

class Page extends Model implements TaggableInterface
{
    use Translatable, TaggableTrait, NamespacedEntity, MediaRelation;

    protected $table = 'page__pages';
    public $translatedAttributes = [
        'page_id',
        'title',
        'sumary',
        'slug',
        'status',
        'body',
        'meta_title',
        'meta_description',
        'og_title',
        'og_description',
        'og_image',
        'og_type',
    ];
    protected $fillable = [
        'is_home',
        'template',
        'type',
        // Translatable fields
        'page_id',
        'title',
        'sumary',
        'slug',
        'status',
        'body',
        'meta_title',
        'meta_description',
        'og_title',
        'og_description',
        'og_image',
        'og_type',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            // dd($model);
        });
    }

    protected $casts = [
        'is_home' => 'boolean',
    ];
    
    protected static $entityNamespace = 'asgardcms/page';

    public function getCanonicalUrl(): string
    {
        if ($this->is_home === true) {
            return url('/');
        }

        return route('page', $this->slug);
    }

    public function getEditUrl(): string
    {
        return route('admin.page.page.edit', $this->id);
    }

    public function __call($method, $parameters)
    {
        #i: Convert array to dot notation
        $config = implode('.', ['asgard.page.config.relations', $method]);

        #i: Relation method resolver
        if (config()->has($config)) {
            $function = config()->get($config);

            return $function($this);
        }

        #i: No relation found, return the call to parent (Eloquent) to handle it.
        return parent::__call($method, $parameters);
    }

    public function getImageAttribute()
    {
        $thumbnail = $this->files()->where('zone', 'page_featured_image')->first();

        if ($thumbnail === null) {
            return '';
        }

        return $thumbnail;
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_page', 'page_id', 'category_id');
    }
}
