
<h1>Short Description</h1>
<p>I did test crud operations with Rest API, which based on the one Entity - User.</p>
<b>These endpoints:</b>
<p>
<ol>
<li>
For post requests to create user (/users)
</li>
<li>
For get requests to get all users by page and limit - (/users/{page}/{limit})
</li>
<li>
For get requests to get the one user by id - (/users/{id})
</li>
<li>
For put requests to update data (first_name, last_name only) - (/users/{uuid})
</li>
<li>
For delete requests to delete user by id - {/user/{uuid}}
</li>
</ol>
</p>
<b>
Some conditions in technical documentation were about:
</b>
<p>
<ol>
<li>User email need to be unique</li>
<li>Some properties , which is stored in DB as DateTime need to be string(ISO 8601) in API responses</li>
<li>User can have only one level of nesting per parent</li>
<li>Dates (update,create,delete) should be stored as date time in database
<li>Deleting an user should be soft</li>
<li>Request content-type should be application/json</li>
</ol>
</p>
