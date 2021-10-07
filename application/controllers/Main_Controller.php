<?php
defined('BASEPATH') OR exit('No direct script access allowed');

	class Main_Controller extends CI_Controller
	{
		function __construct()
		{
			parent::__construct();
			$this->load->model('Game_Model', 'model');
		}

		public function index()
		{
			
			$names['games'] = $this->model->getLastFiveMatches();
			$this->load->view('player_name_view', $names);	
		}
		
		public function submit()
		{
			
			$result = $this->model->submit();
			
			redirect(base_url('Main_Controller/game', $result));
		}

		public function game()
		{
			$names['games'] = $this->model->getPlayerNames();
			$this->load->view('game_view', $names);
		}

		public function saveResult()
		{
			$result = $this->model->saveResult();			
			redirect(base_url('Main_Controller/results', $result));
		}

		public function results()
		{
			$config = array();
			$config["base_url"] = base_url(). "Main_Controller/results";
			$config["total_rows"] = $this->model->results_count();
			$config["per_page"] = 10;
			$config["uri_segment"] = 3;

			$this->pagination->initialize($config);

			$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
			$data["results"] = $this->model->fetchResults($config["per_page"], $page);
			$data["links"] = $this->pagination->create_links();

			$this->load->view('results_view', $data);
		}

		public function submitPlayerVsComp()
		{
			$result = $this->model->savePlayerVsComp();

			redirect(base_url('Main_Controller/PlayerVsComp', $result));
		}

		public function PlayerVsComp()
		{
			$names['games'] = $this->model->getPlayerNames();
			$this->load->view('game_vs_comp_view', $names);
		}
	}
?>