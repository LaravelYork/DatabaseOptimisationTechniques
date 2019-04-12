<?php
namespace App\Providers\Debug;

use App;
use DB;
use Event;
use Config;
use Session;
use Illuminate\Support\ServiceProvider;

use App\Exceptions\Core\DebugException;
use App\Services\DebugQueryCache;
use App\Http\ViewComposers\DebugDatabaseComposer;

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
                    if ($binding instanceof \DateTime) {
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

                if(!(request()->is('api/*'))){

                $query_flat = preg_replace("/as ([a-z0-9\_\-\.]+),/i", "as $1,\n", $query_flat);

                $query_flat = str_replace("`, ", "`,\n", $query_flat);
                $query_flat = str_replace("from", "\nfrom", $query_flat);
                $query_flat = str_replace("left", "\nleft", $query_flat);
                $query_flat = str_replace("inner", "\ninner", $query_flat);
                $query_flat = str_replace("and", "\nand", $query_flat);
                $query_flat = str_replace("where", "\nwhere", $query_flat);
                $query_flat = str_replace("group by", "\ngroup by", $query_flat);
                $query_flat = str_replace("order by", "\norder by", $query_flat);
                
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

    protected static function shouldDebugQueries(){

        if ((App::environment('local') && Config::get('app.debug') && (strpos(php_sapi_name(), 'cli') === false)) || Config::get('app.debug_all_queries')) {
            return true;
        } else {
            return false;
        }
    }
}
