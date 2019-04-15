<?php

namespace App\Http\ViewComposers;

use App;
use Config;
use Cache;
use Session;
use Illuminate\View\View;
use Route;
use App\Models\Event;
use App\Services\DebugQueryCache;

class DebugDatabaseComposer
{
    public function compose(View $view)
    {
        $debug = Config::get('app.debug');

        $db_debug = [];
        
        $db_debug['env'] = App::environment();
        $db_debug['debug'] = $debug;

        if ($debug) {
            if (App::environment('local')) {

                $debugQueryCache = resolve(DebugQueryCache::class);
                $db_debug['query_count'] = count($debugQueryCache->queries);
                $db_debug['queries'] = array_reverse($debugQueryCache->queries);
            }
        }

        $current_route_name = '';

        if ($current_route = Route::getFacadeRoot()->current()) {
            $current_route_name = trim($current_route->getName());
        }
        
        $db_debug['current_route'] = $current_route_name;

        $view->with('db_debug',$db_debug);

    }

}