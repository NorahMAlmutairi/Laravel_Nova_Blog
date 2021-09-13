<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Http\Requests\NovaRequest;

class Post extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Post::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make(__('ID'), 'id')->sortable(),
            Select::make(__('Authors'),'author_id')->options(\App\Models\Author::where('active',true)->pluck('name','id'))->onlyOnForms(),
            Select::make(__('Categories'),'category_id')->options(\App\Models\Category::where('active',true)->pluck('name','id'))->onlyOnForms(),
            Text::make(__('Title'),'title')->required()->sortable(true),
            Trix::make(__('Content'),'content')->required()->alwaysShow(),
            Image::make(__('Photo'),'photo')->disk('public'),
            Select::make(__('Status'),'status')->options([
                __('Pending') => 'pending',
                __('Approved') => 'approved',
                __('Cancelled') => 'cancelled',
            ])->displayUsing(function ($status){
                return ucfirst($status);
            }),
            BelongsTo::make(__('Author'), 'author', Author::class)
            ->displayUsing(function ($author) {
                return $author->name;
            })->readonly()->exceptOnForms(),

            BelongsTo::make(__('Category'), 'category', Category::class)
            ->displayUsing(function ($author) {
                return $author->name;
            })->readonly()->exceptOnForms(),

        ];

    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
