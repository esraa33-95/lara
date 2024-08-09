<h1 style="color:red">Path Traversal Attacks</h1>
<p>exploits vulnerabilities in applications that handle file paths.</p>
<p>attackers can access files and directories outside the intended scope,to get sensitive information.</p>
<h2 style="color:red">Common techniques:</h2>
1.Using ".." sequences:
<p>attacker inserts multiple "../" to navigate up the directory structure.<p>
2.Absolute paths: 
<p>Trying to access files using absolute paths instead of relative ones.</p>

<h3 style="color:green">Double Encoding</h3>

<p>it is a technique where characters are encoded twice, often in hexadecimal format.</p>
<p> This can be used to bypass input validation and filtering mechanisms.</p>
<p style="color:yellow">Example:</p>

1.Single encoded: %2e%2e%2f represents "../".

2.Double encoded: %252e%252e%252f represents "%2e%2e%2f".

<b style="color:purple">Attackers often combine path traversal and double encoding to enhance their chances of success.</b>

<p style="color:green">To protect against path traversal and double encoding attacks</p>

<li>Input validation: </li>
<p>Strictly validate and sanitize user-supplied input before using it in file paths.</p>

<li>Whitelisting:</li>
<p> Allow only a predefined set of characters or file paths.</p>

<li>Canonicalization:</li> 
<p>Normalize file paths to prevent manipulation.</p>

<li>Encoding detection and decoding:</li> <p>Detect and decode multiple encoding layers.</p>

<li>Least privilege:</li> 
<p>Grant applications only the necessary permissions to access files.</p>

<h3 style="color:green">protection in laravel</h3>

1.Strict Input Validation:Use regular expressions or Laravel's validation rules to ensure input matches expected patterns.

2.Leverage Laravel's Storage System:Use the Storage facade to interact with files within the storage directory.

3.Secure File Uploads:
Validate file types, sizes, and names.
Store files in secure locations.

4.Use Laravel's built-in helpers for encoding and decoding.

5.Keep Laravel Updated:Stay up-to-date with Laravel versions to benefit from security patches.



