<?php

class ViewHelper {

	/*
	 * Simple foreach wrapper so that we can simplify our views where we're just displaying an array
	 */
	public static function displayArray($arr, $format = null)
	{
		$ret = '';

		if ($arr !== null && is_array($arr))
		{
			foreach ($arr as $msg)
			{
				if (isset($format))
				{
					$ret .= str_replace(':message', $msg, $format);
				} else
				{
					$ret .= $msg;
				}
			}
		}

		return $ret;
	}

	public static function displayAlerts($alerts, $type, $dismissible = true)
	{
		if (!in_array($type, ['success', 'info', 'warning', 'danger']))
			trigger_error('"' . $type . '" is not a valid alert type.');

		$dismissibleButton = '';
		$dismissibleClass = '';

		if ($dismissible)
		{
			$dismissibleButton = '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
			$dismissibleClass = 'alert-dismissible';
		}

		$format = '<div class="alert alert-' . $type . ' ' . $dismissibleClass . '" role="alert">' . $dismissibleButton . ':message</div>';

		return self::displayArray($alerts, $format);
	}

}

class FlashHelper {

	// http://stackoverflow.com/questions/19777837/is-it-possible-to-store-an-array-as-flash-data-in-laravel

	/*
	 * Behaves similar to Session::push, but for flash values.
	 * The difference is that it does not explode the key on periods, so append('test.key') will append to ['test.key']
	 */
	public static function append($key, $value)
	{
		$values = Session::get($key, []);
		$values[] = $value;
		Session::flash($key, $values);
	}

}