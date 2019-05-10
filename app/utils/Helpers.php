<?php
namespace App\Utils;
use Pure\Utils\DynamicHtml;
use DateTime;
use Pure\Utils\Res;

/**
 * Classe de apoio para o desenvolvedor no desenvolvimento
 * centraliza métodos práticos que podem ser chamados a qualquer momento
 *
 * @version 1.0
 * @author Marcelo Gomes Martins
 */
class Helpers
{
	/**
	 * Cria código HTML referente a um breadcrumb boostrap
	 *
	 * @param mixed $self objeto atual da página
	 * @param mixed $crumbs caminho até esse objeto
	 * @return string HTML
	 */
	public static function breadcrumb($self, $crumbs)
	{
		$html = '<div class="row">';
		$html .= '<div class="col-md-12 content-category">';
		$html .= '<ol class="breadcrumb">';
		foreach($crumbs as $name => $url)
		{
			$html .= '<li><a href="' . DynamicHtml::link_to($url) . '">' . $name . '</a></li>';
		}
		$html .= '<li class="active">' . $self . '</li>';
		$html .= '</ol></div></div>';
		return $html;
	}

	/**
	 * Formata data e hora para padrão de exibição
	 * @param mixed $time data padrão americano
	 * @return string data
	 */
	public static function date_format($time)
	{
		$timestamp = strtotime($time);
		return date('d/m/Y G:i', $timestamp);
	}

	public static function interval_format($starts, $ends) {
		$ts_starts = strtotime($starts);
		$ts_ends = strtotime($ends);
		if (date('d/m/Y', $ts_starts) == date('d/m/Y', $ts_ends)){
			return 'De ' . date('d/m/Y', $ts_starts) . ' das ' . date('G:i', $ts_starts) . ' às ' . date('G:i', $ts_ends);
		} else {
			return 'De ' . date('d/m/Y', $ts_starts) . ' a ' . date('d/m/Y', $ts_ends);
		}
	}

	/**
	 * Gera um elemento HTML de paginação
	 * @param mixed $limit limite de itens por página
	 * @param mixed $count contagem de itens totais
	 * @param mixed $page número de página
	 * @return string elemento DOM
	 */
	public static function pagination($limit, $count, $page)
	{
		$pages = ($count % $limit) ? intval($count / $limit) + 1 : $count / $limit;
		$html = '<ul class="pagination text-center">';
		$max_enum = 6;
		if ($pages > $max_enum) {
			if ($page < $max_enum) {
				for($i = 1; $i <= $max_enum; $i++){
					if($i == $page){
						$html .= '<li class="page active"><a href="#">' . $i .'</a></li>';
					} else {
						$html .= '<li class="page"><a href="">' . $i . '</a></li>';
					}
				}
				$html .= '<li class="page"><a href="#">...</a></li>';
				$html .= '<li class="page"><a href="">' . $pages . '</a></li>';
			} else if ($page > ($pages - $max_enum))
			{
				$html .= '<li class="page"><a href="">1</a></li>';
				$html .= '<li class="page"><a href="#">...</a></li>';
				for($i = ($pages - $max_enum); $i <= $pages; $i++){
					if($i == $page){
						$html .= '<li class="page active"><a href="#">' . $i .'</a></li>';
					} else {
						$html .= '<li class="page"><a href="">' . $i . '</a></li>';
					}
				}
			} else {
				$html .= '<li class="page"><a href="">1</a></li>';
				$html .= '<li class="page"><a href="#">...</a></li>';
				for($i = $page - ($max_enum / 2); $i <= $page + ($max_enum / 2); $i++){
					if($i == $page){
						$html .= '<li class="page active"><a href="#">' . $i .'</a></li>';
					} else {
						$html .= '<li class="page"><a href="">' . $i . '</a></li>';
					}
				}
				$html .= '<li class="page"><a href="#">...</a></li>';
				$html .= '<li class="page"><a href="">' . $pages . '</a></li>';
			}
		} else {
			for($i = 1; $i <= $pages; $i++){
				if($i == $page){
					$html .= '<li class="page active"><a href="#">' . $i .'</a></li>';
				} else {
					$html .= '<li class="page"><a href="">' . $i . '</a></li>';
				}
			}
		}
		$html .= '</ul>';
		return $html;
	}

	/**
	 * Normaliza o padrão UFRGS para 8 caracteres
	 *
	 * @param mixed $ufrgs cartão UFRGS
	 * @return string cartão normalizado
	 */
	public static function ufrgs_normalize($ufrgs)
	{
		return str_pad($ufrgs, 8, "0", STR_PAD_LEFT);
	}

	/**
	 * Verifica se o cartão UFRGS é um número válido entre 1 e 99999999
	 *
	 * @param mixed $ufrgs cartão UFRGS
	 * @return boolean resposta
	 */
	public static function assert_ufrgs($ufrgs)
	{
		$value = intval($ufrgs);
		return ($value < 100000000 && $value > 0);
	}

    /**
     * Gera uma palavra aleatória com alfanumericos
     *
     * @param mixed $length tamanho da string
	 * @return string palavra aleatoria
     */
	public static function get_rnd_str($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}

    /**
     *  Recupera o ip do usuário
     *
     */
	public static function get_client_ip() {
		$ipaddress = '';
		if (getenv('HTTP_CLIENT_IP'))
		{
			$ipaddress = getenv('HTTP_CLIENT_IP');
		}
		else if(getenv('HTTP_X_FORWARDED_FOR'))
		{
			$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
		}
		else if(getenv('HTTP_X_FORWARDED'))
		{
			$ipaddress = getenv('HTTP_X_FORWARDED');
		}
		else if(getenv('HTTP_FORWARDED_FOR'))
		{
			$ipaddress = getenv('HTTP_FORWARDED_FOR');
		}
		else if(getenv('HTTP_FORWARDED'))
		{
			$ipaddress = getenv('HTTP_FORWARDED');
		}
		else if(getenv('REMOTE_ADDR'))
		{
			$ipaddress = getenv('REMOTE_ADDR');
		} else {
			$ipaddress = 'UNKNOWN';
		}
		return $ipaddress;
	}

