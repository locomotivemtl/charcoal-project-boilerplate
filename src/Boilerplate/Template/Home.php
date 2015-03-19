<?php

namespace Boilerplate\Template;

use \Charcoal\Model\Model as Model;

class Home extends Model
{
	public function test()
	{
		return 'TEST '.rand(0,100);
	}
}