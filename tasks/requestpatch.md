<h1 style="color:red">patch request</h1>
<ul style="color:">
<li>
In Laravel, the PATCH method is used to partially update a resource. 
</li>

<li>modify specific fields of a model without affecting the entire record
</li>
</ul>

<h2 style="color:green">1.Define the route:</h2>
<p style="color:orange">
Route::patch('/users/{user}', [UserController::class, 'update']);</p>

<h2 style="color:green">When to use which:</h2>

<b style="color:red">PUT:</b>
<p> When you want to replace the entire resource with a new version.</p>

<b style="color:red">PATCH:</b> 
<p>When you want to make specific modifications to a resource without replacing the entire thing.</p>

<h3 style="color:green">Example</h3>

-Imagine you have a user profile with fields like name, email, and address.

<b style="color:red">PUT:</b> 
<p>To update the entire profile with new information, you would use a PUT request and send all the user data.</p>

<b style="color:red">PATCH:</b>
<p> To change only the user's email address, you would use a PATCH request and send only the new email value.</p>


