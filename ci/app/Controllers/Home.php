<?php

namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
		// echo view('index');
		return redirect()->to(base_url('access'));
	}
	public function quizcode()
	{
		$var = new \App\Models\Variables();
		$data = [
			'quizinput' => $var->where('key', 'quizinput')->find()[0]['value'],
		];
		echo view('header');
		echo view('access', $data);
		echo view('footer');
	}
	public function message($msg, $title = '')
	{
		$data = [
			'msg' => $msg,
			'title' => $title,
		];
		echo view('header');
		echo view('msg', $data);
		echo view('footer');
	}
	public function processcode()
	{
		$incoming = $this->request->getGet();
		// $code = $incoming['code'];
		$session = session();


		$quizlet = new \App\Models\Quiz();
		if (!empty($db = $quizlet->where($incoming)->find())) {
			$res = $db[0];

			$ses_data = [
				'quiz' => $res['id'],
				'code' => $res['code'],
				'title' => $res['title'],
				'description' => $res['description'],
				'published' => $res['published']
			];
			$session->set($ses_data);
			return redirect()->to(base_url('/login'));
		} else {
			$this->message('The Quiz code you entered is incorrect');
		}
	}

	public function login()
	{
		$session = session();
		if ($session->code == '') {
			return redirect()->to(base_url('/access'));
		} else {
			echo view('header');
			echo view('login');
			echo view('footer');
		}
	}

	public function questions()
	{
		$session = session();
		if ($session->Logged_in != true) {
			return redirect()->to(base_url('/login'));
		} else {
			$quizlet = new \App\Models\Quiz();
			$code = $session->code;

			$res = $quizlet->where('code', $code)->find()[0];
			echo view('question', $res);
		}
	}

	public function postquiz()
	{
		$session = session();
		$quizlet = new \App\Models\Quiz();
		$scoresheet = new \App\Models\Scoresheet();
		$code = $session->code;
		$incoming = $this->request->getPost();
		$numbs = range(0, 14);
		$score = 0;

		$res = $quizlet->where('code', $code)->find()[0]['answers'];
		foreach (json_decode($res) as $key => $ans) {
			if (!empty($incoming[$key . 'que' . $key])) {
				if ($incoming[$key . 'que' . $key] == strtolower($ans->ans)) {
					$score++;
				} else {
					$score = $score + 0;
				}
			} else {
				$score = $score + 0;
			}
		}
		// Push the score to the broadsheet

		if (!empty($db = $scoresheet->where(['user' => $session->user, 'quiz' => $session->quiz])->find())) {
			if ($score > $db[0]['score']) {
				$scoresheet->update($db[0]['id'], ['score' => $score]);
			}
		} else {
			$data = ['user' => $session->user, 'quiz' => $session->quiz, 'score' => $score, 'sent' => $session->published];
			$scoresheet->insert($data);
		}

		if ($session->published) {
			$this->message("Your score is " . $score);
		} else {
			$this->message("Your Quiz has been submitted. You will receive your score via email");
		}
	}

	public function test($code, $do)
	{
		if ($do) {
			$key = ' !u^e_%a#t@';
			$pos = str_split($code);
			$res = '';
			foreach ($pos as $ky => $ps) {
				$res = $res . str_split($key)[$ps];
			}
			return urlencode($res);
		} else {
			$key = ' !u^e_%a#t@';
			$pos = urldecode($code);
			$res = '';
			$pos = str_split($pos);
			$key = str_split($key);
			foreach ($pos as $k => $os) {
				foreach ($key as $ky => $ps) {
					if ($pos[$k] == $ps)
						$res = $res . $ky;
				}
			}
			return $res;
		}
	}

	public function solution($id)
	{
		$id = $this->test($id, 0);
		echo ('<center>Solution for quiz '.$id.'</center><br>');
		$quizlet = new \App\Models\Quiz();
		// $id = md
		$res = $quizlet->where('code', $id)->find()[0]['answers'];
		$que = $quizlet->where('code', $id)->find()[0]['questions'];
		foreach (json_decode($que) as $ky => $qus) {
			echo ('('.($ky + 1) . ') ' . $qus->{0} . '<br>');
			$option = [
				'a' => $qus->{1},
				'b' => $qus->{2},
				'c' => $qus->{3},
				'd' => $qus->{4},
			];
			foreach (json_decode($res) as $key => $ans) {
				if ($qus->id == $ans->id) {
					foreach ($option as $key => $opt) {
						echo ($key.') '.$opt);
						if ($ans->ans == $key) {
							echo (' &#x1f4cc');
						}
						echo '<br>';
					}
					echo '<br>';
				}
			}
		}
	}

	public function postlogin()
	{
		$Users = new \App\Models\Users();
		$Scoresheet = new \App\Models\Scoresheet();
		$session = session();
		$incoming = $this->request->getPost();
		$incoming['password'] = $incoming['password'];
		$incoming['clearance'] = 1;

		if (!empty($db = $Users->where($incoming)->find())) {
			if ($res = $Scoresheet->where(['user' => $db[0]['id'], 'quiz' => $session->quiz])->find()) {
				$this->message('A score has been recorded for this user on this particular quiz');
			} else {
				$ses_data = [
					'email' => $db[0]['email'],
					'user' => $db[0]['id'],
					'Logged_in' => TRUE,
					'clearance' => $db[0]['clearance']
				];
				$session->set($ses_data);
				return redirect()->to(base_url('/questions'));
			}
		} else {
			try {
				$db_id = $Users->insert($incoming);
				$db = $Users->where('id', $db_id)->find();
				$ses_data = [
					'email' => $db[0]['email'],
					'user' => $db[0]['id'],
					'Logged_in' => TRUE,
					'clearance' => $db[0]['clearance']
				];
				$session->set($ses_data);
				return redirect()->to(base_url('/questions'));
			} catch (\Exception $e) {
				$this->message('Email has been used before with a different phone number');
			}
		}
	}

	//--------------------------------------------------------------------

}