	/**
	 * Verifica se a conexão atual do usuário está dentro da rede UFRGS.
	 * Prefixo "143.54"
	 *
	 * @return boolean
	 */
	public static function is_ufrgs_network() {
		if(strpos(Helpers::get_client_ip(), '143.54.') !== false) {
			return true;
		}
		return false;
	}

    /**
     * Remove as iniciais dos icones glyphicon ou fa
     */
	public static function normalize_icon($icon) {
		if(strpos($icon, 'glyphicon') !== false) {
			return str_replace('glyphicon-', '', $icon);
		} else {
			return str_replace('fa fa-', '', $icon);
		}
	}

	/**
	 * Normaliza URL
	 *
	 * @param mixed $url
	 * @return string
	 */
	public static function normalize_url($url) {
		if(strpos($url, 'http') !== false) {
			return strtolower($url);
		} else {
			return 'http://' . strtolower($url);
		}
	}

	/**
	 * Salva arquivo ZIP com a partir da URL de upload
	 * Salva com nome aleatório e retorna o nome gerado.
	 *
	 * @param mixed $uploaded local do arquivo temp (onde foi feito o upload)
	 * @param mixed $destination local onde o arquivo deve ser salvo dentro da estrutura de pastas 'app/assets/processes/'
	 * @return \boolean|string local onde foi salvo ou "false"
	 */
	public static function save_zip_file($uploaded, $destination) {
		$zip = new \ZipArchive;
		$path = $destination . hash('sha256', Helpers::get_rnd_str(256)) . '/';
		mkdir(BASE_PATH . $path);
		if (!empty($uploaded) && $zip->open($uploaded) === true) {
			for ($i = 0; $i < $zip->numFiles; $i++) {
				$filename = $zip->getNameIndex($i);
				if(strpos($filename, '/', strlen($filename) - 1) !== false){
					mkdir(BASE_PATH . $path . $filename, 0755, true);
				} else {
					copy('zip://' . $uploaded . '#' . $filename, BASE_PATH . $path . $filename);
				}
			}
		} else {
			return false;
		}
		$zip->close();
		return $path;
	}

	/**
	 * Formata endereço MAC de XXXXXXXXXXXX para XX:XX:XX:XX:XX:XX.
	 *
	 * @param string $mac MAC em formato XXXXXXXXXXXX
	 * @return string MAC em formato XX:XX:XX:XX:XX:XX
	 */
	public static function format_mac($mac) {
		return substr($mac, 0, 2) . ':' .
			substr($mac, 2, 2) . ':' .
			substr($mac, 4, 2) . ':' .
			substr($mac, 6, 2) . ':' .
			substr($mac, 8, 2) . ':' .
			substr($mac, 10, 2);
	}

	/**
	 * Retorna o nome da licenças de acordo com a seguinte definição:
	 * 1. Windows
	 * 2. OEM
	 * 3. Office
	 * Outras
	 *
	 * @param mixed $number representação
	 * @return string nome da licença
	 */
	public static function format_license_type($number) {
		switch($number){
			case 1:
				return 'Microsoft Windows Registry License';
			case 2:
				return 'Microsoft Windows OEM License';
			case 3:
				return 'Microsoft Office License';
			default:
				return 'Generic License';
		}
	}

	public static function datetime_to_sql($date) {
		return date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $date)));
	}

	public static function deserialize_version($str_version) {
		return (int)str_replace('.', '', $str_version);
	}

	public static function get_random_color()
	{
		$r = rand(0,256);
		$g = rand(0,256);
		$b = rand(0,256);
		return [
			'red' => $r,
			'green' => $g,
			'blue' => $b
		];
	}

	public static function get_aesthetically_color_from($color = null)
	{
		if ($color == null) {
			return self::get_random_color();
		}

		return [
			'red' => (rand(0,256) + $color['red']) / 2,
			'green' => (rand(0,256) + $color['green']) / 2,
			'blue' => (rand(0,256) + $color['blue']) / 2
		];
	}

	public static function format_color_set($color)
	{
		$r = $color['red'];
		$g = $color['green'];
		$b = $color['blue'];

		return [
			'bg' => "rgba($r, $g, $b, 0.3)",
			'bd' => "rgba($r, $g, $b, 1)"
		];
	}

	public static function minutes_diff($date,  $compare)
	{
		if(is_a($date, 'DateTime') && is_a($compare, 'DateTime')) {
			$since = $date->diff($compare);
			$minutes = $since->days * 24 * 60;
			$minutes += $since->h * 60;
			$minutes += $since->i;
			return $minutes;
		}
		return 0;
	}

	public static function build_success_response($res_str, $target_name)
	{
		$s = Res::arr($res_str);
		return [
			'title' => $s['title'],
			'body' => $s['body_p1'] . $target_name . $s['body_p2']
		];
	}

	public static function set_error_from_env($dev_error_msg, $prd_error_msg)
	{
		if(PURE_ENV ===  'development') {
			return $dev_error_msg;
		} else {
			return $prd_error_msg;
		}
	}

	public static function str_limit($input, $limit)
	{
		return strlen($input)  > $limit ? substr($input, 0, 30) . '...' : $input;
	}

	public static function parse_to_js($var, $var_name)
	{
		return '<script type="text/javascript">var ' . $var_name . ' = ' . json_encode($var) . '</script>';
	}

}