<?php

namespace App\Controllers;

use App\Models\UsuarioModel;

class Login extends BaseController
{
	public function index()
	{
		
		return view('login');
	}

	public function signIn()
	{
		// recupera valores do email senha do formulario
		$email = $this->request->getPost('inputEmail');
		$password = $this->request->getPost('inputPassword');
		
		// estacia usuariomodel
		$usuarioModel = new UsuarioModel();

		$dadosUsuario = $usuarioModel->getByEmail($email);
		if (count($dadosUsuario) > 0) { // se o contador maior que 0 hashUsuario recebe os dados d dadosusurario
			$hashUsuario = $dadosUsuario['senha'];
			if (password_verify($password, $hashUsuario)) {
				session()->set('isLoggedIn', true);
				var_dump($hashUsuario);
				session()->set('nome', $dadosUsuario['nome']);
				return redirect()->to(base_url('/welcome'));
			} else {
				session()->setFlashData('msg', 'Usuário ou Senha incorretos');
				return redirect()->to('/login');
			}
		} else {
			
			session()->setFlashData('msg', 'Usuário ou Senha incorretos');
			return redirect()->to('/login');
		}
	}

	public function signOut()
	{
		session()->destroy();
		return redirect()->to(base_url());
	}

	//--------------------------------------------------------------------

}
