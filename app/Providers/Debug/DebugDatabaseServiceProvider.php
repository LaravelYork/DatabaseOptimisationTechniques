<?php
namespace App\Providers\Debug;

use App;
use DB;
use Event;
use Config;
use Session;
use DateTime;
use Illuminate\Support\ServiceProvider;

use App\Exceptions\Core\DebugException;
use App\Services\DebugQueryCache;
use App\Http\ViewComposers\DebugDatabaseComposer;

use NilPortugues\Sql\QueryFormatter\Formatter as SQLFormatter;

class DebugDatabaseServiceProvider extends ServiceProvider
{
    protected $queries = [];
    public function boot()
    {
        view()->composer('*', DebugDatabaseComposer::class);

        if (static::shouldDebugQueries()) {
            DB::listen(function ($query) {
                $bindings = [];

                foreach ($query->bindings as $i => $binding) {
                    if ($binding instanceof DateTime) {
                        $bindings[$i] = $binding->format('\'Y-m-d H:i:s\'');
                    } elseif (is_string($binding)) {
                        $bindings[$i] = "'$binding'";
                    } else {
                        $bindings[$i] = $binding;
                    }
                }
      
                $query_flat = $query->sql;
      
                if (count($bindings)>=1) {
                    $query_flat = str_replace(['%', '?'], ['%%', '%s'], $query_flat);
                    $query_flat = vsprintf($query_flat, $bindings);
                }

    
                $query_flat = preg_replace("/[\n\t\s]+/", " ", $query_flat);

                if (!(request()->is('api/*'))) {
                    $query_flat = preg_replace("/as ([a-z0-9\_\-\.]+),/i", "as $1,<br />", $query_flat);

                    $query_flat = preg_replace("/([0-9]+)/",'<span class="token token__number">$1</span>',$query_flat);

                    $query_flat = preg_replace(sprintf("/\b(%s)\b/i",implode("|",static::$keywords_newline)),'<br/><span class="token token__keyword">$1</span>',$query_flat);
                    $query_flat = preg_replace(sprintf("/\b(%s)\b/i",implode("|",static::$keywords)),'<span class="token token__keyword">$1</span>',$query_flat);

                }
                
                $time = $query->time;
      
                $bindings = $query->bindings;
                $stack = DebugException::stack();

                $data = compact('query_flat', 'time', 'bindings', 'stack');

                $debugQueryCache = resolve(DebugQueryCache::class);
                $debugQueryCache->queries[] = $data;
            });
        }
    }

    
    public function register()
    {
        $this->app->singleton(DebugQueryCache::class);
    }

    protected static function shouldDebugQueries()
    {

        //(strpos(php_sapi_name(), 'cli') === false)
        if ((App::environment('local') && Config::get('app.debug')) || Config::get('app.debug_all_queries')) {
            return true;
        } else {
            return false;
        }
    }

    protected static $keywords = [
        'SELECT','DROP','UPDATE','ALTER TABLE','DELETE FROM', 'insert'
    ];

    protected static $keywords_newline = [
        'FROM', 'WHERE', 'SET', 'ORDER BY', 'GROUP BY', 'LIMIT',
        'VALUES', 'HAVING', 'ADD', 'AFTER', 'UNION ALL', 'UNION', 'EXCEPT', 'INTERSECT',
        'LEFT OUTER JOIN', 'RIGHT OUTER JOIN', 'LEFT JOIN', 'RIGHT JOIN', 'OUTER JOIN', 'INNER JOIN', 'JOIN', 'XOR', 'OR', 'AND'
    ];
}
