
@if($db_debug) 

<div class="debug__query__wrapper">
    <h4>{{ $db_debug['query_count'] }} {{ str_plural('Query', $db_debug['query_count']) }} </h4>

    @if($db_debug['query_count'] > 0)
   @foreach($db_debug['queries'] as $query)
        <dl class="debug__query">
            <dt>#{{ $loop->remaining + 1 }} [{{ $query['time'] }} ms] 
            </dt>

            {{-- @if(count($query['bindings']) > 0)<dd class="debug__query__bindings">"{{ join('","',$query['bindings']) }}"</dd> @endif --}}
            <dd class="debug__query__sql">{!! $query['query_flat'] !!}</dd>
            <dd class="debug__stack">
                @foreach($query['stack'] as $file_uri)
                   <span class="debug__stack__file">{{ $file_uri }}</span>
                @endforeach
            </dd>
        </dl>
    @endforeach
    @endif
</div>
@endif
