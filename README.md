
<h1>Short Description</h1>
<p>I did СRUD operations with Rest API, which based on the one Entity - User.</p>
<b>These endpoints:</b>
<p>
<ol>
<li>
For POST requests to create user (/users)
</li>
<li>
For GET requests to retrieve all users by page and limit - (/users/{page}/{limit})
</li>
<li>
For GET requests to retrieve the one user by id - (/users/{id})
</li>
<li>
For PUT requests to update data (only first_name and last_name are allowed)  - (/users/{uuid})
</li>
<li>
For DELETE requests to delete user by id - {/user/{uuid}}
</li>
</ol>
</p>
<b>
Some conditions in technical documentation were about:
</b>
<p>
<ol>
<li>User emails need to be unique</li>
<li>Properties stored as DateTime in the database need to be returned as strings in API responses (in the ISO 8601 format).</li>
<li>User can have only one level of nesting per parent</li>
<li>Dates for updates, creations, and deletions should be stored as datetime in the database.</li>
<li>When deleting user, it should be a soft deletion</li>
<li>The request content-type should be application/json</li>
</ol>
</p>
