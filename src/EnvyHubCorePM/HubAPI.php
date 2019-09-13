<?php

namespace EnvyHubCorePM;


class HubAPI {

	private $main;

	public function __construct(MainClass $main) {
		$this->main = $main;
	}
}
