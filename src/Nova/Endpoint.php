<?php

namespace Harlekoy\ApiDocs\Nova;

use Harlekoy\ApiDocs\Nova\Group;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Code;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Http\Requests\NovaRequest;

class Endpoint extends Resource
{
    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'API';

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'Harlekoy\ApiDocs\Drivers\Database\Models\Endpoint';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'description';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'endpoint',
        'description',
    ];

    /**
     * Get the search result subtitle for the resource.
     *
     * @return string
     */
    public function subtitle()
    {
        return $this->endpoint;
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            BelongsTo::make('Group')
                ->rules('required', 'max:255'),

            Select::make('Method')->options([
                'GET'    => 'GET',
                'POST'   => 'POST',
                'PUT'    => 'PUT',
                'DELETE' => 'DELETE',
            ])
            ->rules('required', 'max:255'),

            Text::make('Endpoint')
                ->sortable()
                ->rules('required', 'max:255'),

            Textarea::make('Description'),

            Code::make('Parameters')
                ->json(),

            Code::make('Sample Response')
                ->json()
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
