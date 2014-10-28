<?php
/*
 * http://www.laravel-tricks.com/tricks/navigation-menus-using-unordered-lists
We will create a navigation menu like this:
{{ HTML::nav(array('login', 'register', 'wiki', 'forum', '/' => 'Home')) }}

Which will output:
<ul>
    <li><a href="yourdomain.com/login" class="active">Login</a></li>
    <li><a href="yourdomain.com/register">Register</a></li>
    <li><a href="yourdomain.com/wiki">Wiki</a></li>
    <li><a href="yourdomain.com/forum">Forum</a></li>
    <li><a href="yourdomain.com">Home</a></li>
</ul>

Just make sure to load your macro.
*/

// HTMLMacro.php
HTML::macro('nav', function ($list, $attributes = null)
{
	$nav = [];

	// iterate through each element of the array and get url => link pairs
	foreach ($list as $key => $val)
	{
		// Sometimes we want to pass a condition and display link based on the condition
		// (ex: dispaly login vs. logout link based on if user is logged in),
		// in this case, an array will be passed instead of a string.
		// The first value will be the condition, 2nd and 3rd will be the links
		if (is_array($val))
		{
			$condition = $val[0];

			// set url to the keys of the array
			$link = array_keys($val);

			// sometimes we don't want to display any link if the condition isn't met,
			// then we need to check if a 2nd link is omitted
			$link[2] = array_key_exists(2, $link) ? $link[2] : null;

			// check to see if condition passes
			$key = $condition ? $link[1] : $link[2];

			// if a second link isn't passed, then stop the current loop at this point
			// and skip to the next loop
			if (is_null($key))
			{
				continue;
			}

			$val = $val[$key];
		}

		// Check to see if both url and link is passed
		// Many times, both url and link name will be the same, so we can avoid typing it twice
		// and just pass one value
		// In this case, the key will be numeric (when we just pass a value instead of key => value pairs)
		// We will have to set the url to equal the key instead
		$url = is_numeric($key) ? $val : $key;

		// If we are using controller routing (ex: HomeController@getIndex),
		// then we need to use URL::action() instead of URL::to()
		$url = (strpos($url, '@') !== false) ? URL::action($url) : URL::to(strtolower($url));

		// Push the new list into the $nav array
		array_push($nav, (object)[
			'link' => HTML::link($url, $val),

			// determine which link is active
			'classes' => (Request::url() === $url) ? 'active' : '',
		]);
	}

	// menu contents
	$contents = '';

	// generate our own ul so that we can control which li has the active class
	foreach ($nav as $item)
	{
//        dd($item);
		$contents .= '<li class="' . $item->classes . '">' . e($item->link) . "</li>\n";
	}

	$menu = "<ul" . HTML::attributes($attributes) . ">{$contents}</ul>\n";


	// Generate the unordered list
//    $menu = HTML::ul($nav, $attributes);
	// HTML::ul() performs htmlentities on the list by default,
	// so we have to decode it back using HTML::decode()
	$menu = HTML::decode($menu);

	// Return the generated menu
	return $menu;
});