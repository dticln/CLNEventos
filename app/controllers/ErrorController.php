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
	 * Rota de resposta para acesso negada (usuário sem permissão para acesso)
	 */
	public function deny_action()
	{
		$this->render('deny', 'minimal');
	}

	/**
	 * Método carregado ao acessar a rota
	 * CaCln/error/index
	 *
	 * Rota de resposta para falhas (não foi possível encontrar a página)
	 */
	public function index_action(){
		$this->render('error', 'minimal');
	}

}