<?php
namespace App\Controllers;
use Pure\Bases\Controller;

/**
 * Controller de erro
 *
 * @version 1.0
 * @author Marcelo Gomes Martins
 */
class ErrorController extends Controller
{

	/**
	 * Método carregado ao acessar a rota
	 * CaCln/error/deny
	 *
	 * Rota de resposta para acesso negada
	 */
	public function deny_action()
	{
		$this->render('deny', 'minimal');
	}

	/**
	 * Painel de administração
	 * CaCln/error/index
	 *
	 * Rota de resposta para falhas
	 */
	public function index_action(){
		$this->render('error', 'minimal');
	}

}