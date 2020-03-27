<?php
namespace OCA\SkeletonApp\Controller;

use OCP\IRequest;
use OCP\AppFramework\Controller;

use function GuzzleHttp\json_encode;

class TestController extends Controller
{
	public function __construct($appName, IRequest $request)
	{
		parent::__construct($appName, $request);
	}

    public function index()
    {
        $currentDate = date("Y/m/d h:i:sa");
        return json_encode([
                currentDate => 'The current date and time is '.$currentDate
				    ]);
		}

		public function displayButton()
		{
			return true;
		}
}
