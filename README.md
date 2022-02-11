<h3>Laravel 9.0.1</h3>
<br>
<p>Install project: <code>composer install</code></p>
<p>Run tests: <code>.\vendor\bin\pest</code></p>

<hr>

<h4>Available methods:</h4>
ActorController
<ul>
    <li><code>GET|HEAD /actors</code> Return all actors.</li>
    <li><code>POST /actors [movies:int[]|null]</code>Store actor, if movies array is presented, attach actor to movies. If is empty array, remove all movies for this actor.</li>
    <li><code>GET|HEAD /actors/{id}</code> Return one actor</li>
    <li><code>PUT|PATCH /actors/{id} [name:string]</code>Update actor by id</li>
    <li><code>DELETE /actors/{id}</code> Destroy actor</li>
</ul>
