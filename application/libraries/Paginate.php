<?php

class Paginate
{
	private $limit;
	private $total;
	private $start;
	private $pages;
	private $page;

	public function __construct()
	{
		$this->input = &get_instance()->input;
	}

	public function make($total)
	{
		$this->setData($total);
		$numEndPage = (($this->limit * $this->page) > $this->total) ? $this->total : ($this->limit * $this->page);
		$html = '<div data-section="footer">';
			$html .= '<p class="exibicao">Página ' . $this->page . ' - Exibindo de ' . ($this->start + 1) . ' a ' . $numEndPage . ' de ' . $this->total . ' registros</p>';
			$html .= '<div data-section="pagination">';
				if ($this->page == 1) {
					$html .= '<p>Primeiro</p>';
				} else {
					$html .= '<a href="?' . $this->changeQueryString('page', 1) . '">Primeiro</a>';
				}

				if ($this->page - 1 <= 0) {
					$html .= '<p>Anterior</p>';
				} else {
					$html .= '<a href="?' . $this->changeQueryString('page', ($this->page - 1)) . '">Anterior</a>';
				}

				for ($i = 1; $i <= $this->pages; $i++) {
					if ($this->page == $i) {
						$html .= '<p>' . $i . '</p>';
					} else {
						$html .= '<a href="?' . $this->changeQueryString('page', $i) . '">' . $i . '</a>';
					}
				}

				if ($this->page + 1 > $this->pages) {
					$html .= '<p>Próximo</p>';
				} else {
					$html .= '<a href="?' . $this->changeQueryString('page', ($this->page + 1)) . '">Próximo</a>';
				}

				if ($this->page == $this->pages) {
					$html .= '<p>Último</p>';
				} else {
					$html .= '<a href="?' . $this->changeQueryString('page', $this->pages) . '">Último</a>';
				}
			$html .= '</div>';
			$html .= '<div style="clear:both"></div>';
		$html .= '</div>';

		return $html;
	}

	public function changeQueryString($key, $value)
	{
		$qr = $this->input->get();
		$qr[$key] = $value;
		return http_build_query($qr);
	}

	private function setData($total)
	{
		$this->limit = ($this->input->get('limit')) ? $this->input->get('limit') : 10;
		$this->limit = (int) $this->limit;
		$this->page = ($this->input->get('page')) ? $this->input->get('page') : 1;
		$this->page = (int) $this->page;
		$this->total = $total;
		$this->start = ($this->limit * $this->page) - $this->limit;
		$this->pages = $this->total / $this->limit;
		$this->pages = ceil($this->pages);
	}

	public function getData()
	{
		$return = new stdClass;
		$return->limit = $this->limit;
		$return->total = $this->total;
		$return->start = $this->start;
		$return->pages = $this->pages;
		$return->page = $this->page;
		return $return;
	}
}