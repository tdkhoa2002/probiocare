<?php
namespace Modules\Core\Facades;

use Illuminate\Support\Facades\Facade;

class StylistFacade extends Facade
{
	public static function getFacadeAccessor() { return 'stylist'; }
}
